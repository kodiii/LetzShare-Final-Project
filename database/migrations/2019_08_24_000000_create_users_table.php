<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('user_id');
            $table->enum('user_type', ['photographer','admin'])->default('photographer');
            $table->string('name',100)->nullable(false);
            $table->string('email', 128)->nullable(false);
            $table->string('password', 100)->nullable(false);
            $table->string('user_location', 100)->nullable();
            $table->string('user_photo', 100)->default('uploads/users/default_user.jpg');
            $table->string('user_description')->nullable();
            $table->timestamp('email_verified_at')->useCurrent();
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
