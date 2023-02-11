<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('follow_user', static function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('follow_user_id')->constrained('users')->cascadeOnDelete();

            $table->primary(['user_id', 'follow_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follow_user');
    }
};
