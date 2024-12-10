<?php
function fetchMovies($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Để tải dữ liệu theo chuyển hướng nếu có
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true); // Giải mã JSON
}
?>

<?php
// Hàm để lấy thông tin chi tiết phim
function fetchMovieDetails($apiUrl) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL Error: " . curl_error($ch));
    }
    curl_close($ch);

    return json_decode($response, true);
}
?>
