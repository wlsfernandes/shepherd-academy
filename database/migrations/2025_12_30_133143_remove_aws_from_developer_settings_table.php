<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('developer_settings', function (Blueprint $table) {
            $table->dropColumn([
                'aws_access_key_id',
                'aws_secret_access_key',
                'aws_default_region',
                'aws_bucket',
                'aws_debug',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('developer_settings', function (Blueprint $table) {
            $table->string('aws_access_key_id')->nullable();
            $table->string('aws_secret_access_key')->nullable();
            $table->string('aws_default_region')->nullable();
            $table->string('aws_bucket')->nullable();
            $table->boolean('aws_debug')->default(false);
        });
    }
};
