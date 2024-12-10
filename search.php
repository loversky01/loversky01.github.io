<?php
session_start();

// Kiểm tra lịch sử tìm kiếm (lưu lịch sử vào session)
$search_history = isset($_SESSION['search_history']) ? $_SESSION['search_history'] : [];

// Xử lý tìm kiếm
$search_results = [];
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // URL API 1
    $url1 = "https://phim.nguonc.com/api/films/search?keyword=" . urlencode($keyword);
    // URL API 2
    // $url2 = "https://phimapi.com/v1/api/tim-kiem?keyword=" . urlencode($keyword);

    // Gọi API 1
    $response1 = file_get_contents($url1);
    if ($response1 !== false) {
        $response1 = json_decode($response1, true);
        $results1 = isset($response1['items']) ? $response1['items'] : [];
    } else {
        $results1 = [];
    }

    // // Gọi API 2
    // $response2 = file_get_contents($url2);
    // if ($response2 !== false) {
    //     $response2 = json_decode($response2, true);
    //     $results2 = isset($response2['data']) ? $response2['data'] : [];
    // } else {
    //     $results2 = [];
    // }

    // Hợp nhất kết quả
    $search_results = array_merge($results1);

    // Lưu lịch sử tìm kiếm vào session
    $search_history[] = [
        'keyword' => $keyword,
        'results' => $search_results
    ];
    $_SESSION['search_history'] = $search_history;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Tìm Kiếm Phim</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/mainvideo.css">
    <link rel="stylesheet" href="./css/search.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
    font-family: 'Roboto', sans-serif;
    background-color: #121212;
    color: #e0e0e0;
    line-height: 1.6;
}

    </style>
</head>
<body>
<main>
<?php include './components/header.php'; ?>  <!-- Header -->

    <section class="search-movies">
        <h1>Tìm Kiếm Phim</h1>
        <form action="" method="get">
            <input type="text" name="keyword" placeholder="Nhập từ khóa tìm kiếm..." value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            <button type="submit">Tìm kiếm</button>
        </form>
    </section>

    <section class="search-results">
        <h2>Kết quả Tìm Kiếm</h2>
        <?php if (!empty($search_results)): ?>
            <section class="movies-grid">
                <?php foreach ($search_results as $movie): ?>
                    <div class="movie-card">
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($movie['name'] ?? $movie['title'] ?? 'Tên không xác định') ?></h3>
                        </div>
                        <a href="<?= isset($movie['slug']) ? 'movie-details.php?slug=' . urlencode($movie['slug']) : '#' ?>">
                            <img src="<?= htmlspecialchars($movie['thumb_url'] ?? $movie['image'] ?? '') ?>" alt="<?= htmlspecialchars($movie['name'] ?? $movie['title'] ?? 'Không có hình ảnh') ?>" class="movie-img">
                        </a>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php elseif (isset($_GET['keyword'])): ?>
            <p>Không tìm thấy kết quả nào cho từ khóa: <?= htmlspecialchars($_GET['keyword']) ?></p>
        <?php endif; ?>
    </section>

    
</body>
</html>
