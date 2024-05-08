<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Post;
use App\Models\Reaction;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Reaction::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts_reactions');
    }
};
