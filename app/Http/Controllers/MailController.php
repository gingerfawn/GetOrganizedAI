<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPassword;



class MailController extends Controller
{
    public function resetPassword(Request $request)
        {
            // $user = User::where('email', $request->email)->first();

            // if (!$user) {
            //     return response()->json(['error' => 'User not found'], 404);
            // }

            // $temporaryPassword = Str::random(10);

            // $user->password = Hash::make($temporaryPassword);
            // $user->is_temp_pw = true;
            // $user->save();

            // Mail::to($user->email)->send(new ResetPassword($user->email, $temporaryPassword));

            // return redirect('/login?pw_reset=true');
        }
}
