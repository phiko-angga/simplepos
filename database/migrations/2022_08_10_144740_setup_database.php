<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if(Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'level_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->integer('level_id');
                });
            }
        }

        Schema::create('level', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('nama');
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('kode');
            $table->string('nama');
            $table->string('deskripsi');
            $table->double('harga_beli');
            $table->double('harga_jual');
            $table->timestamps();
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('no_transaksi');
            $table->double('total');
            $table->double('bayar');
            $table->double('selisih');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('no_transaksi');
            $table->integer('barang_id');
            $table->integer('jumlah');
            $table->double('harga_jual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('level_id');
            });
        }
        
        Schema::dropIfExists('level');
        Schema::dropIfExists('barang');
        Schema::dropIfExists('penjualan');
        Schema::dropIfExists('penjualan_detail');
    }
}
