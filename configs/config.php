<?php
// Thực hiện gọi API
include './api/api.php';

session_start();

// Kiểm tra xem người dùng có lịch sử xem phim không
$history = isset($_SESSION['history']) ? $_SESSION['history'] : [];


// Lấy tham số page từ URL, mặc định là 1 nếu không có
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Đường dẫn API để lấy danh sách phim
$apiUrl = "https://phim.nguonc.com/api/films/phim-moi-cap-nhat";

// Lấy dữ liệu phim từ API
$moviesData = fetchMovies($apiUrl . "?page=" . $page);

// Kiểm tra dữ liệu trả về từ API
if (isset($moviesData['status']) && $moviesData['status'] === 'success' && !empty($moviesData['items'])) {
    // Lấy tổng số trang và số lượng phim mỗi trang từ dữ liệu trả về
    $totalPages = isset($moviesData['paginate']['total_page']) ? $moviesData['paginate']['total_page'] : 1;

    // Lấy danh sách phim cho trang hiện tại
    $pagedMovies = $moviesData['items'];

    // Kiểm tra mảng phim có dữ liệu không
    if (count($pagedMovies) === 0) {
        echo "Không có phim nào để hiển thị.";
        exit;
    }
} else {
    echo "Không thể lấy dữ liệu phim từ API hoặc API trả về lỗi.";
    exit;
}
?>

