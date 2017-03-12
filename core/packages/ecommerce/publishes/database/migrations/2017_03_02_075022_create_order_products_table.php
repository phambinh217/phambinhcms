<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_products', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('order_id');
			$table->integer('product_id');
			$table->string('name');
			$table->string('code');
			$table->integer('quantity');
			$table->decimal('price', 15, 0)->default(0);
			$table->timestamps();
			$table->text('options')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_products');
	}

}
