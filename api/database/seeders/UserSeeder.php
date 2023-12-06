<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $roles = ['msg', 'meg', 'fsg', 'mbg'];

        foreach ($roles as $index => $role) {

            $user = User::create([
                'first_name' => $role,
                'last_name' => $role,
                'nationality' => 'NG',
                'email' => $role . "@fmdqgroup.com",
                'phone' => '0816667778' . $index,
                'password' => Hash::make('password'),
                'approval_status' => 'approved',
                'role_id' => $index,
                'institution_id' => null,
                'position_id' => null,
                'verified_at' => now(),
            ]);

            $user->passwords()->create([
                'password' => Hash::make('password'),
            ]);

        }

    }
}
