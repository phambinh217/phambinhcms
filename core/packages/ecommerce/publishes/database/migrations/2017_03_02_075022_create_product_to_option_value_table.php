<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToOptionValueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_to_option_value', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('product_id');
			$table->integer('option_id');
			$table->integer('value_id');
			$table->string('prefix', 1)->default('+');
			$table->decimal('price', 15, 0)->nullable()->default(0);
			$table->integer('quantity')->nullable()->default(0);
			$table->boolean('subtract')->nullable()->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_to_option_value');
	}

}
