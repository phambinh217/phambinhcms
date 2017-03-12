<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop_tags', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('slug');
			$table->string('meta_title')->nullable();
			$table->text('meta_description', 65535)->nullable();
			$table->string('meta_keyword')->nullable();
			$table->string('icon', 50)->nullable();
			$table->integer('order')->default(0);
			$table->timestamps();
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
		Schema::drop('shop_tags');
	}

}
