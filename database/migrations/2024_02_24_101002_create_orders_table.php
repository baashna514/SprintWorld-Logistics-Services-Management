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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('sprint_ref')->nullable();
            $table->enum('departure_status', ['not departed', 'departed'])->default('not departed');
            $table->string('document_status')->nullable();
            $table->enum('pre_alert_sent', ['pending', 'yes'])->default('pending');
            $table->enum('pre_alert_docs', ['pending', 'yes'])->default('pending');
            $table->enum('custom_entry', ['pending', 'yes'])->default('pending');
            $table->enum('mucr_closed', ['pending', 'yes'])->default('pending');
            $table->enum('fwb_fhl', ['pending', 'yes'])->default('pending');
            $table->enum('docs_to_print', ['pending', 'yes'])->default('pending');
            $table->string('invoice_amount_comment')->nullable();
            $table->string('invoice_number')->nullable();
            $table->decimal('invoice_value')->default(0.0);
            $table->enum('status', ['open', 'under_process', 'processed', 'closed'])->default('open');
            $table->timestamp('creation_date')->nullable();
            $table->timestamp('claims_date')->nullable();
            $table->timestamp('processed_date')->nullable();
            $table->timestamp('closed_date')->nullable();
            $table->decimal('days')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
