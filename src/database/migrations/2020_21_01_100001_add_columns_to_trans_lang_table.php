<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToTransLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('langs', function (Blueprint $table) {
            if (!Schema::hasColumn('langs', 'dir')) {
                $table->boolean('dir')->default(0)->after('flag');
            }
            if (!Schema::hasColumn('langs', 'countries')) {
                $table->text('countries')->nullable()->after('dir');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function($table) {
            $table->dropColumn('dir');
            $table->dropColumn('countries');
        });
    }
}