<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_themes', function (Blueprint $table) {
            $table->id();

            $table->string('form_field_value');
            $table->string('full_name');
            $table->integer('code')->unique();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_themes');
    }
};
