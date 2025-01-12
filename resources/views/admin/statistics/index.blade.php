@extends('layouts.admin')

@section('content')


<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">

        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Thống kê</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="fs-9 mb-3 text-muted">Tổng doanh thu tháng</div>
                                </div>
                                <div class="d-flex justify-content-center align-items-baseline mb-0">
                                    <div class="fs-20 mb-0 me-2 fw-semibold text-dark">
                                        {{ number_format($revenue, 0, ',', '.') }} đ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="fs-9 mb-3 text-muted">Doanh thu ngày</div>
                                </div>
                                <div class="d-flex justify-content-center align-items-baseline mb-0">
                                    <div class="fs-20 mb-0 me-2 fw-semibold text-dark">
                                        {{ number_format($dailyRevenue) }} đ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="fs-9 mb-3 text-muted">Số lượng sản phẩm</div>
                                </div>
                                <div class="d-flex justify-content-center align-items-baseline mb-0">
                                    <div class="fs-20 mb-0 me-2 fw-semibold text-dark">{{$totalProducts}} sản phẩm</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <div class="fs-9 mb-3 text-muted">Đơn hàng tháng </div>
                                </div>
                                <div class="d-flex justify-content-center align-items-baseline mb-0">
                                    <div class="fs-20 mb-0 me-2 fw-semibold text-dark">{{$totalOrders}} đơn hàng</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">Thống kê doanh thu</h5>
                        <div class="d-flex" style="max-width: 270px;">
                            <select id="monthSelect" class="form-control text-center mx-2" style="width: 150px;">
                                <option value="">Chọn tháng</option>
                                <option value="1">Tháng 1</option>
                                <option value="2">Tháng 2</option>
                                <option value="3">Tháng 3</option>
                                <option value="4">Tháng 4</option>
                                <option value="5">Tháng 5</option>
                                <option value="6">Tháng 6</option>
                                <option value="7">Tháng 7</option>
                                <option value="8">Tháng 8</option>
                                <option value="9">Tháng 9</option>
                                <option value="10">Tháng 10</option>
                                <option value="11">Tháng 11</option>
                                <option value="12">Tháng 12</option>
                                <!-- Thêm các năm khác -->
                            </select>
                            <?php
                            $currentYear = date('Y');
                            $startYear = 1900; // Năm bắt đầu
                            $endYear = 2100; // Năm kết thúc
                            ?>
                            <select id="yearSelect" class="form-control text-center" style="max-width: 90px; height: 40px; overflow-y: auto;">
                                <?php for ($year = $endYear; $year >= $startYear; $year--): ?>
                                    <option value="<?= $year ?>" <?= $year == $currentYear ? 'selected' : '' ?>>
                                        <?= $year ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="revenueChart" class="apex-charts"></div>
                    </div>
                </div>
            </div>
            <!-- Biểu đồ tỷ lệ đơn hàng -->

        </div>


        <!-- Top Selling Products -->
        <div class="row">
            <!-- Form: Lọc theo ngày -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Lọc theo ngày khách hàng, sản phẩm</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.statistics.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Ngày bắt đầu:</label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Ngày kết thúc:</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Lọc</button>
                        </form>
                        <div id="error-message" style="color: red; display: none; margin-top: 10px;"></div>
                    </div>
                </div>
            </div>
            <!-- Sản phẩm bán chạy và Khách hàng thân thiết -->
            <div class="col-md-6 col-xl-6">
                <!-- Sản phẩm bán chạy -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="cpu" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Sản phẩm bán chạy</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group custom-group">
                            @foreach ($topProducts as $product)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="product-list">
                                    <img class="avatar-md p-1 rounded bg-primary-subtle img-fluid me-3"
                                        src="{{ url('storage/' . $product->avata) }}" alt="product-image"
                                        style="width: 45px; height: auto;">
                                    <div class="product-body align-self-center">
                                        <h6 class="m-0 fw-semibold"><a href="{{ route('admin.products.show', $product->id) }}" style="color: black;">{{ $product->name }}</a></h6>
                                    </div>
                                </div>
                                <div class="product-price text-end">
                                    <h6 class="m-0 fw-semibold">Giá: {{ number_format($product->discount_price, 0, '', '.') }} đ</h6>
                                    <p class="mb-0 mt-1 text-muted">Số đơn hàng: {{ $product->total_sold }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-6">
                <!-- Khách hàng thân thiết -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="users" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Khách hàng thân thiết</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group custom-group">
                            @foreach ($topCustomers as $customer)
                            <li class="list-group-item align-items-center d-flex justify-content-between">
                                <div class="product-list">
                                    <div class="product-body align-self-center">
                                        <h6 class="m-0 fw-semibold"><a href="{{ route('admin.users.show', $customer->user->id) }}" style="color: black;">{{ $customer->user->name }}</a></h6>
                                    </div>
                                </div>
                                <div class="product-price text-end">
                                    <h6 class="m-0 fw-semibold">Số tiền đã chi: {{ number_format($customer->total_spent, 0, ',', '.') }} đ</h6>
                                    <p class="mb-0 mt-1 text-muted">Số đơn hàng: {{ $customer->total_orders }}</p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div class="border border-dark rounded-2 me-2 widget-icons-sections">
                                <i data-feather="crosshair" class="widgets-icons"></i>
                            </div>
                            <h5 class="card-title mb-0">Đơn hàng mới gần đây</h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-traffic mb-0 text-center">

                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th class="text-center">Người nhận</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th>HTTT</th>
                                        <th class="text-center">TTTT</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th colspan="2" class="text-center">Tương tác</th>
                                    </tr>
                                </thead>
                                @foreach ($pendingOrders as $order)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0);" class="text-reset">{{ $order->order_code }}</a>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center">{{ $order->user->name }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center">
                                            {{ number_format($order->total_price, 0, ',', '.') }} đ</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{ $order->method }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 text-center">{{ $order->payment_status }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-danger mb-0"><span id="order-{{$order->id}}"
                                                class="badge {{ $order->status->getStatusColor() }}"
                                                style="height: 20px; line-height: 11px; font-size: 11px;">
                                                {{ $order->status->type }}
                                            </span></p>
                                    </td>
                                    <td class="text-center">


                                        <button
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1"
                                            data-bs-toggle="modal" data-bs-target="#orderStatusModal"
                                            data-order-id="{{ $order->id }}"
                                            data-current-status="{{ $order->status_donhang_id }}"
                                            data-return-reason="{{ $order->return_reason }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-alt-secondary mx-1 fs-18 rounded-2 border p-1 me-1 "
                                            data-bs-toggle="tooltip" title="Xem">
                                            <i class="mdi mdi-eye "></i>
                                        </a>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal sửa trạng thái đơn hàng -->
<div class="modal fade" id="orderStatusModal" tabindex="-1" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderStatusModalLabel">Chỉnh sửa trạng thái đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.orders.update', $order->id) }}" method="post" class="order-status-form"
                    data-ajax="true">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="status">Trạng thái</label>
                        <select class="form-select" name="status" id="status" required>
                            @if($order->status_donhang_id === 1)
                            <!-- Chờ xác nhận -->
                            <option value="2">Đã xác nhận</option>
                            <option value="7">Hủy đơn</option>
                            @elseif($order->status_donhang_id === 2)
                            <!-- Đã xác nhận -->
                            <option value="3">Đang vận chuyển</option>
                            @elseif($order->status_donhang_id === 3)
                            <!-- Đang vận chuyển -->
                            <option value="4">Đã giao hàng</option>
                            @elseif($order->status_donhang_id === 8)
                            <!-- Chờ xác nhận hoàn hàng -->
                            <option value="6">Hoàn hàng</option>
                            @else
                            <option value="1" {{ $order->status_donhang_id === 1 ? 'selected' : '' }}>Chờ xác nhận
                            </option>
                            <option value="2" {{ $order->status_donhang_id === 2 ? 'selected' : '' }}>Đã xác nhận
                            </option>
                            <option value="3" {{ $order->status_donhang_id === 3 ? 'selected' : '' }}>Đang vận chuyển
                            </option>
                            <option value="4" {{ $order->status_donhang_id === 4 ? 'selected' : '' }}>Đã giao hàng
                            </option>
                            <option value="5" {{ $order->status_donhang_id === 5 ? 'selected' : '' }}>Hoàn thành
                            </option>
                            <option value="6" {{ $order->status_donhang_id === 6 ? 'selected' : '' }}>Hoàn hàng</option>
                            <option value="8" {{ $order->status_donhang_id === 8 ? 'selected' : '' }}>Chờ xác nhận hoàn
                                hàng</option>
                            <option value="7" {{ $order->status_donhang_id === 7 ? 'selected' : '' }}>Hủy đơn</option>
                            @endif
                        </select>
                    </div>

                    <!-- Phần lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng" -->
                    @if($order->status_donhang_id === 8)
                    <div class="mt-2">
                        <label for="return_reason">Lý do trả hàng</label>
                        <textarea name="return_reason" id="return_reason"
                            class="form-control">{{ old('return_reason', $order->return_reason) }}</textarea>
                    </div>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.36.3"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const monthSelect = document.getElementById("monthSelect");
    const yearSelect = document.getElementById("yearSelect");
    const revenueChartContainer = document.getElementById("revenueChart");

    let chart;

    // Hàm lấy dữ liệu doanh thu từ API
    async function fetchRevenueData(year, month = null) {
        try {
            let url = `http://datn_wd13.test/api/admin/revenue?year=${year}`;
            if (month) {
                url += `&month=${month}`;
            }

            const response = await fetch(url);
            const data = await response.json();

            console.log(data); // In dữ liệu trả về để kiểm tra

            if (response.ok) {
                renderChart(data.revenue, month);
            } else {
                console.error("Error fetching data:", data.message);
            }
        } catch (error) {
            console.error("Error connecting to API:", error);
        }
    }


    // Hàm vẽ biểu đồ
    function renderChart(revenueData, month = null) {
        let categories, revenues;

        if (month) {
            // Nếu có chọn tháng, hiển thị doanh thu theo ngày trong tháng
            categories = Array.from({
                length: 31
            }, (_, i) => i + 1); // Thay đổi từ "Ngày 1" thành số 1

            revenues = categories.map(day => {
                // Tìm kiếm doanh thu theo số ngày
                const revenue = revenueData.find(item => item.day === day);
                console.log(`Looking for day: ${day}, found revenue:`, revenue);
                return revenue ? parseFloat(revenue.total) : 0;
            });


            console.log("Revenues:", revenues); // In ra doanh thu cho tất cả các ngày
        } else {
            // Nếu không chọn tháng, hiển thị doanh thu theo 12 tháng
            const months = Array.from({
                length: 12
            }, (_, i) => i + 1);
            revenues = months.map(month => {
                const revenue = revenueData.find(item => item.month === month);
                return revenue ? parseFloat(revenue.total) : 0;
            });
            categories = months.map(month => `Tháng ${month}`);
        }

        if (chart) {
            chart.destroy();
        }

        const formattedRevenues = revenues.map(revenue => revenue.toLocaleString('vi-VN'));

        const options = {
            chart: {
                type: "bar",
                height: 350
            },
            series: [{
                name: "Doanh thu",
                data: revenues
            }],
            xaxis: {
                categories: categories,
                title: {
                    text: month ? "Ngày" : "Tháng"
                }
            },
            yaxis: {
                title: {
                    text: "Doanh thu (VNĐ)"
                },
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString('vi-VN');
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val.toLocaleString('vi-VN') + " VNĐ";
                    }
                }
            }
        };

        chart = new ApexCharts(revenueChartContainer, options);
        chart.render();
    }

    // Lắng nghe sự kiện thay đổi năm và tháng
    yearSelect.addEventListener("change", function() {
        const selectedYear = yearSelect.value;
        const selectedMonth = monthSelect.value;
        fetchRevenueData(selectedYear, selectedMonth || null); // Truyền null nếu không chọn tháng
    });

    monthSelect.addEventListener("change", function() {
        const selectedYear = yearSelect.value;
        const selectedMonth = monthSelect.value;
        fetchRevenueData(selectedYear, selectedMonth || null); // Truyền null nếu không chọn tháng
    });

    // Mặc định load dữ liệu năm hiện tại
    fetchRevenueData(new Date().getFullYear());
});
</script>


