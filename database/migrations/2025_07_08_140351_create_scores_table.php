<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_scores_table.php

public function up(): void
{
    Schema::create('scores', function (Blueprint $table) {
        $table->id();
        $table->foreignId('alternative_id')->constrained()->onDelete('cascade');
        $table->foreignId('criteria_id')->constrained()->onDelete('cascade');
        $table->float('value'); // nilai input
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scores');
    }
};
