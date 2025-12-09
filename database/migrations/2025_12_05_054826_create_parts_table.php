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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('part_name');
            $table->string('part_image')->nullable();
            $table->string('machine_line')->nullable();
            $table->string('operator')->nullable();
            $table->string('customer')->nullable();
            $table->string('material')->nullable();
            $table->string('department')->nullable();
            $table->string('section')->nullable();
            $table->float('mct')->nullable();
            $table->float('ct')->nullable();
            $table->integer('avg_output_per_day')->nullable();
            $table->string('main_reject_reason')->nullable();
            $table->string('qal')->nullable(); // store PDF path
            $table->string('work_layout')->nullable(); // store PDF path
            $table->string('work_instruction')->nullable(); // store PDF path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
