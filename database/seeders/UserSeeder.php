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

        $users = [
            [
                'name' => 'kotszeryf',
                'display_name' => 'Kot Szeryf',
                'location' => 'Rzeszów',
                'bio' => 'Jestem Kot Szeryf, stróż praw i porządku na terenie Rzeszowa. Moja misja? Zapewnić, by każdy miał równy dostęp do smacznych przekąsek! 🐾',
                'website_url' => '',
                'avatar' => 'szeryf.jpeg',
                'background' => 'szeryf.jpg',
                'email' => 'kotszeryf@email.com',
            ],
            [
                'name' => 'chomikhenio',
                'display_name' => 'Chomik Henio',
                'location' => 'Warszawa',
                'bio' => 'Jestem energicznym chomikiem, który uwielbia biegać w swoim kółku i gryźć smaczne przekąski!',
                'website_url' => '',
                'avatar' => 'henio.jpg',
                'background' => 'henio.jpg',
                'email' => 'chomikhenio@email.com',
            ],
            [
                'name' => 'kroliczekbaska',
                'display_name' => 'Króliczek Baśka',
                'location' => 'Gdańsk',
                'bio' => 'Jestem puszystym królikiem, który uwielbia skakać po ogrodzie i jeść świeże warzywa.',
                'website_url' => '',
                'avatar' => 'baska.jpg',
                'background' => 'baska.jpg',
                'email' => 'kroliczekbaska@email.com',
            ],
            [
                'name' => 'kotkafiga',
                'display_name' => 'Kotka Figa',
                'location' => 'Łódź',
                'bio' => 'Jestem ciekawską kotką, która uwielbia wspinaczki, polowania na zabawki i długie drzemki na kanapie.',
                'website_url' => '',
                'avatar' => 'figa.jpg',
                'background' => 'figa.jpg',
                'email' => 'kotkafiga@email.com',
            ],
            [
                'name' => 'papugakasia',
                'display_name' => 'Papuga Kasia',
                'location' => 'Szczecin',
                'bio' => 'Jestem papugą, która uwielbia rozmawiać, śpiewać i naśladować dźwięki z otoczenia.',
                'website_url' => '',
                'avatar' => 'kasia.jpg',
                'background' => 'kasia.jpg',
                'email' => 'papugakasia@email.com',
            ],
        ];

        $seederPassword = Hash::make('1234');
        foreach ($users as $user) {
            $user['password'] = $seederPassword;
            User::create($user);
        }

        $user = User::find(1);
        if ($user) {
            $user->role_id = User::ROLE_ADMIN;
            $user->created_at = '2024-04-01 08:54:46';
            $user->save();
        }
    }
}
