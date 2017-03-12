<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->default(0);
			$table->string('first_name');
			$table->string('last_name');
			$table->string('email');
			$table->string('phone');
			$table->text('address', 65535);
			$table->text('comment', 65535);
			$table->integer('status_id');
			$table->integer('currency_id');
			$table->string('currency_code');
			$table->decimal('currency_value', 15, 8)->default(1.00000000);
			$table->decimal('total', 15, 4)->default(0.0000);
			$table->string('confirm_token')->nullable();
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
		Schema::drop('orders');
	}

}
