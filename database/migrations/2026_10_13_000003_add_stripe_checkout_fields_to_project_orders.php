<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_orders', function (Blueprint $table) {
            $table->char('currency', 3)->default('usd')->after('amount');
            $table->string('stripe_checkout_session_id')->nullable()->unique()->after('transaction_id');
            $table->text('download_token_encrypted')->nullable()->after('download_token');
            $table->string('download_token')->nullable()->change();
        });

        Schema::create('payment_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained('project_orders')->nullOnDelete();
            $table->string('gateway', 32);
            $table->string('gateway_event_id')->nullable();
            $table->string('event_type', 100);
            $table->json('payload');
            $table->string('status', 32)->default('received');
            $table->timestamps();

            $table->unique(['gateway', 'gateway_event_id']);
            $table->index(['order_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_logs');

        Schema::table('project_orders', function (Blueprint $table) {
            $table->dropUnique(['stripe_checkout_session_id']);
            $table->dropColumn(['currency', 'stripe_checkout_session_id', 'download_token_encrypted']);
            $table->string('download_token')->nullable(false)->change();
        });
    }
};
