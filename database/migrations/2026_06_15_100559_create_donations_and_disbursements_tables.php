<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. tb_donations
        Schema::create('tb_donations', function (Blueprint $table) {
            $table->id('donation_id');
            $table->foreignId('campaign_id')->constrained('tb_campaigns', 'campaign_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->string('donor_name', 255);
            $table->enum('is_anonymous', ['yes', 'no'])->default('no');
            $table->decimal('amount', 15, 2);
            $table->text('support_messsage')->nullable(); 
            $table->enum('payment_method', ['qris', 'bank_transfer']);
            $table->string('payment_reference', 100)->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
        });

        // 2. tb_campaign_disbursement
        Schema::create('tb_campaign_disbursement', function (Blueprint $table) {
            $table->id('disbursement_id');
            $table->foreignId('campaign_id')->constrained('tb_campaigns', 'campaign_id')->onDelete('cascade');
            $table->foreignId('user_bank_account_id')->constrained('tb_user_bank_accounts', 'user_id')->onDelete('restrict');
            $table->decimal('amount_requested', 15, 2);
            $table->text('purpose');
            $table->enum('disbursement_status', ['pending', 'approved', 'rejected', 'transferred'])->default('pending');
            $table->string('transfer_proof', 255)->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
        });

        // 3. tb_donation_refunds
        Schema::create('tb_donation_refunds', function (Blueprint $table) {
            $table->id('refund_id');
            $table->foreignId('donation_id')->unique()->constrained('tb_donations', 'donation_id')->onDelete('cascade');
            $table->foreignId('user_bank_account_id')->constrained('tb_user_bank_accounts', 'user_id')->onDelete('restrict');
            $table->enum('refund_status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('transfer_proof', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_donation_refunds');
        Schema::dropIfExists('tb_campaign_disbursement');
        Schema::dropIfExists('tb_donations');
    }
};