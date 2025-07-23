<?php

namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Validation\ValidationException;

    class LoginController extends Controller
    {
        /**
         * Tampilkan form login admin.
         *
         * @return \Illuminate\View\View
         */
        public function showLoginForm()
        {
            // Jika admin sudah login, arahkan ke dashboard
            if (Auth::guard('admin')->check()) {
                return redirect()->route('dashboard');
            }
            return view('auth.login');
        }

        /**
         * Tangani proses login admin.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function login(Request $request)
        {
            // Validasi input
            $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ]);

            // Coba otentikasi menggunakan guard 'admin'
            $credentials = $request->only('username', 'password');

            if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
                // Regenerasi sesi untuk mencegah session fixation attacks
                $request->session()->regenerate();

                // Arahkan ke dashboard setelah login berhasil
                return redirect()->intended(route('dashboard'));
            }

            // Jika otentikasi gagal, kembalikan dengan error
            throw ValidationException::withMessages([
                'username' => [trans('auth.failed')], // Pesan error standar Laravel untuk otentikasi gagal
            ]);
        }

        /**
         * Tangani proses logout admin.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function logout(Request $request)
        {
            Auth::guard('admin')->logout(); // Logout dari guard 'admin'

            $request->session()->invalidate(); // Invalidasi sesi
            $request->session()->regenerateToken(); // Regenerasi token CSRF

            return redirect()->route('login'); // Arahkan kembali ke halaman login
        }
    }
    
