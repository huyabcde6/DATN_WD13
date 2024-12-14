Pusher.logToConsole = true;

var pusher = new Pusher("957ee470fe95bd43edc6", {
    cluster: "ap1",
});

var channel = pusher.subscribe("order");
channel.bind("OderEvent", function (data) {
    // Tìm thẻ <h5> hiển thị trạng thái của đơn hàng dựa vào ID
    const statusHeader = document.querySelector(`#order-status-${data.id}`);
    const cancelButton = document.querySelector(`#cancel-order-${data.id}`); // Nút hủy đơn hàng
    const confirmForm = document.querySelector(`#confirm-order-${data.id}`); // Form xác nhận đơn hàng
    console.log(data.id);
    if (statusHeader) {
        // Ánh xạ ID trạng thái thành tên trạng thái
        let statusText = "";

        switch (data.status) {
            case 1: // ID trạng thái CHO_XAC_NHAN
                statusText = "Chờ xác nhận";
                break;
            case 2: // ID trạng thái DA_XAC_NHAN
                statusText = "Đã xác nhận";
                // Ẩn nút hủy đơn hàng
                if (cancelButton) cancelButton.style.display = "none";
                break;
            case 3: // ID trạng thái DANG_VAN_CHUYEN
                statusText = "Đang vận chuyển";
                // Hiển thị form nút đã nhận hàng
                console.log(data.id);

                if (confirmForm) {
                    confirmForm.innerHTML = `
                        <form id="confirm-order-${data.id}" action="/orders/update/${data.id}" method="POST" style="display:inline;">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="da_giao_hang" value="3">
                            <button type="submit" class="btn btn-success mx-3" style="font-size: 12px; margin-top: 19px;"
                                onclick="return confirm('Bạn xác nhận đã nhận hàng?');">Đã nhận hàng</button>
                        </form>`;
                } else {
                    console.log("không tìm thấy from");
                }
                break;
            case 4: // ID trạng thái DA_GIAO
                statusText = "Đã giao hàng";

                break;
            case 5: // ID trạng thái HOAN_THANH
                statusText = "Hoàn thành";
                break;
            case 6: // ID trạng thái DA_HUY
                statusText = "Đã hủy";
                break;
            case 7: // ID trạng thái HOAN_HANG
                statusText = "Hoàn hàng";
                break;
            case 8: // ID trạng thái CHO_HOAN
                statusText = "Chờ hoàn";
                break;
            default:
                statusText = "Không xác định";
                break;
        }

        // Cập nhật nội dung của thẻ <h5>
        statusHeader.textContent = statusText;
    } else {
        console.log("Không tìm thấy thẻ <p> trạng thái của đơn hàng.");
    }
});
