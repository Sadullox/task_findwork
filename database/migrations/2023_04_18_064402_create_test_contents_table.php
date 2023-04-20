<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_contents', function (Blueprint $table) {
            $table->id();
            $table->text("title");
            $table->text("desc")->nullable();
            $table->string("test_type")->nullable();
            $table->bigInteger('position_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->boolean("right")->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_contents');
    }
}
