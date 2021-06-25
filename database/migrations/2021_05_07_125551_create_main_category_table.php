<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_category', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name',255)->default(NULL)->nullable();
            $table->string('name2',255)->default(NULL)->nullable();
            $table->string('details',255)->default(NULL)->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->tinyInteger('is_editable')->default(0)->comment('0-no,yes-1');
            $table->string('mainaccount_type',10)->default('I')->comment('mainaccount_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_category');
    }
}
