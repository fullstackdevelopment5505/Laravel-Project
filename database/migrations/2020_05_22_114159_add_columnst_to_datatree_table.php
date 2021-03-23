<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnstToDatatreeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datatree', function (Blueprint $table) {
            $table->text('DoNotMail')->nullable();
            $table->text('OwnerMailingName')->nullable();
            $table->text('MailingStreetAddress')->nullable();
            $table->text('MailHouseNumber')->nullable();
            $table->text('MailHouseNumber2')->nullable();
            $table->text('MailDirection')->nullable();
            $table->text('MailStreetName')->nullable();
            $table->text('MailStreetNameSuffix')->nullable();
            $table->text('MailPostDirection')->nullable();
            $table->text('MailUnitNumber')->nullable();
            $table->text('MailCity')->nullable();
            $table->text('AlternateMailingCity')->nullable();
            $table->text('MailState')->nullable();
            $table->text('MailZZIP9')->nullable();
            $table->text('MailCarrierRoute')->nullable();
            $table->text('SitusStreetAddress')->nullable();
            $table->text('SitusHouseNumber')->nullable();
            $table->text('SitusHouseNumber2')->nullable();
            $table->text('SitusDirection')->nullable();
            $table->text('SitusStreetName')->nullable();
            $table->text('SitusMode')->nullable();
            $table->text('SitusPostDirection')->nullable();
            $table->text('SitusUnitNumber')->nullable();
            $table->text('SitusCity')->nullable();
            $table->text('AlternateSitusCity')->nullable();
            $table->text('SitusState')->nullable();
            $table->text('SitusZipCode')->nullable();
            $table->text('SitusZip9')->nullable();
            $table->text('SitusCarrierCode')->nullable();
            $table->text('LegalDescription')->nullable();
            $table->text('APNFormatted')->nullable();
            $table->text('APNUnformatted')->nullable();
            $table->text('AlternateAPN')->nullable();
            $table->text('Subdivision')->nullable();
            $table->text('Latitude')->nullable();
            $table->text('Longitude')->nullable();
            $table->text('Fipscode')->nullable();
            $table->text('Township')->nullable();
            $table->text('Range')->nullable();
            $table->text('Section')->nullable();
            $table->text('Quarter_Section')->nullable();
            $table->text('MunicipalityTownship')->nullable();
            $table->text('CensusTract')->nullable();
            $table->text('CensusBlock')->nullable();
            $table->text('Tract')->nullable();
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
            $table->dropColumn('DoNotMail');
             $table->dropColumn('OwnerMailingName');
             $table->dropColumn('MailingStreetAddress');
             $table->dropColumn('MailHouseNumber');
             $table->dropColumn('MailHouseNumber2');
             $table->dropColumn('MailDirection');
             $table->dropColumn('MailStreetName');
             $table->dropColumn('MailStreetNameSuffix');
             $table->dropColumn('MailPostDirection');
             $table->dropColumn('MailUnitNumber');
             $table->dropColumn('MailCity');
             $table->dropColumn('AlternateMailingCity');
             $table->dropColumn('MailState');
             $table->dropColumn('MailZZIP9');
             $table->dropColumn('MailCarrierRoute');
             $table->dropColumn('SitusStreetAddress');
             $table->dropColumn('SitusHouseNumber');
             $table->dropColumn('SitusHouseNumber2');
             $table->dropColumn('SitusDirection');
             $table->dropColumn('SitusStreetName');
             $table->dropColumn('SitusMode');
             $table->dropColumn('SitusPostDirection');
             $table->dropColumn('SitusUnitNumber');
             $table->dropColumn('SitusCity');
             $table->dropColumn('AlternateSitusCity');
             $table->dropColumn('SitusState');
             $table->dropColumn('SitusZipCode');
             $table->dropColumn('SitusZip9');
             $table->dropColumn('SitusCarrierCode');
             $table->dropColumn('LegalDescription');
             $table->dropColumn('APNFormatted');
             $table->dropColumn('APNUnformatted');
             $table->dropColumn('AlternateAPN');
             $table->dropColumn('Subdivision');
             $table->dropColumn('Latitude');
             $table->dropColumn('Longitude');
             $table->dropColumn('Fipscode');
             $table->dropColumn('Township');
             $table->dropColumn('Range');
             $table->dropColumn('Section');
             $table->dropColumn('Quarter_Section');
             $table->dropColumn('MunicipalityTownship');
             $table->dropColumn('CensusTract');
             $table->dropColumn('CensusBlock');
             $table->dropColumn('Tract');
        });
    }
}
