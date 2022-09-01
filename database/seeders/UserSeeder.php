<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([ 'email_or_number' => '09223334444' ]);
        User::create([ 'email_or_number' => 'example@mail.com' ]);
        User::create([ 'email_or_number' => '989118886666' ]);
        User::create([ 'email_or_number' => 'foo@bar.color' ]);

        // User::create([ 'email_or_number' => '' ]);
    }
}
