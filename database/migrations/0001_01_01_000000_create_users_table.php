<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username');
            $table->string('image')->default('');
            $table->string('image_public_id')->default('');
            $table->enum('role', ['client', 'freelancer'])->default('freelancer');
            $table->string('email')->unique();
            $table->string('verification_code')->nullable()->unique();
            $table->timestamp('verification_code_expires')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_premium')->default(false);
            $table->boolean('job_alerts')->default(false);
            $table->timestamp('last_premium_subscription')->nullable()->default(null);
            $table->timestamp('last_dev_contact')->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('freelancer_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('professional_name')->nullable();
            $table->text('professional_summary')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('phone_number')->nullable();
            $table->json('skills')->nullable();
            $table->string('portfolio_link')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->text('education')->nullable();
            $table->text('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->enum('availability', ['Full-time', 'Part-time', 'Hourly'])->nullable();
            $table->enum('response_time', ['Within an hour', 'Within a few hours', 'Within a day'])->nullable();
            $table->string('linkedin_profile')->nullable();
            $table->timestamps();
        });

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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('freelancer_details');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
