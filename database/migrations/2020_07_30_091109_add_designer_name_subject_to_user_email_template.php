<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignerNameSubjectToUserEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_email_template', function (Blueprint $table) {
            $table->string('template_designer_name');
            $table->string('template_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_email_template', function (Blueprint $table) {
            $table->dropColumn('template_designer_name');
            $table->dropColumn('template_subject');
        });
    }
}
