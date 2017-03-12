<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('option_values', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('option_id');
			$table->string('value');
			$table->timestamps();
			$table->integer('order')->default(0);
			$table->string('image')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('option_values');
	}

}
