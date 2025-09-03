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
            $table->string('founder');
            $table->string('slug', 10);
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('house'); 
            $table->integer('number');
            $table->string('unique_id');
            $table->enum('type', [
                'room',
                'bedroom',
                'kitchen',
                'living_room',
                'dining_room',
                'bathroom',
                'toilet',
                'office',
                'garage',
                'attic',
                'basement',
                'laundry',
                'pantry',
                'hallway',
                'closet',
                'porch',
                'balcony',
                'terrace'
            ])->default('room');
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

        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('cleaning_queue', function (Blueprint $table) {
            $table->id();
            $table->string('house');
            $table->enum('type', ['whole', 'partial']);
            $table->json('rotation');
            $table->dateTime('start_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cleaning_overrides');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('tenants');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('houses');
        Schema::dropIfExists('cleaning_queue');
    }
};