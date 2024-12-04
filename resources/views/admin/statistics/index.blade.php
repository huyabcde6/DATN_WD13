@extends('layouts.admin')

@section('content')


<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Ecommerce</h4>
            </div>
            <form method="GET" action="{{ route('admin.statistics.index') }}" class="d-flex align-items-center">
                <select name="filter" class="form-select me-2" style="width: 200px;">
                    <option value="">Tất cả</option>
                    <option value="day" {{ request('filter') == 'day' ? 'selected' : '' }}>Hôm nay</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Tuần này</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Tháng này</option>
                    <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Năm nay</option>
                </select>
                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>

        <!-- <div class="row">
            @foreach ($orderStatuses as $status)
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="fs-14 mb-1 text-muted">{{ $status->type }}</div>
                                </div>

                                <div class="d-flex align-items-baseline mb-0">
                                    <div class="fs-20 mb-0 me-2 fw-semibold text-dark">{{ $status->orders_count }}</div>
                                </div>
                            </div>

                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <div id="new-orders" class="apex-charts"></div>
                            </div>
                        </div>

                        <p class="d-flex align-content-center border-top mb-0 pt-3 mt-3">
                            <span class="me-2 d-flex align-content-center fw-medium text-success">
                                +39.40%
                                <i data-feather="trending-up" class="ms-2" style="height: 22px; width: 22px;"></i>
                            </span>
                            <span class="fw-medium me-1 d-flex">Increased</span>
                            Orders
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div> -->


        <!-- Sales Chart -->
        <div class="row">
            <!-- Biểu đồ thống kê doanh thu -->
            <div class="col-md-12 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thống kê doanh thu</h5>
                    </div>
                    <div class="card-body">
                        <div id="revenueChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ tỷ lệ đơn hàng -->
            <div class="col-md-12 col-xl-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tỷ lệ đơn hàng</h5>
                    </div>
                    <div class="card-body">
                        <div id="orderStatusChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>


            <!-- Top Selling Products -->
        <div class="card">
            <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="cpu" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Top Selling Products</h5>
                        </div>
            </div>

                    <!-- start card body -->
            <div class="card-body">
                        <ul class="list-group custom-group">
                            @foreach($bestSellingProducts as $product)
                                <li class="list-group-item align-items-center d-flex justify-content-between border-bottom">
                                    <div class="product-list">
                                        @php
                                            $productDetail = $product->productDetail;
                                            $productImage = $productDetail->products->avata ?? 'default-image.jpg'; // Đảm bảo có ảnh mặc định nếu không có ảnh
                                        @endphp
                                        <img class="avatar-md p-1 rounded-circle bg-primary-subtle img-fluid me-3"
                                            src="{{ asset('storage/' . $productImage) }}" alt="product-image">

                                        <div class="product-body align-self-center">
                                            <h6 class="m-0 fw-semibold">{{ $productDetail->products->name }}</h6>
                                            <p class="mb-0 mt-1 text-muted">{{ $productDetail->products->category->name ?? 'Uncategorized' }}</p>
                                        </div>
                                    </div>

                                    <div class="product-price ">
                                        <h6 class="m-0 fw-semibold">{{ number_format($productDetail->products->price, 0, ',', '.') }} đ</h6>
                                        <p class="mb-0 mt-1 text-muted">{{ $product->total_quantity }} Sold</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
            </div>
                    <!-- end card body -->
        </div>
        <!-- <div class="row">
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="crosshair" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Recent Order</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0">

                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Price</th>
                                        <th>Created</th>
                                        <th>Modified</th>
                                        <th colspan="2">Status</th>
                                    </tr>
                                </thead>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#3413</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-12.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Richard Dom</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">82</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$480.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">August 09, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">August 18, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-danger mb-0">Cancelled</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#4125</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-11.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Randal Dare</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">93</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$568.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">January 19, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">March 09, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0">Refunded</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#6532</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-13.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Bickle Bob</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">56</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$398.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">April 25, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">June 21, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-danger mb-0">Cancelled</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#7405</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-14.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Emma Wilson</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">68</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$652.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">September 24, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">November 13, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-muted mb-0">Refunded</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#4526</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-15.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Hugh Jackma</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">52</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$746.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">July 28, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">August 21, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-danger mb-0">Cancelled</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">#1054</a>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <img src="assets/images/users/user-12.jpg"
                                            class="avatar avatar-sm rounded-2 me-3" />
                                        <p class="mb-0 fw-medium">Angelina Hose</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">45</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">$205.00</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">June 09, 2023</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">August 25, 2023</p>
                                    </td>
                                    <td>
                                        <p class="text-danger mb-0">Cancelled</p>
                                    </td>
                                    <td>
                                        <a href="#"><i
                                                class="mdi mdi-pencil text-muted fs-18 rounded-2 border p-1 me-1"></i></a>
                                        <a href="#"><i
                                                class="mdi mdi-delete text-muted fs-18 rounded-2 border p-1"></i></a>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>




@endsection
@section('js')


<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.36.3"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const revenueChart = new ApexCharts(document.querySelector("#revenueChart"), {
            chart: { type: 'bar', height: 350 },
            series: [{ name: 'Doanh thu (VNĐ)', data: @json($dailyRevenue->pluck('total')) }],
            xaxis: { categories: @json($dailyRevenue->pluck('date')) },
            yaxis: { title: { text: 'Doanh thu (VNĐ)' } },
            title: { text: 'Thống kê doanh thu', align: 'center' }
        });
        revenueChart.render();

        // Cấu hình biểu đồ Pie với màu sắc riêng biệt
        const orderStatusChart = new ApexCharts(document.querySelector("#orderStatusChart"), {
            chart: { type: 'pie', height: 350 },
            series: @json($orderStatuses->pluck('percentage')),
            labels: @json($orderStatuses->pluck('type')),
            colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0', '#546E7A', '#D4526E', '#8D8DAA'], // Màu cho từng trạng thái
            legend: { position: 'bottom' }
        });
        orderStatusChart.render();
    });
</script>

@endsection