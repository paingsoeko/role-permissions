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
        Schema::create('context_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('context_id');
            $table->unsignedBigInteger('permission_id');
            $table->timestamps();

            $table->foreign('context_id')->references('id')->on('contexts')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('context_permissions');
    }
};
