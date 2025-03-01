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
        Schema::create('case_item_drop_rates', function (Blueprint $table) {
            $table->id();
            $table->string('case_id');
            $table->string('item_id');
            $table->float('item_drop_rate');
            $table->timestamps();

            $table->foreign('case_id')->references('id')->on('game_cases')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('game_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_items');
    }
};
