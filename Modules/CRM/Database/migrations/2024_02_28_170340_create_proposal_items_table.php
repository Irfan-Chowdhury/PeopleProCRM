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
        Schema::create('proposal_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id');
            $table->foreignId('item_id');
            $table->integer('quantity');
            $table->string('unit_type');
            $table->decimal('rate');
            $table->text('description')->nullable();

            $table->foreign('proposal_id', 'proposal_items_proposal_id_foreign')->references('id')->on('proposals')->onDelete('cascade');
            $table->foreign('item_id', 'proposal_items_item_id_foreign')->references('id')->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposal_items', function (Blueprint $table) {
            $table->dropForeign('proposal_items_proposal_id_foreign');
            $table->dropForeign('proposal_items_item_id_foreign');
            $table->dropIfExists();
        });
    }
};
