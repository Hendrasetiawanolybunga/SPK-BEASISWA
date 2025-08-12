<?php

namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Admin; 
    use Illuminate\Support\Facades\Hash; 

    class AdminSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            if (!Admin::where('username', 'admin')->exists()) {
                Admin::create([
                    'username' => 'admin',
                    'email' => 'coding@gmail.com', 
                    'password' => Hash::make('admin123'), 
                ]);
                $this->command->info('Admin default berhasil dibuat!');
            } else {
                $this->command->info('Admin default sudah ada.');
            }
        }
    }
    