<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StatusDonHang;

class StatusDonhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert các trạng thái đơn hàng
        StatusDonHang::insert([
            ['type' => \App\Models\StatusDonHang::CHO_XU_LY],
            ['type' => \App\Models\StatusDonHang::DANG_XU_LY],
            ['type' => \App\Models\StatusDonHang::DA_GIAO],
            ['type' => \App\Models\StatusDonHang::HOAN_TAT],
            ['type' => \App\Models\StatusDonHang::YEU_CAU_TRA_HANG],
            ['type' => \App\Models\StatusDonHang::DA_TRA_HANG],
            ['type' => \App\Models\StatusDonHang::DA_HUY],
            ['type' => \App\Models\StatusDonHang::THAT_BAI],
        ]);
    }
}
