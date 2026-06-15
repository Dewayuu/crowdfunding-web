<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_users', function (Blueprint $table) {
            $table->id('user_id'); 
            $table->string('email', 320)->unique();
            $table->string('password', 255);
            $table->string('contact_number', 20)->unique();
            $table->string('username', 50)->unique();
            $table->string('profile_photo', 255)->nullable();
            $table->text('bio')->nullable();
            $table->enum('role', ['admin', 'user']);
            $table->enum('entity_type', ['individual', 'foundation', 'corporate', 'community']);
            $table->enum('account_status', ['active', 'suspended'])->default('active');
            $table->timestamps(); // Otomatis membuat created_at dan updated_at
        });

        // Bawaan Laravel untuk keperluan Autentikasi Session & Token
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('tb_users');
    }
};