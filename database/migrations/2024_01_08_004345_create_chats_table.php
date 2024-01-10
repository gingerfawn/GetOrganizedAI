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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('note_id');
            $table->integer('order');
            $table->integer('user_id');
            $table->integer('profile_id');
            $table->integer('folder_id');
            $table->string('is_AI_resp');
            $table->string('attachment_type');
            $table->string('chat');
            $table->string('filepath');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
