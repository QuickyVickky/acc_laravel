<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_items', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('bill_id')->default(0)->comment('bill_id');
            $table->integer('products_or_services_id')->default(0)->comment('expense category only');
            $table->string('description',1000)->nullable()->default(NULL)->comment('optional');
            $table->integer('qty')->default(1);
            $table->decimal('price', $precision = 15, $scale = 2)->default(0)->comment('required');
            $table->decimal('amount', $precision = 15, $scale = 2)->default(0)->comment('required [qty x price]');
            $table->decimal('totaltax', $precision = 11, $scale = 2)->default(0)->comment('required');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('tax_id')->default(1)->comment('tax_id');
            $table->decimal('tax_rate', $precision = 5, $scale = 2)->default(0);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bill_items');
    }
}
