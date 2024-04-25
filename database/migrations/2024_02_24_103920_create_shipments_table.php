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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned()->index()->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('client')->nullable();
            $table->string('destination')->nullable();
            $table->string('shipper')->nullable();
            $table->integer('pcs')->default(0)->nullable();
            $table->decimal('gross_weight')->default(0.0);
            $table->string('cw_pre_alert')->nullable();
            $table->decimal('cw_print')->default(0.0);
            $table->string('dep_airport')->nullable();
            $table->string('airline')->nullable();
            $table->string('awb_number')->nullable();
            $table->timestamp('flight_date')->nullable();
            $table->string('transporter')->nullable();
            $table->timestamp('coll_date')->nullable();
            $table->string('warehouse')->nullable();
            $table->decimal('expected_transport_cost')->default(0.0);
            $table->string('current_processing_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
