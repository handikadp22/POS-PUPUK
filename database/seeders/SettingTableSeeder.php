<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting'        =>   1,
            'nama_perusahaan'   => 'Toko Subur Makmur',
            'alamat'            => 'Jl.Baturetno-Pacitan',
            'telepon'           => '088806148787',
            'tipe_nota'         => 1, //kecil
            'path_logo'         => '/img/logo.png',
        ]);
    }
}
