<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. tb_campaign_categories
        Schema::create('tb_campaign_categories', function (Blueprint $table) {
            $table->id('category_id'); // 
            $table->string('category_name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->string('category_icon', 255);
            $table->enum('is_active', ['yes', 'no'])->default('yes');
            $table->timestamp('created_at')->useCurrent();
        });

        // 2. tb_campaigns
        Schema::create('tb_campaigns', function (Blueprint $table) {
            $table->id('campaign_id');
            $table->foreignId('user_id')->constrained('tb_users', 'user_id')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('tb_campaign_categories', 'category_id')->onDelete('restrict');
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('short_description', 255);
            $table->text('story');
            $table->decimal('target_amount', 15, 2);
            $table->decimal('current_amount', 15, 2)->default(0.00);
            $table->timestamp('end_date')->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('campaign_status', ['active', 'completed', 'canceled'])->default('active');
            $table->enum('disbursement_status', ['not_started', 'partially_disbursed', 'fully_disbursed'])->default('not_started');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // 3. tb_campaign_images
        Schema::create('tb_campaign_images', function (Blueprint $table) {
            $table->id('image_id');
            $table->foreignId('campaign_id')->constrained('tb_campaigns', 'campaign_id')->onDelete('cascade');
            $table->string('image', 255);
            $table->string('caption', 150)->nullable();
            $table->enum('is_primary', ['yes', 'no'])->default('no');
            $table->timestamp('created_at')->useCurrent();
        });

        // 4. tb_campaign_beneficiaries
        Schema::create('tb_campaign_beneficiaries', function (Blueprint $table) {
            $table->id('beneficiary_id');
            $table->foreignId('campaign_id')->constrained('tb_campaigns', 'campaign_id')->onDelete('cascade');
            $table->enum('beneficiary_type', ['individual', 'foundation', 'community', 'institution', 'others']);
            $table->string('name', 255);
            $table->string('identity_number', 50);
            $table->string('contact_number', 20);
            $table->text('address');
            $table->text('description');
            $table->string('document_path', 255);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_campaign_beneficiaries');
        Schema::dropIfExists('tb_campaign_images');
        Schema::dropIfExists('tb_campaigns');
        Schema::dropIfExists('tb_campaign_categories');
    }
};