<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function down(): void
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    public function up(): void
    {
        Schema::table('threads', function (Blueprint $table) {
            $table->string('image')->nullable();
        });
    }
};
