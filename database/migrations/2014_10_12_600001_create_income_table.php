<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            
            $table->increments('id', 11);
            $table->integer('receipt_number')->nullable();

            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('income_type')->onDelete('cascade');

            $table->string('ref',200)->nullable();
            $table->decimal('total', 10, 2)->nullable();

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
        Schema::dropIfExists('income');
    }
}
