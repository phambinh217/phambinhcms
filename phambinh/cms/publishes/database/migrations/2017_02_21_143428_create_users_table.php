<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->boolean('status')->default(0);
			$table->integer('role_id')->default(0);
			$table->string('last_name')->nullable();
			$table->string('first_name')->nullable();
			$table->date('birth')->default('0000-00-00');
			$table->string('phone')->nullable();
			$table->string('avatar', 200)->nullable();
			$table->text('address', 65535)->nullable();
			$table->string('website', 255)->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('google_plus', 255)->nullable();
            $table->string('about', 255)->nullable();
            $table->string('job', 255)->nullable();
            $table->string('api_token', 255)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
