<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortHelperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_helper', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name',100)->nullable()->default(NULL);
            $table->string('short',25);
            $table->string('details',255)->nullable()->default(NULL);
            $table->string('type',100)->comment('for what');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->string('classhtml',50)->nullable()->default(NULL)->comment('classhtml');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('short_helper');
    }
}
