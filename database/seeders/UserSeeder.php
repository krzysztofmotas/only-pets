<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            User::truncate();
        });

        $seederPassword = Hash::make('1234');
        $users = [
            [
                // TODO: uzupełnić bio, website_url, avatar i background

                'name' => 'jankowalski',
                'display_name' => 'Jan Kowalski',
                'email' => 'jankowalski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Warszawa',
                'website_url' => '',
                'avatar' => '',
                'background' => '',
            ],
            [
                'name' => 'annanowak',
                'display_name' => 'Anna Nowak',
                'email' => 'annanowak@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Kraków',
                'website_url' => '',
                'avatar' => '',
                'background' => '',
            ],
            [
                'name' => 'piotrszymanski',
                'display_name' => 'Piotr Szymański',
                'email' => 'piotrszymanski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Gdańsk',
                'website_url' => '',
                'avatar' => '',
                'background' => '',
            ],
            [
                'name' => 'katarzynazajac',
                'display_name' => 'Katarzyna Zając',
                'email' => 'katarzynazajac@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Łódź',
                'website_url' => '',
                'avatar' => '',
                'background' => '',
            ],
            [
                'name' => 'michalgorski',
                'display_name' => 'Michał Górski',
                'email' => 'michalgorski@email.com',
                'password' => $seederPassword,
                'bio' => '',
                'location' => 'Wrocław',
                'website_url' => '',
                'avatar' => '',
                'background' => '',
            ],
        ];

        User::insert($users);

        $user = User::find(1);
        if ($user) {
            $user->role_id = User::ROLE_ADMIN;
            $user->save();
        }
    }
}