<script>
window.Echo.channel('order-updated')
    .listen('.order.updated', (e) => {
        const orderRow = document.querySelector(`[data-order-id="${e.order.id}"]`);
        if (orderRow) {
            orderRow.querySelector('select[name="status"]').value = e.order.status_donhang_id;
        }
    });
</script>
<script>
var orderStatusModal = document.getElementById('orderStatusModal');
orderStatusModal.addEventListener('show.bs.modal', function(event) {
    var button = event.relatedTarget; // Nút bấm "Sửa" được nhấn
    var orderId = button.getAttribute('data-order-id'); // Lấy ID của đơn hàng
    var currentStatus = parseInt(button.getAttribute('data-current-status')); // Lấy trạng thái hiện tại
    var returnReason = button.getAttribute('data-return-reason'); // Lấy lý do trả hàng (nếu có)

    // Cập nhật lại action của form trong modal
    var form = orderStatusModal.querySelector('form');
    form.action = `/admin/orders/${orderId}`; // Đảm bảo action chứa đúng ID của đơn hàng

    // Lấy dropdown trạng thái và làm sạch các tùy chọn cũ
    var statusSelect = orderStatusModal.querySelector('#status');
    statusSelect.innerHTML = ''; // Xóa toàn bộ các tùy chọn

    // Tùy chọn trạng thái dựa trên trạng thái hiện tại
    if (currentStatus === 1) {
        // Nếu trạng thái là "Chờ xác nhận", chỉ hiển thị 2 tùy chọn
        statusSelect.innerHTML += `<option value="2">Đã xác nhận</option>`;
        statusSelect.innerHTML += `<option value="7">Hủy đơn</option>`;
    } else if (currentStatus === 2) {
        statusSelect.innerHTML += `<option value="3">Đang vận chuyển</option>`;
    } else if (currentStatus === 3) {
        statusSelect.innerHTML += `<option value="4">Đã giao hàng</option>`;
    } else if (currentStatus === 8) {
        statusSelect.innerHTML += `<option value="6">Hoàn hàng</option>`;
    } else {
        var options = [{
                value: 1,
                text: 'Chờ xác nhận'
            },
            {
                value: 2,
                text: 'Đã xác nhận'
            },
            {
                value: 3,
                text: 'Đang vận chuyển'
            },
            {
                value: 4,
                text: 'Đã giao hàng'
            },
            {
                value: 5,
                text: 'Hoàn thành'
            },
            {
                value: 6,
                text: 'Hoàn hàng'
            },
            {
                value: 8,
                text: 'Chờ xác nhận hoàn hàng'
            },
            {
                value: 7,
                text: 'Hủy đơn'
            }
        ];

        options.forEach(function(option) {
            statusSelect.innerHTML += `<option value="${option.value}" ${
                        option.value === currentStatus ? 'selected' : ''
                    }>${option.text}</option>`;
        });
    }

    // Cập nhật textarea lý do trả hàng
    var returnReasonTextarea = orderStatusModal.querySelector('#return_reason');
    returnReasonTextarea.value = returnReason || '';

    // Hiển thị hoặc ẩn textarea lý do trả hàng nếu trạng thái là "Chờ xác nhận hoàn hàng"
    if (currentStatus === 8) {
        returnReasonTextarea.closest('.form-group').style.display = 'block';
    } else {
        returnReasonTextarea.closest('.form-group').style.display = 'none';
    }
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const errorMessage = document.getElementById('error-message');

        function validateDates() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const today = new Date(); // Lấy ngày hiện tại

            let error = ''; // Chuỗi thông báo lỗi

            // Kiểm tra nếu ngày bắt đầu lớn hơn ngày kết thúc
            if (startDate > endDate) {
                error = 'Ngày bắt đầu không được lớn hơn ngày kết thúc.';
            }

            // Kiểm tra nếu ngày bắt đầu ở tương lai
            if (startDate > today) {
                error = 'Ngày bắt đầu không được ở tương lai.';
            }

            // Hiển thị hoặc ẩn thông báo lỗi
            if (error) {
                errorMessage.style.display = 'block';
                errorMessage.textContent = error;
                startDateInput.value = ''; // Reset ngày bắt đầu
            } else {
                errorMessage.style.display = 'none';
            }
        }

        // Lắng nghe sự kiện khi người dùng thay đổi giá trị
        startDateInput.addEventListener('change', validateDates);
        endDateInput.addEventListener('change', validateDates);
    });
</script>


@endsection