<?php

use Support\Vault\Database\Blueprint;
use Support\Vault\Database\Migration;
use Support\Vault\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id(); // = unsignedBigInteger + PK + auto_increment
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('house_id'); // foreign key
            $table->string('name');
            $table->timestamps();

            // Dodanie klucza obcego
            $table->foreign('house_id')
                  ->references('id')
                  ->on('houses')
                  ->onDelete('cascade')
                  ->apply();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('houses');
    }
};