<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
       $data = [
            [
                'email_or_number' => 'example@mail.com' ,
                'history' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20] ,
                'favorites' => [1,2,3,4] ,
                'analytics' => [1]
            ] ,
            [
                'email_or_number' => '09998887777' ,
                'history' => [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20] ,
                'favorites' => [5,6,7,8,9,10] ,
                'analytics' => [2]
            ]
       ];

       foreach($data as $set)
            User::customCreate($set);
    }
}
