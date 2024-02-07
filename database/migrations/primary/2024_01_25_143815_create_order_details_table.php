<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('item_id')->nullable();
            $table->integer('quantity');
            $table->decimal('rate');
            $table->decimal('subtotal');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id', 'order_details_order_id_foreign')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('item_id', 'order_details_item_id_foreign')->references('id')->on('items');
        });
    }


    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropForeign('order_details_order_id_foreign');
            $table->dropForeign('order_details_item_id_foreign');
            $table->dropIfExists();
        });
    }
};
