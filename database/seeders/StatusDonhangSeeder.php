<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusDonhangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusDonHang::insert([
            ['type' => 'Chờ xác nhận'],
            ['type' => 'Đã xác nhận'],
            ['type' => 'Đang vận chuyển'],
            ['type' => 'Đã giao hàng'],
            ['type' => 'Đã hủy']
        ]);

    }
}
