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
        Schema::create('schools', function (Blueprint $table) {
            $table->uuid('id')->primary;
            $table->string('name');
            $table->text('about')->nullable();
            $table->json('address')->nullable();
            $table->string('phone')->nullable();

            $table->string('plan')->default('free'); // free, basic, premium
            $table->foreignIdFor(\App\Models\User::class, 'owner_id')->nullable();
            $table->integer('code')->unique();

            $table->timestamps();
            $table->timestamp('trail_ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
