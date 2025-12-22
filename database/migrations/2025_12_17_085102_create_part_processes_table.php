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
        Schema::create('part_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('part_id')->constrained()->onDelete('cascade');
            $table->foreignId('process_id')->constrained()->onDelete('cascade');

            $table->string('department')->nullable();
            $table->string('section')->nullable();
            $table->string('machine_line')->nullable();
            $table->string('operator')->nullable();
            $table->integer('mct')->nullable();
            $table->integer('ct')->nullable();

            $table->string('qal')->nullable();
            $table->string('work_layout')->nullable();
            $table->string('work_instruction')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('part_processes');
    }
};
