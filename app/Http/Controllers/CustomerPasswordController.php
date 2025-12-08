<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class CustomerPasswordController extends Controller
{
    // ======= FORM MINTA LINK RESET PASSWORD =======
    public function showLinkRequestForm()
    {
        return view('pelanggan.auth.passwords.email', [
            'title' => 'Lupa Password',
            'count' => 0,
        ]);
    }

    // ======= KIRIM EMAIL RESET PASSWORD =======
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers,email',
        ], [
            'email.exists' => 'Email tidak ditemukan dalam sistem kami.',
        ]);

        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))   // biar keliatan pesan aslinya
            : back()->withErrors(['email' => __($status)]);
    }

    // ======= TAMPILKAN FORM RESET PASSWORD =======
    public function showResetForm(Request $request, $token = null)
    {
        return view('pelanggan.auth.passwords.reset', [
            'title' => 'Reset Password',
            'token' => $token,
            'email' => $request->email,
            'count' => 0,
        ]);
    }

    // ======= PROSES RESET PASSWORD =======
    public function reset(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Customer $customer, $password) {
                $customer->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($customer));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('customer.login')->with('success', 'Password berhasil direset, silakan login kembali.')
            : back()->withErrors(['email' => __($status)]);   // sekarang kita tampilkan alasan asli
    }
}
