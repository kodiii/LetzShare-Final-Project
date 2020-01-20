<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'photos';

    /**
     * Run the migrations.
     * @table photos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('photo_id');
            $table->string('image_URL', 75)->nullable();
            $table->string('image_title', 50)->nullable();
            $table->string('image_description', 250)->nullable();
            $table->integer('likes_sum')->nullable();
            $table->integer('reports_sum')->nullable();
            $table->string('location', 75)->nullable();
            $table->timestamp('date')->nullable();
            $table->unsignedInteger('locality_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');

            $table->index(["locality_id"], 'fk_photos_locations_idx');

            $table->index(["user_id"], 'fk_photos_users1_idx');

            $table->index(["category_id"], 'fk_photos_categories1_idx');


            $table->foreign('locality_id', 'fk_photos_locations_idx')
                ->references('locality_id')->on('locations')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('category_id', 'fk_photos_categories1_idx')
                ->references('category_id')->on('categories')
                ->onDelete('no action')
                ->onUpdate('no action');

            $table->foreign('user_id', 'fk_photos_users1_idx')
                ->references('user_id')->on('users')
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
