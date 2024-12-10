<?php
include './configs/config.php';  // Đọc file cấu hình
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ - Phim Mới Cập Nhật</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./css/main.css">
    <style>
          .history {
    margin-top: 40px;
    background-color: #222222; /* Nền màu tối để phù hợp với theme */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.history h3 {
    color: #ffffff; /* Màu chữ trắng cho tiêu đề */
    font-size: 24px;
    margin-bottom: 20px;
}
    </style>
</head>
<body>
    <?php include './components/header.php'; ?>  <!-- Header -->

    <main>
        <!-- <section class="banner" id="banner">
        </section> -->
          <!-- Lịch sử đã xem -->
          <div class="history">
            <h3>Lịch Sử Xem Phim:</h3>
            <div class="movies-grid">
                <?php if (isset($_SESSION['history']) && !empty($_SESSION['history'])): ?>
                    <?php foreach ($_SESSION['history'] as $historyMovie): ?>
                        <div class="movie-card">
                            <div class="movie-info">
                                <h3><?= htmlspecialchars($historyMovie['name']) ?></h3>
                            </div>
                            <a href="movie-details.php?slug=<?= urlencode($historyMovie['slug']) ?>">
                                <img src="<?= htmlspecialchars($historyMovie['thumb_url']) ?>" alt="<?= htmlspecialchars($historyMovie['name']) ?>" class="movie-img">
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có bộ phim nào trong lịch sử xem.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php include './components/movies-grid.php'; ?>  <!-- Movies Grid -->

        <?php include './components/pagination.php'; ?>  <!-- Pagination -->
    </main>

    <?php include './components/footer.php'; ?>  <!-- Footer -->
</html>
