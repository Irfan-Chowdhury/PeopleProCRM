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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id');
            $table->foreignId('tax_type_id')->nullable();
            $table->string('title')->unique();
            $table->date('first_billing_date');
            $table->string('repeat_type');
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id', 'subscriptions_client_id_foreign')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('tax_type_id', 'subscriptions_tax_type_id_foreign')->references('id')->on('tax_types')->onDelete('set NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign('subscriptions_client_id_foreign');
            $table->dropForeign('subscriptions_tax_type_id_foreign');
            $table->dropIfExists();
        });
    }
};
