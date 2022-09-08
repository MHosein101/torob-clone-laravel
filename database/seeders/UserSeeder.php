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
        
        $data = [ 
            [ 'email_or_number' => '09223334444' ] ,
            [ 'email_or_number' => 'example@mail.com' ] ,
            [ 'email_or_number' => '989118886666' ] ,
            [ 'email_or_number' => 'foo@bar.com' ] ,
            [ 'email_or_number' => '09887773333' ] ,
            [ 'email_or_number' => '09442229999' ]
        ];

        foreach($data as $set)
            User::create($set);
    }
}
