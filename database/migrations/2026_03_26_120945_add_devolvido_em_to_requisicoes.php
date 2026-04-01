<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up()
{
    Schema::table('requisicoes', function (Blueprint $table) {
        $table->timestamp('devolvido_em')->nullable()->after('status');
    });
}

};
