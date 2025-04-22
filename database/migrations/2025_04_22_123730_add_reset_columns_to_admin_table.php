<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('admin', function (Blueprint $table) {
            // Menambahkan kolom untuk token reset password
            $table->string('reset_password_token')->nullable();

            // Menambahkan kolom untuk waktu kadaluarsa token reset
            $table->timestamp('reset_token_expiration')->nullable();

            // Menambahkan kolom status untuk menandai akun aktif atau tidak
            $table->boolean('is_active')->default(true); // Default aktif
        });
    }

    public function down()
    {
        Schema::table('admin', function (Blueprint $table) {
            // Menghapus kolom yang ditambahkan jika migrasi dibatalkan
            $table->dropColumn(['reset_password_token', 'reset_token_expiration', 'is_active']);
        });
    }
};
