<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('meat_id');
            $table->unsignedBigInteger('bread_id');
            $table->foreign('meat_id')->references('id')->on('meats');
            $table->foreign('bread_id')->references('id')->on('breads');
            $table->dropColumn('meat');
            $table->dropColumn('bread');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('meat');
            $table->string('bread');
            $table->dropForeign(['meat_id']);
            $table->dropForeign(['bread_id']);
            $table->dropColumn('meat_id');
            $table->dropColumn('bread_id');
        });
    }
};
