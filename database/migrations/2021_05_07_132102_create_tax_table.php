<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('name',255)->comment('Required');
            $table->decimal('current_tax_rate', $precision = 2, $scale = 2)->default(0)->comment('Required');
            $table->string('abbreviation',55)->comment('Required');
            $table->string('details',255)->default(NULL)->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('1-active,0-deactive, 2- deleted');
            $table->dateTime('created_at', $precision = 0)->nullable()->default(NULL);
            $table->dateTime('updated_at', $precision = 0)->nullable()->default(NULL);
            $table->tinyInteger('is_editable')->default(0)->comment('0-no,yes-1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax');
    }
}
