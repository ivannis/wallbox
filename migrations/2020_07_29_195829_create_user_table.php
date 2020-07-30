<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->integer('externalId')->unique();
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('email', 100)->unique();
            $table->string('country', 2);
            $table->integer('chargerId')->unique();

            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
            $table->timestamp('activatedAt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
}
