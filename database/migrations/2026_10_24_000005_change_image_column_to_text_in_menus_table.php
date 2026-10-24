<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE menus ALTER COLUMN image TYPE text');
        } elseif ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('ALTER TABLE menus MODIFY image LONGTEXT NULL');
        } else {
            Schema::table('menus', function (Blueprint $table) {
                $table->text('image')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE menus ALTER COLUMN image TYPE varchar(255)');
        } elseif ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('ALTER TABLE menus MODIFY image VARCHAR(255) NULL');
        } else {
            Schema::table('menus', function (Blueprint $table) {
                $table->string('image', 255)->nullable()->change();
            });
        }
    }
};
