<?php
session_start();

// Kiểm tra xem người dùng có lịch sử xem phim không
$history = isset($_SESSION['history']) ? $_SESSION['history'] : [];

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Xem Phim</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/mainvideo.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Thiết lập nền và kiểu chữ cho toàn bộ trang */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #1c1c1c; /* Nền tối */
    color: #f0f0f0; /* Màu chữ sáng */
}

/* Phần header */
h1 {
    font-size: 36px;
    text-align: center;
    margin: 40px 0;
    color: #f8d030; /* Màu vàng cho tiêu đề */
}

/* Lớp chứa các bộ phim */
.movie-history {
    padding: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Lớp để sắp xếp các thẻ phim theo lưới */
.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

/* Các thẻ bộ phim */
.movie-card {
    background-color: #2c2c2c; /* Nền thẻ tối */
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease;
}

/* Hiệu ứng hover cho thẻ phim */
.movie-card:hover {
    transform: scale(1.05);
}

/* Thông tin phim */
.movie-info {
    padding: 10px;
    text-align: center;
}

/* Tiêu đề phim */
.movie-info h3 {
    font-size: 18px;
    margin-bottom: 10px;
    color: #fff;
}

/* Hình ảnh phim */
.movie-img {
    width: 100%;
    height: auto;
    border-bottom: 2px solid #f8d030; /* Dấu hiệu giữa hình ảnh và thông tin */
    transition: opacity 0.3s ease;
}

/* Khi hover vào hình ảnh */
.movie-card:hover .movie-img {
    opacity: 0.8;
}

/* Thông báo nếu không có phim trong lịch sử */
p {
    text-align: center;
    font-size: 18px;
    color: #f0f0f0;
    margin-top: 20px;
}

/* Tối ưu cho màn hình nhỏ */
@media (max-width: 768px) {
    h1 {
        font-size: 28px;
    }

    .movies-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    }

    .movie-card {
        margin-bottom: 20px;
    }
}

</style>
<body>

<main>
<?php include './components/header.php'; ?>  <!-- Header -->
    <section class="movie-history">
        <h1>Lịch Sử Xem Phim</h1>

        <?php if (count($history) > 0): ?>
            <section class="movies-grid">
                <?php foreach ($history as $movie): ?>
                    <div class="movie-card">
                        <div class="movie-info">
                            <h3><?= htmlspecialchars($movie['name']) ?></h3>
                        </div>
                        <a href="movie-details.php?slug=<?= urlencode($movie['slug']) ?>">
                            <img src="<?= htmlspecialchars($movie['thumb_url']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>" class="movie-img">
                        </a>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php else: ?>
            <p>Chưa có bộ phim nào trong lịch sử xem.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>
