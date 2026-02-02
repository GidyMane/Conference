<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('abstract_co_authors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('abstract_id')
                ->constrained('submitted_abstracts')
                ->cascadeOnDelete();

            $table->string('full_name');
            $table->string('institution')->nullable();
            $table->integer('author_order')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_co_authors');
    }
};
