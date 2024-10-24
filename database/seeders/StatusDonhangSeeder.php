<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusDonHang;

class StatusDonhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusDonHang::insert([
            ['type' => 'Chờ xác nhận'],
            ['type' => 'Đang xử lý'],
            ['type' => 'Đã giao'],
            ['type' => 'Đã hủy']
        ]);
    }
}
