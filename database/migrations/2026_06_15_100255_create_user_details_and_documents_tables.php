<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. tb_user_details_individual
        Schema::create('tb_user_details_individual', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('full_name', 255);
            $table->string('national_id_number', 16)->nullable();
            $table->date('birth_date');
            $table->enum('gender', ['male', 'female']);
        });

        // 2. tb_user_details_corporate
        Schema::create('tb_user_details_corporate', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('company_name', 255);
            $table->string('nib', 20);
            $table->string('npwp', 20);
            $table->text('company_address');
            $table->string('pic_name', 255);
            $table->string('pic_national_id_number', 16);
        });

        // 3. tb_user_details_foundation
        Schema::create('tb_user_details_foundation', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('foundation_name', 255);
            $table->string('sk_kemenkumham_number', 50);
            $table->text('foundation_address');
            $table->string('pic_name', 255);
            $table->string('pic_national_id_number', 16);
        });

        // 4. tb_user_details_community
        Schema::create('tb_user_details_community', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('community_name', 255);
            $table->string('community_type', 50);
            $table->string('social_media_url', 255);
            $table->string('pic_name', 255);
            $table->string('pic_national_id_number', 16);
        });

        // 5. tb_user_bank_accounts
        Schema::create('tb_user_bank_accounts', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('bank_name', 50);
            $table->string('account_number', 20)->unique();
            $table->string('account_name', 255);
        });

        // 6. tb_user_documents
        Schema::create('tb_user_documents', function (Blueprint $table) {
            $table->id('user_document_id');
            $table->foreignId('user_id')->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->enum('document_type', ['ktp', 'sk_kemenkumham', 'nib', 'npwp', 'social_media', 'bank_book']);
            $table->string('file', 255);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user_documents');
        Schema::dropIfExists('tb_user_bank_accounts');
        Schema::dropIfExists('tb_user_details_community');
        Schema::dropIfExists('tb_user_details_foundation');
        Schema::dropIfExists('tb_user_details_corporate');
        Schema::dropIfExists('tb_user_details_individual');
    }
};