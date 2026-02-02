<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('email')->unique();

            $table->string('password')->nullable();

            $table->enum('role', ['ADMIN', 'REVIEWER'])->default('REVIEWER');

            $table->boolean('is_active')->default(true);

            $table->string('password_setup_token')->nullable();
            $table->timestamp('password_setup_expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
