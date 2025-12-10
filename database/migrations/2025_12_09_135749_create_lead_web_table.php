<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadWebTable extends Migration
{
    public function up()
    {
        Schema::create('lead_web', function (Blueprint $table) {
            $table->increments('id');

            // Foreign key hacia leads.id (INT UNSIGNED)
            $table->unsignedInteger('lead_id');

            // Flag si es lead generado desde web
            $table->boolean('is_web')->default(false);

            // Solo created_at (sin updated_at)
            $table->timestamp('created_at')->useCurrent();

            // FK constraint
            $table->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('lead_web', function (Blueprint $table) {
            $table->dropForeign(['lead_id']);
        });

        Schema::dropIfExists('lead_web');
    }
}
