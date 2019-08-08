<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFailedAtColumnToTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(TOTEM_TABLE_PREFIX . 'task_results', function (Blueprint $table) {
            $table->dateTime('failed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(TOTEM_TABLE_PREFIX . 'task_results', function (Blueprint $table) {
            $table->dropColumn('failed_at');
        });
    }
}
