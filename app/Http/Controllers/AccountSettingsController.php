<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\DeactivationLog; // We will create this model next

class AccountSettingsController extends Controller
{
    /**
     * Deactivate the user's account.
     */
    public function deactivate(Request $request)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $user = Auth::user();

        // 1. Log the reason
        DeactivationLog::create([
            'user_id' => $user->id,
            'action_type' => 'deactivate',
            'reason' => $request->reason,
        ]);

        // 2. Set user status to inactive (assuming 0 is inactive)
        $user->status = 0;
        $user->save();
        
        if ($user->customer) {
            $user->customer->status = 0;
            $user->customer->save();
        }

        // 3. Log the user out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true, 
            'message' => 'Your account has been deactivated.',
            'redirect_url' => route('home.index')
        ]);
    }

    /**
     * Permanently delete the user's account.
     */
    public function delete(Request $request)
    {
        $request->validate(['reason' => 'required|string|max:255']);

        $user = Auth::user();

        // 1. Log the reason
        DeactivationLog::create([
            'user_id' => $user->id,
            'action_type' => 'delete',
            'reason' => $request->reason,
        ]);

        $userId = $user->id;

        // 2. Log the user out first
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // 3. Delete the user (and related customer via model events or cascading deletes)
        $userToDelete = User::find($userId);
        if ($userToDelete) {
             // The customer record should be deleted automatically if you have
             // a foreign key with onDelete('cascade') in your customers migration.
             // If not, you should delete it manually here.
            $userToDelete->delete();
        }

        return response()->json([
            'success' => true, 
            'message' => 'Your account has been permanently deleted.',
            'redirect_url' => route('home.index')
        ]);
    }
}
