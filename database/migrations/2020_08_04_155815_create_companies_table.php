<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('domain');
            $table->string('bd_driver')->default('mysql');
            $table->string('bd_database');
            $table->string('bd_hostname');
            $table->string('bd_username_read');
            $table->string('bd_password_read');
            $table->string('bd_username_write');
            $table->string('bd_password_write');
            $table->string('bd_port')->default(3306);
            $table->string('theme')->default('theme-default');
            $table->string('active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['domain', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
