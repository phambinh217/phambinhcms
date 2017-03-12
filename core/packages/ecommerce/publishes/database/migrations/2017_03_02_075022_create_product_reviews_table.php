<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_reviews', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('product_id');
			$table->integer('author_id');
			$table->string('name');
			$table->string('meta_title')->nullable();
			$table->string('meta_keyword')->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('slug');
			$table->timestamps();
			$table->text('content')->nullable();
			$table->string('thumbnail')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_reviews');
	}

}
