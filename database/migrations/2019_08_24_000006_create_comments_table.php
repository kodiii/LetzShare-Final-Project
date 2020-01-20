<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'comments';

    /**
     * Run the migrations.
     * @table comments
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('comment_id');
            $table->string('comment_text', 250)->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photo_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->index(["photo_id"], 'fk_Comments_photos1_idx');
            $table->index(["user_id"], 'fk_Comments_users1_idx');

            $table->foreign('user_id', 'fk_Comments_users1_idx')
                ->references('user_id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('photo_id', 'fk_Comments_photos1_idx')
                ->references('photo_id')->on('photos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
