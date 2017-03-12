<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_product_options', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('order_id');
			$table->integer('order_product_id');
			$table->integer('option_id');
			$table->integer('value_id');
			$table->string('name');
			$table->string('value')->nullable();
			$table->string('prefix', 1)->default('+');
			$table->decimal('price', 15, 0)->default(0);
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
		Schema::drop('order_product_options');
	}

}
