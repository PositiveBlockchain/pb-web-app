<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSdgGoalsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sdg_goals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->smallInteger('goal_number');
            $table->text('goal_icon_path');
            $table->text('goal_name');
            $table->longText('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sdgs');
    }
}
