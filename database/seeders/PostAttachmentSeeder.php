<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PostAttachment;

class PostAttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attachments = [
            [
                'id' => 1,
                'post_id' => 2,
                'file_name' => '9qPVGW0t0XHwZNjyMCtxOUYZwPO2CkZPBQt91KH1.jpg',
            ],
            [
                'id' => 2,
                'post_id' => 3,
                'file_name' => 'oEJzcq09XxciFSzR2YFeFyj3QcqsigYEr6wyh6ID.jpg',
            ],
            [
                'id' => 3,
                'post_id' => 4,
                'file_name' => '8eVI777MFtzDYh3YD8le0neEkMR0SusafQtZzvwK.jpg',
            ],
            [
                'id' => 4,
                'post_id' => 4,
                'file_name' => '9OGDt52Syxt3sAbwfwu2NeNLvLWyB9e7nVWUmMlF.jpg',
            ],
            [
                'id' => 5,
                'post_id' => 5,
                'file_name' => 'LlUy6CWwZANzCCDKy9ZivRlO6IHKD3U5QEcoeo31.jpg',
            ],
            [
                'id' => 6,
                'post_id' => 5,
                'file_name' => 'tU3mP8VuhQ6HCNalAmp5vFPgYusYUjDVU3X2uAQi.jpg',
            ],
            [
                'id' => 7,
                'post_id' => 7,
                'file_name' => '75tpENaIJMk28TuxgSXLlSdYC7PH8TEZAoNQVFGL.jpg',
            ],
        ];

        foreach ($attachments as $attachmentData) {
            PostAttachment::create($attachmentData);
        }
    }
}
