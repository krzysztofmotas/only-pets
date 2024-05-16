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
            $table->date('started_at')->default(now());
            $table->date('end_at');
            $table->string('payment_method', 30);
            $table->string('payment_currency', 15);
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
