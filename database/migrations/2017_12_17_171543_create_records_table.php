<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->date('made_at');
	        $table->date('value_at');
	        $table->integer('method_id')->unsigned();
	        $table->integer('concept_id')->unsigned();
	        $table->text('explanation');
	        $table->decimal('value',10,2);
	        $table->tinyInteger('isvalid')->defaults(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('records');
    }
}
