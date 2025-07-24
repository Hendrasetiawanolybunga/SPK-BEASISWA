<?php

    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Foundation\Auth\ResetsPasswords; // Trait untuk mereset password
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Password;

    class ResetPasswordController extends Controller
    {
        use ResetsPasswords;

        /**
         * Where to redirect users after resetting their password.
         *
         * @var string
         */
        protected $redirectTo = '/dashboard'; // Arahkan ke dashboard setelah reset berhasil

        /**
         * Tampilkan form reset password.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  string|null  $token
         * @return \Illuminate\View\View
         */
        public function showResetForm(Request $request, $token = null)
        {
            return view('auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email] // Kirim token dan email ke view
            );
        }

        /**
         * Dapatkan guard yang digunakan untuk reset password.
         * Ini penting agar Laravel tahu guard mana yang harus digunakan.
         *
         * @return \Illuminate\Contracts\Auth\Guard
         */
        protected function guard()
        {
            return Auth::guard('admin'); // Menggunakan guard 'admin'
        }

        /**
         * Dapatkan broker password yang digunakan untuk reset password.
         * Ini penting agar Laravel tahu broker mana yang harus digunakan.
         *
         * @return string
         */
        protected function broker()
        {
            return 'admins'; // Menggunakan password broker 'admins'
        }

        /**
         * Kirim respons setelah password berhasil direset.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $response
         * @return \Illuminate\Http\RedirectResponse
         */
        protected function sendResetResponse(Request $request, $response)
        {
            return redirect($this->redirectPath())->with('status', trans($response));
        }

        /**
         * Kirim respons setelah password gagal direset.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  string  $response
         * @return \Illuminate\Http\RedirectResponse
         */
        protected function sendResetFailedResponse(Request $request, $response)
        {
            return back()->withInput($request->only('email'))
                        ->withErrors(['email' => trans($response)]);
        }
    }
    