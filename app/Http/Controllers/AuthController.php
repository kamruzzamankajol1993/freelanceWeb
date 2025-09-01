<?php

namespace App\Http\Controllers;

use App\Mail\PasswordResetMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{

    public function resendOtp(Request $request)
    {
        $tempUserData = session('temp_user_data');

        if (!$tempUserData || !isset($tempUserData['email'])) {
            return response()->json(['error' => 'Your session has expired. Please register again.'], 422);
        }

        $otp = random_int(1000, 9999);
        $tempUserData['otp'] = $otp; // Update the OTP

        try {
            Mail::to($tempUserData['email'])->send(new OtpMail($otp));
            session(['temp_user_data' => $tempUserData]); // Resave the session data with the new OTP
            return response()->json(['message' => 'A new OTP has been sent to your email address.']);
        } catch (Exception $e) {
            \Log::error("OTP Resend failed: " . $e->getMessage());
            return response()->json(['error' => 'We could not send the verification email. Please try again later.'], 500);
        }
    }
    public function showRegistrationForm()
    {
        return view('front.register');
    }

    public function register(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users|unique:customers',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            // 'password' => [
            //     'required',
            //     'confirmed', // This checks for a matching 'password_confirmation' field
            //     Password::min(8)
            //         ->mixedCase() // Requires at least one uppercase and one lowercase letter
            //         ->numbers()   // Requires at least one number
            // ],
        ]);

        $otp = random_int(1000, 9999);
        $tempUserData = $request->all();
        $tempUserData['otp'] = $otp;

        // Temporarily store user data in session
        session(['temp_user_data' => $tempUserData]);

        // Send OTP email
        //Mail::to($request->email)->send(new OtpMail($otp));


        Mail::send('front.emails.otp', ['otp' => $otp], function($message) use($request){
                $message->to($request->email);
                $message->subject('Pick And Drop || Password Reset ');
            });

        return redirect()->route('otp.verification')->with('email', $request->email);
    }

    public function showOtpForm()
    {
        return view('front.otpcode');
    }

     public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $tempUserData = session('temp_user_data');
        if (!$tempUserData || $tempUserData['otp'] != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP']);
        }

        // 1. Create the User first to get a user ID
        $user = User::create([
            'name' => $tempUserData['name'],
            'email' => $tempUserData['email'],
            'phone' => $tempUserData['phone'],
            'address' => $tempUserData['address'],
            'password' => Hash::make($tempUserData['password']),
            'viewpassword' => $tempUserData['password'],
            'user_type' => 2,
        ]);

        // 2. Create the Customer and associate the user_id
        $customer = Customer::create([
            'name' => $tempUserData['name'],
            'email' => $tempUserData['email'],
            'phone' => $tempUserData['phone'],
            'status' => 1,
            'type' => 'normal',
            'address' => $tempUserData['address'],
            'password' => $tempUserData['password'], // Accessor in Customer model will hash this
            'slug' => Str::slug($tempUserData['name']),
            'user_id' => $user->id, // Storing user_id in customers table
        ]);

        // 3. Update the User with the customer_id
        // $user->customer_id = $customer->id;
        // $user->save();


        // Clear session data
        session()->forget('temp_user_data');

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard.user');
    }

    public function showLoginForm()
    {
        return view('front.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard-user');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // --- UPDATED DASHBOARD METHOD ---
     public function dashboarduser()
    {
        $user = Auth::user()->load('customer.addresses');
        $recentOrders = collect();
        $cancelOrders = collect();
        $billingAddress = null;
        $shippingAddress = null;
        if ($user->customer) {
            $user->customer->load(['orders' => function ($query) {
                $query->withCount('orderDetails')->latest();
            }]);
            $recentOrders = $user->customer->orders->where('status', '!=', 'cancel')->take(10);
            $cancelOrders = $user->customer->orders->where('status', 'cancel')->take(10);
            $billingAddress = $user->customer->addresses->where('address_type', 'billing')->where('is_default', 1)->first();
            $shippingAddress = $user->customer->addresses->where('address_type', 'shipping')->where('is_default', 1)->first();
            if (!$billingAddress) {
                $billingAddress = $user->customer->addresses->where('address_type', 'billing')->first();
            }
            if (!$shippingAddress) {
                $shippingAddress = $user->customer->addresses->where('address_type', 'shipping')->first();
            }
        }
        return view('front.dashboarduser', compact('user', 'recentOrders', 'cancelOrders', 'billingAddress', 'shippingAddress'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- NEW FORGOT PASSWORD METHODS ---

    public function showForgotPasswordForm()
    {
        // This method isn't strictly needed if you are only using a modal.
        // The modal can be part of your main layout.
        return view('front.home');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        try {
            Mail::to($request->email)->send(new PasswordResetMail($token, $request->email));
            return back()->with('status', 'We have emailed your password reset link!');
        } catch (Exception $e) {
            \Log::error("Password reset mail failed: " . $e->getMessage());
            return back()->withErrors(['email' => 'Could not send password reset email.']);
        }
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('front.password.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()],
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->withInput($request->only('email'))->withErrors(['email' => 'Invalid token or email.']);
        }

        if (Carbon::parse($resetRecord->created_at)->addMinutes(config('auth.passwords.users.expire', 60))->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withInput($request->only('email'))->withErrors(['email' => 'This password reset token has expired.']);
        }

        $user = User::where('email', $request->email)->firstOrFail();
        
        $user->password = Hash::make($request->password);
        $user->viewpassword = $request->password;
        $user->save();

        if ($user->customer) {
            $user->customer->password = $request->password; // Uses model mutator to hash
            $user->customer->save();
        }

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        Auth::login($user);
        return redirect()->route('dashboard.user')->with('status', 'Your password has been changed!');
    }

     // --- NEW ORDER TRACKING METHOD ---
    public function trackOrder(Request $request)
    {
        $request->validate(['invoice_no' => 'required|string']);

        $user = Auth::user();

        // Ensure the user has a customer profile
        if (!$user->customer) {
            return response()->json(['error' => 'No customer profile found for this user.'], 404);
        }

        $order = Order::where('invoice_no', $request->invoice_no)
                      ->where('customer_id', $user->customer_id)
                      ->withCount('orderDetails') // Get item quantity
                      ->first();

        if ($order) {
            // Manually format the date to ensure consistency
            $order->formatted_created_at = $order->created_at->format('d M Y');
            return response()->json($order);
        }

        return response()->json(['error' => 'Order not found or does not belong to you.'], 404);
    }

    // --- NEW PROFILE UPDATE METHOD ---
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id',$user->id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'billing_address' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $imageName = time().'.'.$request->profile_image->extension();
            $request->profile_image->move(public_path('uploads/avatars'), $imageName);
            $user->image = 'uploads/avatars/'.$imageName;
        }

        // Update User and Customer models
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        if ($customer) {
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->save();

            // Update or create billing address
            if ($request->billing_address) {
                CustomerAddress::updateOrCreate(
                    ['customer_id' => $customer->id, 'address_type' => 'billing'],
                    ['address' => $request->billing_address, 'is_default' => 1]
                );
            }

            // Update or create shipping address
            if ($request->shipping_address) {
                CustomerAddress::updateOrCreate(
                    ['customer_id' => $customer->id, 'address_type' => 'shipping'],
                    ['address' => $request->shipping_address, 'is_default' => 1]
                );
            }
        }

        return back()->with('status', 'Profile updated successfully!');
    }


    // --- NEW PASSWORD UPDATE METHOD ---
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'confirmed', PasswordRule::min(8)->mixedCase()->numbers()],
        ]);

        // Check if old password matches
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The provided password does not match your current password.']);
        }

        // Update password for User and Customer
        $newPasswordHashed = Hash::make($request->password);
        $user->password = $newPasswordHashed;
        $user->viewpassword = $request->password; // If you still need this
        $user->save();

        if ($user->customer) {
            $user->customer->password = $newPasswordHashed;
            $user->customer->save();
        }

        return back()->with('password_status', 'Password changed successfully!');
    }
}
