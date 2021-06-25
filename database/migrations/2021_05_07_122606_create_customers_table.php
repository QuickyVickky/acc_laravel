<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('fullname',255)->comment('Required');
            $table->string('firstname',100)->nullable()->default(NULL)->comment('optional');
            $table->string('lastname',100)->nullable()->default(NULL)->comment('optional');
            $table->string('email',111)->nullable()->default(NULL)->comment('optional');
            $table->string('mobile',15)->nullable()->default(NULL)->comment('optional');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('admin_id')->default(0)->comment('admin_id');
            $table->string('country',60)->nullable()->default('India');
            $table->string('state',100)->nullable()->default(NULL);
            $table->string('city',100)->nullable()->default(NULL);
            $table->string('pincode',6)->nullable()->default(NULL);
            $table->string('address',500)->nullable()->default(NULL);
            $table->string('landmark',100)->nullable()->default(NULL);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
