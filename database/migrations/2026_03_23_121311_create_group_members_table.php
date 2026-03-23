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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();

            $table->foreignId('group_registration_id')
                ->constrained()
                ->cascadeOnDelete();

            // Member details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();

            $table->string('country');
            $table->enum('nationality', ['east_african', 'non_east_african']);

            $table->enum('platform', ['physical', 'virtual']);
            $table->enum('category', ['student', 'professional', 'kalro_staff']);

            $table->string('paper_ref_code')->nullable();

            $table->decimal('fee', 10, 2);
            $table->string('currency');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
