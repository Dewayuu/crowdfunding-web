<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_donations', function (Blueprint $table) {

            $table->id('donation_id');

            $table->foreignId('campaign_id')
                ->constrained('tb_campaigns', 'campaign_id')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('tb_users', 'user_id')
                ->cascadeOnDelete();

            $table->string('donor_name', 255);

            $table->enum('is_anonymous', ['yes', 'no'])
                ->default('no');

            $table->decimal('amount', 15, 2);

            $table->text('support_message')->nullable();

            /*
            | Midtrans
            */

            $table->string('midtrans_order_id')->unique();

            $table->string('midtrans_transaction_id')->nullable();

            $table->text('snap_token')->nullable();

            $table->string('payment_method')->nullable();

            $table->string('payment_reference')->nullable();

            $table->json('payment_payload')->nullable();

            $table->timestamp('payment_notified_at')->nullable();

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'cancelled'
            ])->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamp('expired_at')->nullable();

            $table->timestamps();
        });

        Schema::create('tb_campaign_disbursement', function (Blueprint $table) {

            $table->id('disbursement_id');

            $table->foreignId('campaign_id')
                ->constrained('tb_campaigns', 'campaign_id')
                ->cascadeOnDelete();

            $table->foreignId('user_bank_account_id')
                ->constrained('tb_user_bank_accounts', 'user_id')
                ->restrictOnDelete();

            $table->decimal('amount_requested', 15, 2);

            $table->text('purpose');

            $table->enum('disbursement_status', [
                'pending',
                'approved',
                'rejected',
                'transferred'
            ])->default('pending');

            $table->string('transfer_proof')->nullable();

            $table->text('rejection_reason')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->timestamp('processed_at')->nullable();
        });

        Schema::create('tb_donation_refunds', function (Blueprint $table) {

            $table->id('refund_id');

            $table->foreignId('donation_id')
                ->unique()
                ->constrained('tb_donations', 'donation_id')
                ->cascadeOnDelete();

            $table->foreignId('user_bank_account_id')
                ->constrained('tb_user_bank_accounts', 'user_id')
                ->restrictOnDelete();

            $table->enum('refund_status', [
                'pending',
                'success',
                'failed'
            ])->default('pending');

            $table->string('transfer_proof')->nullable();

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