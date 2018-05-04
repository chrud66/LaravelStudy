<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseNameAndRenamePublicColumnOnProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('name', 50)->change();
            $table->renameColumn('public', 'is_public');
            $table->string('label', 20)->nullable();
            $table->string('label2', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->string('name', 20)->change();
            $table->renameColumn('is_public', 'public');
            $table->dropColumn('label');
            $table->dropColumn('label2');
        });
    }
}
