<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSendgridDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendgrid_data', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('property_id');
			$table->string('email');
			$table->text('message');
			$table->string('type');
			$table->string('sg_event_id');
			$table->string('sg_message_id');
			$table->string('smtp_id');
			$table->string('event');
			$table->string('category');
			$table->string('ip');
			$table->string('response');
			$table->string('tls');
			$table->string('timestamp');
			$table->timestamp('date');
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
        Schema::dropIfExists('sendgrid_data');
    }
}
