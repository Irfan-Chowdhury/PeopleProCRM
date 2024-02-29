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
        Schema::create('estimate_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_id');
            $table->foreignId('item_id');
            $table->integer('quantity');
            $table->string('unit_type');
            $table->decimal('rate');
            $table->text('description')->nullable();

            $table->foreign('estimate_id', 'estimate_items_estimate_id_foreign')->references('id')->on('estimates')->onDelete('cascade');
            $table->foreign('item_id', 'estimate_items_item_id_foreign')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estimate_items');
    }
};
