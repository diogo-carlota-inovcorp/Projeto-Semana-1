<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('session_id');
            $table->json('cart_data');
            $table->decimal('total', 10, 2);
            $table->string('email');
            $table->string('name')->nullable();
            $table->timestamp('last_activity');
            $table->timestamp('notified_at')->nullable();
            $table->boolean('recovered')->default(false);
            $table->integer('notification_count')->default(0);
            $table->timestamps();

            $table->index(['session_id', 'recovered']);
            $table->index('last_activity');
            $table->index('notified_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');
    }
};
