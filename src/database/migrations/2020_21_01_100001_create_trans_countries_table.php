<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('code', 2)->unique();
                $table->string('name');
                $table->boolean('is_active')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('countries', function (Blueprint $table) {
                if (!Schema::hasColumn('countries', 'index')) {
                    $table->string('code', 2)->unique();
                }
                if (!Schema::hasColumn('countries', 'name')) {
                    $table->string('name');
                }
                if (!Schema::hasColumn('countries', 'is_active')) {
                    $table->boolean('is_active')->default(0);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
