<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // plans — subscription tiers with feature flags
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->boolean('has_crm')->default(false);
            $table->boolean('has_pm')->default(false);
            $table->unsignedInteger('booking_limit')->default(100);
            $table->unsignedInteger('user_limit')->default(3);
            $table->unsignedDecimal('price_chf', 8, 2)->default(0);
            $table->timestamps();
        });

        // clients — tenant registry; id is a slug used as DB name segment
        Schema::create('clients', function (Blueprint $table) {
            $table->string('id')->primary(); // e.g. sanitaer-basel
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('trade')->nullable(); // roofer, plumber, painter, etc.
            $table->uuid('plan_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('plan_id')->references('id')->on('plans')->nullOnDelete();
        });

        // client_users — login accounts for business owners and staff
        Schema::create('client_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['owner', 'staff'])->default('staff');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
        });

        // client_billing — subscription billing records
        Schema::create('client_billing', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_id');
            $table->uuid('plan_id');
            $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly');
            $table->enum('status', ['active', 'past_due', 'cancelled', 'trialing'])->default('trialing');
            $table->timestamp('next_billing_at')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
            $table->foreign('plan_id')->references('id')->on('plans');
        });

        // client_domains — custom domains per client
        Schema::create('client_domains', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('client_id');
            $table->string('domain')->unique();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_domains');
        Schema::dropIfExists('client_billing');
        Schema::dropIfExists('client_users');
        Schema::dropIfExists('clients');
        Schema::dropIfExists('plans');
    }
};
