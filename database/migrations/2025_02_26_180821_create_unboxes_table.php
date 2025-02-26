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
        Schema::create('unboxes', function (Blueprint $table) {
            $table->id();
            $table->string('case_id');
            $table->string('item_id');
            $table->string('is_stat_trak')->default(false);
            $table->uuid('unboxer_id')->nullable();
            $table->timestamps();

            $table->foreign('case_id')->references('id')->on('game_cases');
            $table->foreign('item_id')->references('id')->on('game_items');

            $table->index('unboxer_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unboxes');
    }
};
