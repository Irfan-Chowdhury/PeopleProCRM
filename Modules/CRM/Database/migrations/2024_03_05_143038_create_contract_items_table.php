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
        Schema::create('contract_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id');
            $table->foreignId('item_id');
            $table->integer('quantity');
            $table->string('unit_type');
            $table->decimal('rate');
            $table->text('description')->nullable();

            $table->foreign('contract_id', 'contract_items_contract_id_foreign')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('item_id', 'contract_items_item_id_foreign')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_items', function (Blueprint $table) {
            $table->dropForeign('contract_items_contract_id_foreign');
            $table->dropForeign('contract_items_item_id_foreign');
            $table->dropIfExists();
        });
    }
};
