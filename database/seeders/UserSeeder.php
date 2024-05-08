<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        $seederPassword = Hash::make('1234');
        $users = [
            [
                // TODO: uzupełnić bio, website_url, picture i profile_background

                'name' => 'jankowalski',
                'display_name' => 'Jan Kowalski',
                'email' => 'jankowalski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Warszawa',
                'website_url' => '',
                'picture' => '',
                'profile_background' => '',
            ],
            [
                'name' => 'annanowak',
                'display_name' => 'Anna Nowak',
                'email' => 'annanowak@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Kraków',
                'website_url' => '',
                'picture' => '',
                'profile_background' => '',
            ],
            [
                'name' => 'piotrszymanski',
                'display_name' => 'Piotr Szymański',
                'email' => 'piotrszymanski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Gdańsk',
                'website_url' => '',
                'picture' => '',
                'profile_background' => '',
            ],
            [
                'name' => 'katarzynazajac',
                'display_name' => 'Katarzyna Zając',
                'email' => 'katarzynazajac@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Łódź',
                'website_url' => '',
                'picture' => '',
                'profile_background' => '',
            ],
            [
                'name' => 'michalgorski',
                'display_name' => 'Michał Górski',
                'email' => 'michalgorski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Wrocław',
                'website_url' => '',
                'picture' => '',
                'profile_background' => '',
            ],
        ];

        User::insert($users);
    }
}
