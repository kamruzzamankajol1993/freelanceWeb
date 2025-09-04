<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordResetController extends Controller
{
    /**
     * Send a password reset OTP to the user's email.
     */
    public function sendResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email|exists:users,email']);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::where('email', $request->email)->first();
        $otp = random_int(1000, 9999);

        // Store OTP and its expiration time on the user record
        $user->password_reset_otp = $otp;
        $user->password_reset_otp_expires_at = Carbon::now()->addMinutes(10); // OTP is valid for 10 minutes
        $user->save();

        try {
            // --- THIS SECTION HAS BEEN UPDATED AS PER YOUR REQUEST ---
            Mail::send('front.emails.otp', ['otp' => $otp], function($message) use($request){
                $message->to($request->email);
                $message->subject('Pick And Drop || password reset Otp ');
            });
            // --- END OF UPDATE ---
            
            return response()->json(['success' => true, 'message' => 'An OTP has been sent to your email.']);
        } catch (\Exception $e) {
            \Log::error('Password Reset OTP Send Error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Could not send OTP email. Please try again.'], 500);
        }
    }

    /**
     * Verify the provided OTP.
     */
    public function verifyResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::where('email', $request->email)
                    ->where('password_reset_otp', $request->otp)
                    ->where('password_reset_otp_expires_at', '>', Carbon::now())
                    ->first();

        if ($user) {
            // Clear the OTP fields after successful verification
            $user->password_reset_otp = null;
            $user->password_reset_otp_expires_at = null;
            $user->save();
            
            // Store email in session to use in the final step
            session(['password_reset_email' => $user->email]);

            return response()->json(['success' => true, 'message' => 'OTP verified successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid or expired OTP.'], 400);
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $email = session('password_reset_email');
        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Your session has expired. Please start over.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()],
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        $user = User::where('email', $email)->firstOrFail();
        
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user->customer) {
            $user->customer->password = $request->password; // Uses model mutator to hash
            $user->customer->save();
        }
        
        session()->forget('password_reset_email');

        return response()->json(['success' => true, 'message' => 'Password has been changed successfully! You can now log in.']);
    }
}

