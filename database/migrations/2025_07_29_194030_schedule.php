<?php

use Support\Vault\Database\Blueprint;
use Support\Vault\Database\Migration;
use Support\Vault\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('unique_id');
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('house'); 
            $table->integer('number');
            $table->string('unique_id');
            $table->timestamps();
        });

        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('room');
            $table->string('user'); 
            $table->integer('status')->default(1);
            $table->string('unique_id');
            $table->timestamps();
        });

        Schema::create('cleaning_overrides', function (Blueprint $table) {
            $table->id();
            $table->string('house');
            $table->string('room');
            $table->string('tenant');
            $table->integer('week');
            $table->integer('year');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cleaning_overrides');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('houses');
    }
};