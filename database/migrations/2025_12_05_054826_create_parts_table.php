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
            $table->string('customer')->nullable();
            $table->string('material')->nullable();
            $table->integer('avg_output_per_day')->nullable();
            $table->string('part_image')->nullable();
            
            $table->string('drawing')->nullable();
            $table->string('inspection_gauge')->nullable();
            $table->string('machine_setup_parameter')->nullable();
            $table->string('operation_jig')->nullable();
            $table->string('operation_sheet')->nullable();
            $table->string('process_standard_sheet')->nullable();
            $table->string('program_list')->nullable();
            $table->string('project_status')->nullable();
            $table->string('tooling')->nullable();

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
