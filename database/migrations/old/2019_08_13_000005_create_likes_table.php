<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'likes';

    /**
     * Run the migrations.
     * @table likes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('like_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photo_id');
            $table->unsignedInteger('islikes');

            $table->index(["photo_id"], 'fk_users_has_photos_photos2_idx');

            $table->index(["user_id"], 'fk_users_has_photos_users2_idx');


            $table->foreign('user_id', 'fk_users_has_photos_users2_idx')
                ->references('user_id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('photo_id', 'fk_users_has_photos_photos2_idx')
                ->references('photo_id')->on('photos')
                ->onDelete('no action')
                ->onUpdate('no action');
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
