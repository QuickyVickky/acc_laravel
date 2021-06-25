<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('customer_id')->default(0);
            $table->string('invoice_title',255)->nullable()->default(NULL);
            $table->string('invoice_description',1000)->nullable()->default(NULL)->comment('optional');
            $table->string('invoice_number',100)->nullable()->default(NULL)->comment('optional');
            $table->dateTime('invoice_date', $precision = 0)->nullable()->default(NULL)->comment('Required');
            $table->dateTime('payment_due_date', $precision = 0)->nullable()->default(NULL);
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('admin_id')->default(0)->comment('admin_id');
            $table->string('invoice_comment',1000)->nullable()->default(NULL)->comment('remarks');
            $table->string('footer_comment',1000)->nullable()->default(NULL)->comment('remarks');
            $table->integer('total_qty')->default(0);
            $table->decimal('subtotal', $precision = 16, $scale = 2)->default(0);
            $table->decimal('tax_total', $precision = 11, $scale = 2)->default(0);
            $table->decimal('total', $precision = 16, $scale = 2)->default(0);
            $table->string('invoice_status',10)->default('U')->comment('invoice_status');
            $table->decimal('amount_due', $precision = 15, $scale = 2)->default(0)->comment('amount_due');
            $table->decimal('total_paid', $precision = 16, $scale = 2)->default(0);            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
