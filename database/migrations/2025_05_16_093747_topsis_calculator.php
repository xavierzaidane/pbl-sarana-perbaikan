<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create alternative_topsis table
        Schema::create('alternative_topsis', function (Blueprint $table) {
            $table->id('id_alternative'); // unsigned BIGINT by default
            $table->string('alternative', 100);
        });

        // Create criteria_topsis table
        Schema::create('criteria_topsis', function (Blueprint $table) {
            $table->id('criteria_topsis_id'); // unsigned BIGINT by default
            $table->string('criteria_name', 100)->notNull();
            $table->float('weight')->notNull();
            $table->enum('type', ['max', 'min']);
        });

        // Create sample_topsis table with matching foreign key types
        Schema::create('sample_topsis', function (Blueprint $table) {
            $table->id('id_sample');
            $table->unsignedBigInteger('id_alternative');
            $table->unsignedBigInteger('id_criteria');

            $table->foreign('id_alternative')
                  ->references('id_alternative')
                  ->on('alternative_topsis')
                  ->onDelete('cascade');

            $table->foreign('id_criteria')
                  ->references('criteria_topsis_id')
                  ->on('criteria_topsis')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sample_topsis');
        Schema::dropIfExists('criteria_topsis');
        Schema::dropIfExists('alternative_topsis');
    }
};
