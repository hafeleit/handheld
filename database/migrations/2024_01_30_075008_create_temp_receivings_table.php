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
        Schema::create('temp_receivings', function (Blueprint $table) {
            $table->id();
      			$table->string('sys_id');
      			$table->string('serial_number');
      			$table->string('user_id');
      			$table->string('status')->default(0);
      			$table->string('delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_receivings');
    }
};
