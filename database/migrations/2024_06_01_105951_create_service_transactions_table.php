<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_transactions', function (Blueprint $table) {
            $table->bigIncrements('transaction_id');
            $table->string('invoice_number')->unique();
            $table->date('entry_date')->nullable();
            $table->date('takeout_date')->nullable();
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('laptop_id')->nullable();
            $table->string('problem_description')->nullable();
            $table->json('service_ids')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();
            $table->string('warranty_id')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('technician_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('set null');
            $table->foreign('laptop_id')->references('id_laptop')->on('laptops')->onDelete('set null');
            $table->foreign('warranty_id')->references('no_warranty')->on('warranties')->onDelete('set null');

            $table->index('technician_id');
            $table->index('customer_id');
            $table->index('laptop_id');
            $table->index('warranty_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_transactions');
    }
}
