<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsOrBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_or_banks', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->integer('account_category_id')->default(0)->comment('account_category_id');
            $table->string('name',255)->comment('required');
            $table->string('account_id',100)->default(NULL)->nullable()->comment('optional');
            $table->text('description')->default(NULL)->nullable()->comment('optional');
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->integer('admin_id')->default(0)->comment('admin_id');
            $table->tinyInteger('is_editable')->default(0)->comment('0-no,yes-1');
            $table->string('payment_method',10)->default('B');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_or_banks');
    }
}
