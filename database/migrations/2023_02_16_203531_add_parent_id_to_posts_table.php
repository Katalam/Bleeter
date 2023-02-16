<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('posts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('posts', static function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
    }
};
