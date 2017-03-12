<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->text('content');
			$table->string('meta_title')->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('meta_keyword')->nullable();
			$table->string('slug');
			$table->text('thumbnail', 65535)->nullable();
			$table->integer('author_id');
			$table->timestamps();
			$table->dateTime('available_at')->nullable();
			$table->boolean('status')->default(0);
			$table->boolean('shipping')->default(0);
			$table->boolean('subtract')->default(0);
			$table->integer('quantity')->default(0);
			$table->decimal('promotional_price', 15, 0)->default(0);
			$table->decimal('price', 15, 0)->default(0);
			$table->string('code')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
