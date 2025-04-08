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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); 
            $table->string('queue');  
            $table->integer('attempts')->default(0);  
            $table->timestamp('reserved_at')->nullable();  
            $table->timestamp('available_at')->nullable();
            $table->timestamps(); 
            $table->text('payload'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
