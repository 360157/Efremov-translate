<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('langs')) {
            Schema::create('langs', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('index')->unique();
                $table->string('name');
                $table->boolean('is_active')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('langs', function (Blueprint $table) {
                if (!Schema::hasColumn('langs', 'index')) {
                    $table->string('index')->unique();
                }
                if (!Schema::hasColumn('langs', 'name')) {
                    $table->string('name');
                }
                if (!Schema::hasColumn('langs', 'is_active')) {
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
        Schema::dropIfExists('langs');
    }
}
