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
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->index(["photo_id"], 'fk_users_has_photos_photos3_idx');
            $table->index(["user_id"], 'fk_users_has_photos_users3_idx');

            $table->foreign('user_id', 'fk_users_has_photos_users3_idx')
                ->references('user_id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('photo_id', 'fk_users_has_photos_photos3_idx')
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
