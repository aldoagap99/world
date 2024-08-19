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
        Schema::table('cities', function (Blueprint $table) {
            $table->integer('status')->default(1);
        });

        Schema::table('states', function (Blueprint $table) {
            $table->integer('status')->default(1);
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('states', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
