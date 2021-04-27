<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Query\QueryException;

class AddsCompositeKeysToGeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general', function (Blueprint $table) {
                $table->timestamp('created_at')->default($table)->useCurrent()->change();
                $table->primary(['created_at', 'email']);
            });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general', function (Blueprint $table) {
            //
        });
    }
}
