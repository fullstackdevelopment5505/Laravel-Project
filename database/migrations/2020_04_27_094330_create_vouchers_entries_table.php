<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('voucher_no')->nullable();
            $table->string('purpose')->nullable();
            $table->decimal('amount')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('rem_total');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers_entries');
    }
}
