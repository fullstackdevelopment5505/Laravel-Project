<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDatatreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datatree', function (Blueprint $table) {
            $table->text('OwnerName1Full')->nullable();
            $table->text('OwnerFirstName_MI1')->nullable();
            $table->text('Owner1FirstName')->nullable();
            $table->text('OwnerLastname1')->nullable();
            $table->text('Owner1Type')->nullable();
            $table->text('Owner1PropertiesOwned')->nullable();
            $table->text('OwnerName2Full')->nullable();
            $table->text('OwnerFirstName_MI2')->nullable();
            $table->text('Owner2FirstName')->nullable();
            $table->text('OwnerLastname2')->nullable();
            $table->text('Owner2Type')->nullable();
            $table->text('Owner2PropertiesOwned')->nullable();
            $table->text('OwnerName3Full')->nullable();
            $table->text('OwnerName4Full')->nullable();
            $table->text('OwnersAll')->nullable();
            $table->text('OwnerStatus')->nullable();
            $table->text('OwnerRightsVestingCode')->nullable();
            $table->text('OwnerEtalVestingCode')->nullable();
            $table->text('OwnerRelationshipType')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datatree', function (Blueprint $table) {
           $table->dropColumn('OwnerName1Full');
             $table->dropColumn('OwnerFirstName_MI1');
             $table->dropColumn('Owner1FirstName');
             $table->dropColumn('OwnerLastname1');
             $table->dropColumn('Owner1Type');
             $table->dropColumn('Owner1PropertiesOwned');
             $table->dropColumn('OwnerName2Full');
             $table->dropColumn('OwnerFirstName_MI2');
             $table->dropColumn('Owner2FirstName');
             $table->dropColumn('OwnerLastname2');
             $table->dropColumn('Owner2Type');
             $table->dropColumn('Owner2PropertiesOwned');
             $table->dropColumn('OwnerName3Full');
             $table->dropColumn('OwnerName4Full');
             $table->dropColumn('OwnersAll');
             $table->dropColumn('OwnerStatus');
             $table->dropColumn('OwnerRightsVestingCode');
             $table->dropColumn('OwnerEtalVestingCode');
             $table->dropColumn('OwnerRelationshipType');
        });
    }
}
