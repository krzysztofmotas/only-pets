<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_user_id')->constrained('users');
            $table->foreignId('subscribed_user_id')->constrained('users');
            $table->integer('price');
            $table->boolean('show_notification')->default(true);
            $table->dateTime('started_at');
            $table->dateTime('end_at');
            $table->boolean('auto_renew')->default(false);
            $table->foreignId('job_id')->nullable()->constrained('jobs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
