<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->json('title');
            $table->string('url')->nullable();
            $table->string('slug')->nullable();
            $table->integer('parent_id')->nullable()->default(null);
            $table->enum('target',['_self','_blank']);
            $table->enum('group',['page','shop','custom_link','category','categories','brand','tag']);
            $table->enum('type',['category','brand','tag','product'])->nullable()->default(null);
            $table->integer('conn_id')->nullable()->default(null);
            $table->integer('sort_order')->default(1);
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
        Schema::dropIfExists('menu_items');
    }
}
