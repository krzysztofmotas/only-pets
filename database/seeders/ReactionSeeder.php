<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ReactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            DB::table('reactions')->truncate();
        });

        DB::table('reactions')->insert([
            ['name' => 'Lubię to!', 'emoji' => '👍'],
            ['name' => 'Super', 'emoji' => '❤️'],
            ['name' => 'Haha', 'emoji' => '😂'],
            ['name' => 'Wow', 'emoji' => '😮'],
            ['name' => 'Przykro mi', 'emoji' => '😔'],
            ['name' => 'Wrr', 'emoji' => '😡'],
        ]);
    }
}
