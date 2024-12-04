import "./bootstrap.js";
Pusher.logToConsole = true;

var pusher = new Pusher("957ee470fe95bd43edc6", {
    cluster: "ap1",
});

var channel = pusher.subscribe("order");
channel.bind("OderEvent", function (data) {
    // Tìm thẻ <h5> hiển thị trạng thái của đơn hàng dựa vào ID
    const statusHeader = document.querySelector(`#order-status-${data.id}`);

    if (statusHeader) {
        // Ánh xạ ID trạng thái thành tên trạng thái
        let statusText = "";

        switch (data.status) {
            case 1: // ID trạng thái CHO_XAC_NHAN
                statusText = "Chờ xác nhận";
                break;
            case 2: // ID trạng thái DA_XAC_NHAN
                statusText = "Đã xác nhận";
                break;
            case 3: // ID trạng thái DANG_VAN_CHUYEN
                statusText = "Đang vận chuyển";
                break;
            case 4: // ID trạng thái DA_GIAO
                statusText = "Đã giao hàng";
                break;
            case 5: // ID trạng thái DA_HUY
                statusText = "Hoàn thành";
                break;
            case 6: // ID trạng thái DA_HUY
                statusText = "Đã hủy";
                break;
            case 7: // ID trạng thái DA_HUY
                statusText = "Hoàn hàng";
                break;
            case 8: // ID trạng thái DA_HUY
                statusText = "Chờ hoàn";
                break;
            default:
                statusText = "Không xác định";
                break;
        }

        // Cập nhật nội dung của thẻ <h5>
        statusHeader.innerHTML = `<strong>Trạng thái:</strong> ${statusText}`;
    } else {
        console.log("Không tìm thấy thẻ <h5> trạng thái của đơn hàng.");
    }
});
