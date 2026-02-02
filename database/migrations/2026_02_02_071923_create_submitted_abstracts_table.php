<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('submitted_abstracts', function (Blueprint $table) {
            $table->id();

            $table->string('submission_code')->unique(); 

            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_phone')->nullable();
            $table->string('organisation')->nullable();
            $table->string('department')->nullable();
            $table->string('position')->nullable();

            $table->foreignId('sub_theme_id')
                ->constrained('sub_themes')
                ->cascadeOnDelete();

            $table->string('paper_title');
            $table->text('abstract_text');
            $table->text('keywords')->nullable();

            $table->enum('presentation_preference', ['ORAL', 'POSTER'])->nullable();
            $table->enum('attendance_mode', ['PHYSICAL', 'VIRTUAL', 'BOTH'])->nullable();
            $table->text('special_requirements')->nullable();

            $table->enum('status', ['PENDING','UNDER_REVIEW','APPROVED','REJECTED'])
                ->default('PENDING');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submitted_abstracts');
    }
};
