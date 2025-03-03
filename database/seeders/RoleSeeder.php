<?php

namespace Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {
            DB::table('roles')->truncate();
        });

        DB::table('roles')->insert([
            ['id' => User::ROLE_USER, 'name' => 'user'],
            ['id' => User::ROLE_ADMIN, 'name' => 'admin']
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id')->default(User::ROLE_USER)->change();
        });
    }
}
