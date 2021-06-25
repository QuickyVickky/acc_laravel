<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsOrServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_or_services', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('sub_category_id')->default(0)->comment('sub_category_id');
            $table->string('name',255)->comment('required');
            $table->text('description')->nullable()->default(NULL)->comment('optional');
            $table->decimal('price', $precision = 16, $scale = 2)->default(0);
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('admin_id')->default(0)->comment('admin_id');
            $table->integer('tax_id')->default(1)->comment('tax_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_or_services');
    }
}
