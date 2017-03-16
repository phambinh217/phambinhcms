<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('sender_id');
			$table->integer('receiver_id')->default(-1);
			$table->text('content', 65535)->nullable();
			$table->string('subject')->nullable();
			$table->boolean('check')->default(0);
			$table->integer('status')->default(0);
			$table->timestamps();
			$table->integer('delete')->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('messages');
	}

}
