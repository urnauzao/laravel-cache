<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados_brasil', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->string('uf', 60)->primary()->unique();
            $table->string('nome', 60);
            $table->string('capital', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estados_brasil');
    }
};
