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
        Schema::table('payment_platforms', function (Blueprint $table) {
            $table->boolean('subscriptions_enabled')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_platforms', function (Blueprint $table) {
            $table->dropColumn('subscriptions_enabled');
        });
    }
};
