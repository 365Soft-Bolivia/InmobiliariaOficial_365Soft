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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('telegram_user_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('image')->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->default('male');
            $table->string('locale')->default('es');
            $table->string('status')->default('active');
            $table->string('login')->unique();
            $table->string('onesignal_player_id')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->boolean('email_notifications')->default(true);
            $table->unsignedBigInteger('country_id')->nullable();
            $table->boolean('dark_theme')->default(false);
            $table->boolean('rtl')->default(false);
            $table->boolean('two_factor_confirmed')->default(false);
            $table->boolean('two_factor_email_confirmed')->default(false);
            $table->string('salutation')->nullable();
            $table->string('two_fa_verify_via')->nullable();
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->boolean('admin_approval')->default(false);
            $table->boolean('permission_sync')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
