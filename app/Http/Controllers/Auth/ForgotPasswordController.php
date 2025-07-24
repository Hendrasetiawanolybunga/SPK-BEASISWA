<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\SendsPasswordResetEmails; 
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Password;

    class ForgotPasswordController extends Controller
    {
        use SendsPasswordResetEmails;

        /**
         * Tampilkan form untuk meminta link reset password.
         *
         * @return \Illuminate\View\View
         */
        public function showLinkRequestForm()
        {
            return view('auth.passwords.email'); // Akan kita buat view ini
        }

        /**
         * Dapatkan broker password yang digunakan untuk reset password.
         * Ini penting agar Laravel tahu guard mana yang harus digunakan.
         *
         * @return string
         */
        protected function broker()
        {
            return 'admins'; // Menggunakan password broker 'admins' yang didefinisikan di config/auth.php
        }

        /**
         * Kirim respons setelah link reset password berhasil dikirim.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $response
         * @return \Illuminate\Http\RedirectResponse
         */
        protected function sendResetLinkResponse(Request $request, $response)
        {
            return back()->with('status', trans($response));
        }

        /**
         * Kirim respons setelah link reset password gagal dikirim.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $response
         * @return \Illuminate\Http\RedirectResponse
         */
        protected function sendResetLinkFailedResponse(Request $request, $response)
        {
            return back()->withInput($request->only('email'))
                        ->withErrors(['email' => trans($response)]);
        }
    }
    