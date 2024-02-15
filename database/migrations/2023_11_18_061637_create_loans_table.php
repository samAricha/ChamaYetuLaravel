<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('chama_account_id');
            $table->decimal('loan_amount', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->date('loan_date');
            $table->string('loan_status'); // e.g., approved, pending, paid, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
