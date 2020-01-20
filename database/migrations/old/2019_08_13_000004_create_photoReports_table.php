<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoreportsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'photoReports';

    /**
     * Run the migrations.
     * @table photoReports
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('photoReport_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('photo_id');
            $table->string('photoReport_text', 250)->nullable();

            $table->index(["photo_id"], 'fk_users_has_photos_photos3_idx');

            $table->index(["user_id"], 'fk_users_has_photos_users3_idx');


            $table->foreign('user_id', 'fk_users_has_photos_users3_idx')
                ->references('user_id')->on('users')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('photo_id', 'fk_users_has_photos_photos3_idx')
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
