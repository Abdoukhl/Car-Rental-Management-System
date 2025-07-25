<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->string('driving_license_path')->nullable()->after('status');
            $table->string('id_proof_path')->nullable()->after('driving_license_path');
            $table->string('residence_proof_path')->nullable()->after('id_proof_path');
        });
    }

    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropColumn(['driving_license_path', 'id_proof_path', 'residence_proof_path']);
        });
    }
};