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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->date('date_deb');
            $table->date('date_fin');
            $table->string('etat');
            $table->boolean('prio');
            $table->unsignedBigInteger('man_id')->nullable();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->unsignedBigInteger('pro_id')->nullable();
            $table->foreign('man_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');       
            $table->foreign('emp_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');       
            $table->foreign('pro_id')->references('id')->on('projets')->onDelete('cascade')->onUpdate('cascade');       
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
