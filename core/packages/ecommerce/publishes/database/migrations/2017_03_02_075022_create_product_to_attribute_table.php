<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductToAttributeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_to_attribute', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('product_id');
			$table->text('value', 65535);
			$table->integer('attribute_id');
			$table->timestamps();
			$table->integer('order')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_to_attribute');
	}

}
