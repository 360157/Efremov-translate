<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToTransDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trans_data', function (Blueprint $table) {
            $table->foreign('translation_id')->references('id')->on('trans');
            $table->foreign('lang_id')->references('id')->on('langs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trans_data', function (Blueprint $table) {
            $table->dropForeign('trans_data_translation_id_foreign');
            $table->dropForeign('trans_data_lang_id_foreign');
        });
    }
}
