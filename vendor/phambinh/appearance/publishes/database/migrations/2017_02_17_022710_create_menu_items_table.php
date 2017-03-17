<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenuItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menu_items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('menu_id')->unsigned();
			$table->integer('parent_id')->unsigned()->nullable()->default(0);
			$table->integer('object_id')->unsigned()->nullable();
			$table->string('type')->default('0');
			$table->string('url')->nullable();
			$table->string('title')->nullable();
			$table->string('icon')->nullable();
			$table->string('css_class')->nullable();
			$table->integer('order')->unsigned()->default(0);
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
		Schema::drop('menu_items');
	}

}
