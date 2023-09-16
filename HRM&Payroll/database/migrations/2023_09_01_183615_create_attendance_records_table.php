<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'attendance_records', function ( Blueprint $table ) {
            $table->id();

            $table->foreignId( 'user_id' )->constrained();

            $table->time( 'clock_in' )->nullable();
            $table->time( 'clock_out' )->nullable();

            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'attendance_records' );
    }
};
