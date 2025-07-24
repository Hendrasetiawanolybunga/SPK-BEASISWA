<?php

    namespace App\Models;

    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Illuminate\Auth\Passwords\CanResetPassword; // Import trait ini
    use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract; // Import contract ini

    class Admin extends Authenticatable implements CanResetPasswordContract // Implementasikan contract
    {
        use Notifiable, CanResetPassword; // Gunakan trait ini

        protected $guard = 'admin';

        protected $fillable = [
            'username', 'email', 'password',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
    }
    