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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('documentType');
            $table->string('path');
            $table->timestamp('creationDate')->nullable();
            $table->unsignedBigInteger('categorieId')->nullable();
            $table->unsignedBigInteger('userid')->nullable();


            $table->foreign('categorieId')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('userid')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('documents', function (Blueprint $table) {
            
            $table->dropForeign(['categorieId']);
            $table->dropForeign(index: ['userid']);
        });

        Schema::dropIfExists('documents');
    }
};
