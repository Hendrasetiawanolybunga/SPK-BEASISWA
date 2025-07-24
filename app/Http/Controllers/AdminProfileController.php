<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;
    use Illuminate\Validation\Rule;

    class AdminProfileController extends Controller
    {
        /**
         * Tampilkan form untuk mengelola profil admin (username & email).
         *
         * @return \Illuminate\View\View
         */
        public function showProfileForm()
        {
            return view('admin.profile'); // View untuk username & email
        }

        /**
         * Tangani proses pembaruan profil admin (username & email).
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function updateProfile(Request $request)
        {
            $admin = Auth::guard('admin')->user();

            // Aturan validasi HANYA untuk username dan email
            $request->validate([
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('admins')->ignore($admin->id),
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('admins')->ignore($admin->id),
                ],
            ]);

            // Update username dan email
            $admin->username = $request->username;
            $admin->email = $request->email;
            $admin->save();

            // Redirect dengan pesan sukses
            return back()->with('success', 'Informasi profil berhasil diperbarui!');
        }

        /**
         * Tampilkan form untuk mengubah password admin.
         *
         * @return \Illuminate\View\View
         */
        public function showChangePasswordForm()
        {
            return view('admin.change-password'); // View untuk ubah password
        }

        /**
         * Tangani proses perubahan password admin.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function updatePassword(Request $request)
        {
            $admin = Auth::guard('admin')->user();

            // Aturan validasi untuk perubahan password
            $request->validate([
                'current_password' => ['required', 'string'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            // Verifikasi password saat ini
            if (!Hash::check($request->current_password, $admin->password)) {
                throw ValidationException::withMessages([
                    'current_password' => ['Password saat ini salah.'],
                ]);
            }

            // Update password baru
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            // Logout dari sesi saat ini dan arahkan kembali ke login
            // Ini adalah praktik keamanan yang baik setelah perubahan password
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Password Anda berhasil diubah. Silakan login kembali.');
        }
    }
    