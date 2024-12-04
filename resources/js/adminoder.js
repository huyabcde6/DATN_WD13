import "./bootstrap.js";
Pusher.logToConsole = true;

var pusher = new Pusher("957ee470fe95bd43edc6", {
    cluster: "ap1",
});

var channel = pusher.subscribe("order");
channel.bind("OderEvent", function (data) {
    // Tìm thẻ <span> chứa trạng thái của đơn hàng dựa vào ID
    const statusBadge = document.querySelector(`#order-${data.id}`);

    if (statusBadge) {
        // Ánh xạ ID trạng thái thành tên trạng thái và màu sắc
        let statusText = "";
        let statusColor = "";

        switch (data.status) {
            case 1: // ID trạng thái CHO_XAC_NHAN
                statusText = "Chờ xác nhận";
                statusColor = "badge-warning"; // Thay bằng class màu tương ứng
                break;
            case 2: // ID trạng thái DA_XAC_NHAN
                statusText = "Đã xác nhận";
                statusColor = "badge-success"; // Thay bằng class màu tương ứng
                break;
            case 3: // ID trạng thái DANG_VAN_CHUYEN
                statusText = "Đang vận chuyển";
                statusColor = "badge-info"; // Thay bằng class màu tương ứng
                break;
            case 4: // ID trạng thái DA_GIAO
                statusText = "Đã giao hàng";
                statusColor = "badge-success"; // Thay bằng class màu tương ứng
                break;
            case 5: // ID trạng thái DA_HUY
                statusText = "Hoàn thành";
                statusColor = "badge-danger"; // Thay bằng class màu tương ứng
                break;
            case 6: // ID trạng thái DA_HUY
                statusText = "Đã hủy";
                statusColor = "badge-danger"; // Thay bằng class màu tương ứng
                break;
            case 7: // ID trạng thái DA_HUY
                statusText = "Hoàn hàng";
                statusColor = "badge-danger"; // Thay bằng class màu tương ứng
                break;
            case 8: // ID trạng thái DA_HUY
                statusText = "Chờ hoàn";
                statusColor = "badge-danger"; // Thay bằng class màu tương ứng
                break;
            default:
                statusText = "Không xác định";
                statusColor = "badge-secondary"; // Mặc định
                break;
        }

        // Cập nhật nội dung và class của thẻ <span>
        statusBadge.textContent = statusText;
    } else {
        console.log("Không tìm thấy thẻ <span> trạng thái của đơn hàng.");
    }
});
