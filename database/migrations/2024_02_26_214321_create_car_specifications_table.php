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
        Schema::create('car_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('nume');
            $table->string('transmisie');
            $table->string('combustibil');
            $table->decimal('pret', 8, 2); // Presupunând că vrei să folosești un tip numeric convenabil, cum ar fi decimal cu 8 cifre totale și 2 zecimale.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_specifications');
    }
};
