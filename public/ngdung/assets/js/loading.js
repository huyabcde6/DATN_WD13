document.addEventListener("DOMContentLoaded", () => {
    const loader = document.querySelector(".loader");

    // Hiển thị loader khi tải lại trang
    loader.style.display = "block";

    // Ẩn loader khi trang tải xong
    window.addEventListener("load", () => {
        loader.style.display = "none";
    });

    // Hiển thị loader khi gửi form
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", () => {
            loader.style.display = "block";
        });
    });

    // Hiển thị loader khi nhấp vào bất kỳ liên kết nào
    document.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", (event) => {
            event.preventDefault(); // Ngừng hành động mặc định của liên kết (chuyển trang)

            loader.style.display = "block"; // Hiển thị loader

            // Giả lập thời gian để loader hoạt động, sau đó điều hướng đến liên kết
            setTimeout(() => {
                window.location.href = link.href; // Điều hướng đến địa chỉ liên kết
            }, 0); // Thời gian 1 giây, bạn có thể thay đổi theo nhu cầu
        });
    });
});
