<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presentation_uploads', function (Blueprint $table) {

            $table->id();

            $table->foreignId('full_paper_id')
                  ->constrained('full_papers')
                  ->cascadeOnDelete();

            $table->string('powerpoint_file')->nullable();
            $table->string('poster_file')->nullable();

            $table->json('supporting_documents')->nullable();

            $table->timestamp('uploaded_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presentation_uploads');
    }
};
