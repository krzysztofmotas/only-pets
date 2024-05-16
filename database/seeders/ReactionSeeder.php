<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Reaction;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            Reaction::truncate();
        });

        Reaction::insert([
            ['name' => 'Lubię to!', 'emoji' => '👍'],
            ['name' => 'Super', 'emoji' => '❤️'],
            ['name' => 'Haha', 'emoji' => '😂'],
            ['name' => 'Wow', 'emoji' => '😮'],
            ['name' => 'Przykro mi', 'emoji' => '😔'],
            ['name' => 'Wrr', 'emoji' => '😡'],
        ]);
    }
}
