<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('premium_projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('full_description');
            $table->string('thumbnail_url')->nullable();
            $table->string('live_demo_url')->nullable();
            $table->string('video_preview_url')->nullable();
            $table->json('tech_stack');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_pricing_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('premium_projects')->cascadeOnDelete();
            $table->string('tier_name');
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->string('billing_type')->default('one_time');
            $table->json('features');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });

        Schema::create('project_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('project_id')->constrained('premium_projects')->restrictOnDelete();
            $table->foreignId('pricing_tier_id')->constrained('project_pricing_tiers')->restrictOnDelete();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('amount', 10, 2);
            $table->string('payment_gateway');
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('download_token')->unique();
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->index(['payment_status', 'created_at']);
            $table->index('customer_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_orders');
        Schema::dropIfExists('project_pricing_tiers');
        Schema::dropIfExists('premium_projects');
    }
};
