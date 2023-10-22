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
            $table->uuid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');

            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('role')->default('guest'); // guest, admin, teacher, student, parent
            $table->boolean('active')->default(false);
            $table->integer('code')->unique();

            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->json('address')->nullable();

            $table->foreignIdFor(\App\Models\School::class)->nullable();

            $table->rememberToken();
            $table->json('settings')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->timestamps();
            $table->softDeletes();
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
