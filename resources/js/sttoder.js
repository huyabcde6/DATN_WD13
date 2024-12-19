import "./bootstrap.js";
Pusher.logToConsole = true;

var pusher = new Pusher("957ee470fe95bd43edc6", {
    cluster: "ap1",
});

var channel = pusher.subscribe("order");
channel.bind("OderEvent", function (data) {
    // Tìm thẻ <h5> hiển thị trạng thái của đơn hàng dựa vào ID
    const statusHeader = document.querySelector(`#order-status-${data.id}`);
    const cancelButton = document.querySelector(`#cancel-order-${data.id}`); // Nút hủy đơn hàng
    const confirmForm = document.querySelector(`#confirm-order-${data.id}`);
    // Form xác nhận đơn hàng

    if (statusHeader) {
        // Ánh xạ ID trạng thái thành tên trạng thái
        let statusText = "";

        switch (data.status) {
            case 1: // ID trạng thái CHO_XAC_NHAN
                statusText = "Chờ xác nhận";
                break;
            case 2: // ID trạng thái DA_XAC_NHAN
                statusText = "Đã xác nhận";
                if (cancelButton) cancelButton.style.display = "none";
                break;
            case 3: // ID trạng thái DANG_VAN_CHUYEN
                statusText = "Đang vận chuyển";
                break;
            case 4: // ID trạng thái DA_GIAO
                statusText = "Đã giao hàng";
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                if (confirmForm) {
                    confirmForm.innerHTML = `
                        <form id="confirm-order-${data.id}" action="{{ route('orders.update', ${data.id}) }}" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="hoan_thanh" value="5">
                            <button type="submit" class="btn btn-success mx-3" style="font-size: 12px; margin-top: 19px;">
                                Xác nhận nhận hàng
                            </button>
                        </form>`;
                } else {
                    console.log("Không tìm thấy form");
                }
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
        statusHeader.innerHTML = `<strong>Trạng thái đơn hàng:</strong> <mark>${statusText}</mark> `;
    } else {
        console.log("Không tìm thấy thẻ <h5> trạng thái của đơn hàng.");
    }
});
