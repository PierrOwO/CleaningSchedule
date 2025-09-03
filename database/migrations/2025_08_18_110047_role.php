<?php

use Support\Vault\Database\Blueprint;
use Support\Vault\Database\Migration;
use Support\Vault\Database\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->integer('admin');
            $table->integer('land_lord');
            $table->integer('tenant');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};