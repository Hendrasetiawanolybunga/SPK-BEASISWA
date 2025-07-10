<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_create_criterias_table.php

public function up(): void
{
    Schema::create('criterias', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // nama kriteria
        $table->enum('type', ['benefit', 'cost']);
        $table->float('weight'); // bobot antara 0 - 1
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('criterias');
    }
};
