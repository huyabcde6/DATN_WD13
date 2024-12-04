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
            ['type' => StatusDonHang::CHO_XAC_NHAN],
            ['type' => StatusDonHang::DA_XAC_NHAN],
            ['type' => StatusDonHang::DANG_VAN_CHUYEN],
            ['type' => StatusDonHang::DA_GIAO_HANG],
            ['type' => StatusDonHang::HOAN_THANH],
            ['type' => StatusDonHang::HOAN_HANG],
            ['type' => StatusDonHang::DA_HUY],
            ['type' => StatusDonHang::CHO_HOAN],
        ]);
    }
}
