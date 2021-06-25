<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('vendor_id')->default(0)->comment('vendor_id');
            $table->string('bill_notes',1000)->nullable()->default(NULL)->comment('optional');
            $table->string('bill_number',100)->nullable()->default(NULL)->comment('optional');
            $table->dateTime('bill_date', $precision = 0)->nullable()->default(NULL)->comment('required');
            $table->dateTime('payment_due_date', $precision = 0)->nullable()->default(NULL);
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('admin_id')->default(0)->comment('admin_id');
            $table->integer('total_qty')->default(0);
            $table->string('bill_status',10)->default('U')->comment('bill_status');
            $table->decimal('subtotal', $precision = 15, $scale = 2)->default(0);
            $table->decimal('total', $precision = 15, $scale = 2)->default(0);
            $table->decimal('tax_total', $precision = 11, $scale = 2)->default(0);
            $table->decimal('amount_due', $precision = 15, $scale = 2)->default(0)->comment('amount_due');
            $table->decimal('total_paid', $precision = 15, $scale = 2)->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
