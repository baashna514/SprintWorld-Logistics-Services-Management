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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->decimal('freight_charges')->default(0.0)->nullable();
            $table->decimal('transport_cost')->default(0.0)->nullable();
            $table->decimal('security_charges')->default(0.0)->nullable();
            $table->decimal('entry_cost')->default(0.0)->nullable();
            $table->decimal('misc_charges')->default(0.0)->nullable();
            $table->decimal('import_handling_cost')->default(0.0)->nullable();
            $table->decimal('customs')->default(0.0)->nullable();
            $table->decimal('overseas_charges')->default(0.0)->nullable();
            $table->decimal('gross_profit')->default(0.0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
