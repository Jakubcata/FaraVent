<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVersionBranch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('esp_binaries', function (Blueprint $table) {
            $table->string('version');
            $table->string('branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('esp_binaries', function (Blueprint $table) {
            $table->dropColumn('version');
            $table->dropColumn('branch');
        });
    }
}
