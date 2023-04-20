<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestModeratorOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_moderator_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("test_moderator_id");
            $table->bigInteger("test_content_parent_id")->nullable();
            $table->bigInteger("test_content_option_id")->nullable();
            $table->text("test_answer")->nullable();
            $table->string("test_type")->nullable();
            $table->double("answer_score")->default(0);
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
        Schema::dropIfExists('test_moderator_options');
    }
}
