<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_configurations', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('company_name',255)->comment('Company Name');
            $table->string('email',111)->nullable()->default(NULL)->comment('optional');
            $table->string('mobile',15)->nullable()->default(NULL)->comment('optional');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->string('country',60)->nullable()->default('India');
            $table->string('state',100)->nullable()->default(NULL);
            $table->string('city',100)->nullable()->default(NULL);
            $table->string('pincode',6)->nullable()->default(NULL);
            $table->string('address',500)->nullable()->default(NULL);
            $table->string('landmark',100)->nullable()->default(NULL);
            $table->string('invoice_logo',100)->nullable()->default(NULL);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_configurations');
    }
}
