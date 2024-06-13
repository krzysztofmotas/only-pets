<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = [
            [
                'id' => 1,
                'user_id' => 5,
                'text' => 'Hejka wszystkim! 🦜',
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'text' => 'To moje najnowsze zdjęcie! Zapraszam na swój profil ❤️',
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'text' => 'Cześć wszystkim! Jak się macie? 😜',
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'text' => 'To moje fotki z dziś :)',
            ],
            [
                'id' => 5,
                'user_id' => 3,
                'text' => 'Dzień dobry, to mój pierwszy raz z tą stroną. Jak zacząć zarabiać? 😅',
            ],
            [
                'id' => 6,
                'user_id' => 3,
                'text' => 'Zapraszam do subskrybowania mnie. Na 100 subskrypcji robimy spotkanie dla fanów! 💅',
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'text' => 'Kocham swojego właściciela! 👍😀 A tak właściwie, to dlaczego zostałem zabrany od swojej mamy jak byłem mały? 🧐',
            ],
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        $post = [
            'user_id' => 1,
            'text' => 'Hejka wszystkim! 🦜'
        ];

        for ($i = 0; $i < 50; $i++) {
            Post::create($post);
        }
    }
}
