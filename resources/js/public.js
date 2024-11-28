import "./bootstrap.js";
Pusher.logToConsole = true;

var pusher = new Pusher("957ee470fe95bd43edc6", {
    cluster: "ap1",
});

var channel = pusher.subscribe("order");
channel.bind("OderEvent", function (data) {
    const orderRow = document.querySelector(`#order-row-${data.id}`);

    if (orderRow) {
        // Tìm cột Status trong hàng (cột thứ 4)
        const statusCell = orderRow.querySelector("td:nth-child(4)");

        if (statusCell) {
            // Ánh xạ ID trạng thái thành tên trạng thái
            let statusText = "";

            switch (data.status) {
                case 1: // ID trạng thái CHO_XAC_NHAN
                    statusText = "Chờ xác nhận";
                    break;
                case 2: // ID trạng thái CHO_XAC_NHAN
                    statusText = "Đã xác nhận";
                    break;
                case 3: // ID trạng thái DANG_VAN_CHUYEN
                    statusText = "Đang vận chuyển";
                    break;
                case 4: // ID trạng thái DA_GIAO
                    statusText = "Đã giao hàng";
                    break;
                case 5: // ID trạng thái DA_GIAO
                    statusText = "Đã hủy";
                    break;
                default:
                    statusText = "Không xác định";
                    break;
            }

            // Cập nhật nội dung của cột Status
            statusCell.textContent = statusText;
        } else {
            console.log("Cột Status không tìm thấy.");
        }
    } else {
        console.log("Hàng đơn hàng không tìm thấy.");
    }
});
