<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //  'token','letterTypeId','departmentId','fileNumber','priority','letterReleaseDate','note','assemblyId','cityType','wardId','wardAreaId','zillaParishadId','talukaPanchayatId','gaonId','documentFrom','deliveredBy','documentFor','receivedBy','registerType','status','outwardId','created_by','updated_by','isActive'
        Schema::create('register', function (Blueprint $table) {
            $table->id();
            $table->string('token')->nullable();
            $table->string('letterTypeId')->nullable();
            $table->bigInteger('departmentId')->nullable();
            $table->string('fileNumber')->nullable();
            $table->string('priority')->nullable();
            $table->string('letterReleaseDate')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('assemblyId')->nullable();
            $table->string('cityType')->nullable();
            $table->bigInteger('wardId')->nullable();
            $table->bigInteger('wardAreaId')->nullable();
            $table->bigInteger('zillaParishadId')->nullable();
            $table->bigInteger('talukaPanchayatId')->nullable();
            $table->bigInteger('gaonId')->nullable();
            $table->bigInteger('documentFrom')->nullable();
            $table->bigInteger('deliveredBy')->nullable();
            $table->bigInteger('documentFor')->nullable();
            $table->bigInteger('receivedBy')->nullable();
            $table->string('registerType')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('outwardId')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->integer('isActive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register');
    }
};
