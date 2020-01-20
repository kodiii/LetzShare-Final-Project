<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentreportsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'commentReports';

    /**
     * Run the migrations.
     * @table commentReports
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('commentReport_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('comment_id');
            $table->string('commentReport_text', 250)->nullable();

            $table->index(["comment_id"], 'fk_users_has_comments_comments1_idx');

            $table->index(["user_id"], 'fk_users_has_comments_users1_idx');


            $table->foreign('user_id', 'fk_users_has_comments_users1_idx')
                ->references('user_id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('comment_id', 'fk_users_has_comments_comments1_idx')
                ->references('comment_id')->on('comments')
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
