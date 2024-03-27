<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreignId('client_id');
            $table->string('payment_method');
            $table->date('date');
            $table->decimal('amount');
            $table->string('payment_status');
            $table->text('note')->nullable();

            $table->foreign('invoice_id', 'invoice_payments_invoice_id_foreign')->references('id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('invoice_payments', function (Blueprint $table) {
            $table->dropForeign('invoice_payments_invoice_id_foreign');
            $table->dropIfExists();
        });
    }
};
