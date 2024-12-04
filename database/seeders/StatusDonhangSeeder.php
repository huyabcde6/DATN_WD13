<?php

namespace Database\Seeders;

<<<<<<< HEAD
use Illuminate\Database\Seeder;
use App\Models\StatusDonHang;
=======
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19

class StatusDonhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
<<<<<<< HEAD
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
=======
        //
>>>>>>> f018d289cd5108f0c53dc41cccfaf49fbd33aa19
    }
}
