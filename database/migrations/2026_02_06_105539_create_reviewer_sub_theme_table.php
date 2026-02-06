<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviewer_sub_theme', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reviewer_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('sub_theme_id')
                ->constrained('sub_themes')
                ->cascadeOnDelete();

            $table->unique(['reviewer_id', 'sub_theme_id']); // prevent duplicates

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer_sub_theme');
    }
};
