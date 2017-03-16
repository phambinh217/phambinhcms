<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_categories', function(Blueprint $table)
		{
			$table->string('name');
			$table->integer('parent_id')->default(0);
			$table->string('slug');
			$table->string('meta_title')->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('meta_keyword')->nullable();
			$table->string('icon', 50)->nullable();
			$table->text('thumbnail', 65535)->nullable();
			$table->integer('order')->default(0);
			$table->integer('id', true);
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
		Schema::drop('news_categories');
	}

}
