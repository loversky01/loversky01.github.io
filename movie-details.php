<?php
// Kiểm tra nếu có `slug` trong URL
session_start(); // Bắt buộc phải gọi session_start để sử dụng session
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $url = "https://phim.nguonc.com/api/film/$slug";

    include './api/api.php'; // Gọi api.php để fetch dữ liệu phim

    $movieDetails = fetchMovieDetails($url);

    if ($movieDetails['status'] === 'success') {
        $movie = $movieDetails['movie'];
        
        // Lưu bộ phim vào lịch sử đã xem
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = []; // Khởi tạo nếu chưa có
        }

        // Kiểm tra nếu bộ phim chưa có trong lịch sử thì thêm vào
        if (!in_array($movie['slug'], array_column($_SESSION['history'], 'slug'))) {
            $_SESSION['history'][] = $movie; // Lưu thông tin bộ phim vào session
        }

    } else {
        die("Không tìm thấy thông tin chi tiết của bộ phim.");
    }
} else {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Phim: <?= isset($movie['name']) ? htmlspecialchars($movie['name']) : 'Tên Phim' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/mainvideo.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .video-container {
            max-width: 100%;
            width: 100%;
            height: 500px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        .episode-list {
            margin-top: 30px;
        }
        .episode-item {
            display: block;
            margin: 10px 0;
            font-size: 18px;
            color: #333;
            text-decoration: none;
        }
        .episode-item:hover {
            color: #007bff;
        }
        .movie-info {
            margin-top: 20px;
        }
        body {
            background-color: #000000; /* Nền đen cho toàn bộ trang */
            color: #ffffff; /* Màu chữ trắng */
        }
        .movie-info h3, .episodes h3 {
            color: #ffffff; /* Màu chữ trắng cho tiêu đề */
        }
        .episode-item {
            color: #ffffff; /* Màu chữ trắng cho các tập phim */
        }
        .episode-item:hover {
            color: #007bff; /* Màu chữ khi hover */
        }

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

.movies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Chế độ grid tự động căn chỉnh */
    gap: 20px; /* Khoảng cách giữa các bộ phim */
    justify-items: center; /* Canh giữa các item trong grid */
}

.movie-card {
    background-color: #333333; /* Nền màu xám tối cho mỗi thẻ phim */
    padding: 15px;
    border-radius: 10px;
    width: 100%;
    transition: transform 0.3s ease-in-out; /* Thêm hiệu ứng khi hover */
}

.movie-card:hover {
    transform: scale(1.05); /* Tăng kích thước nhẹ khi hover */
}

.movie-info h3 {
    color: #ffffff;
    font-size: 18px;
    margin-top: 10px;
    text-align: center;
}

.movie-img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover;
}

.movie-card a {
    text-decoration: none; /* Bỏ underline khi di chuột */
}

.movie-card a:hover .movie-info h3 {
    color: #007bff; /* Màu chữ khi hover vào liên kết */
}

.movie-card img {
    width: 100%;
    height: 300px; /* Đảm bảo hình ảnh có chiều cao nhất định */
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

    </style>
</head>
<body>

<main>
<?php include './components/header.php'; ?>  <!-- Header -->

    <section class="movie-detail">
      

        <h1><?= isset($movie['name']) ? htmlspecialchars($movie['name']) : 'Tên Phim' ?></h1>

        <!-- Phần video -->
        <div class="video-container" id="video-container">
            <?php
            // Lấy thông tin tập đầu tiên để nhúng video mặc định
            $default_episode = $movie['episodes'][0]['items'][0]; // Tập đầu tiên
            $default_embed_url = isset($default_episode['embed']) ? $default_episode['embed'] : '#';
            ?>
            <iframe src="<?= htmlspecialchars($default_embed_url) ?>" allowfullscreen id="video-player"></iframe>
        </div>

        <!-- Phần các tập phim -->
        <?php if (isset($movie['episodes']) && !empty($movie['episodes'])): ?>

        <div class="episodes">
            <h3>Danh Sách Tập Phim:</h3>
            <div class="episode-list">
                <?php foreach ($movie['episodes'] as $episodeGroup): ?>
                    <div class="episode-group">
                        <div class="server-name"><?= isset($episodeGroup['server_name']) ? htmlspecialchars($episodeGroup['server_name']) : 'Server 1' ?></div>
                        <?php foreach ($episodeGroup['items'] as $episode): ?>
                            <a href="javascript:void(0)" class="episode-item" data-embed-url="<?= isset($episode['embed']) ? htmlspecialchars($episode['embed']) : '#' ?>" data-episode-name="<?= isset($episode['name']) ? htmlspecialchars($episode['name']) : 'Tập phim' ?>">
                                <p><?= isset($episode['name']) ? htmlspecialchars($episode['name']) : 'Tập phim' ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php else: ?>
        <p>Không có thông tin về các tập phim.</p>
        <?php endif; ?>

        <!-- Thông tin bộ phim -->
        <div class="movie-info">
            <h3>Thông Tin Bộ Phim:</h3>
            <p class="description"><?= isset($movie['description']) ? htmlspecialchars($movie['description']) : 'Mô tả không có sẵn.' ?></p>
            <div class="movie-meta">
                <p><strong>Thời gian:</strong> <?= isset($movie['time']) ? htmlspecialchars($movie['time']) : 'N/A' ?></p>
                <p><strong>Chất lượng:</strong> <?= isset($movie['quality']) ? htmlspecialchars($movie['quality']) : 'N/A' ?></p>
                <p><strong>Ngôn ngữ:</strong> <?= isset($movie['language']) ? htmlspecialchars($movie['language']) : 'N/A' ?></p>
                <p><strong>Đạo diễn:</strong> <?= isset($movie['director']) ? htmlspecialchars($movie['director']) : 'N/A' ?></p>
                <p><strong>Diễn viên:</strong> <?= isset($movie['casts']) ? htmlspecialchars($movie['casts']) : 'N/A' ?></p>
            </div>
        </div>

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

    </section>
</main>

<script>
// Lưu trữ thông tin các tập phim
const episodes = <?php echo json_encode($movie['episodes']); ?>;

// Cập nhật video khi thay đổi tập
function updateVideo(embedUrl) {
    const videoPlayer = document.getElementById('video-player');
    videoPlayer.src = embedUrl; // Cập nhật nguồn video mới
    videoPlayer.play(); // Đảm bảo video sẽ phát ngay khi thay đổi
}

// Cập nhật video khi người dùng nhấn vào một tập
document.querySelectorAll('.episode-item').forEach(item => {
    item.addEventListener('click', function() {
        const embedUrl = item.getAttribute('data-embed-url');
        updateVideo(embedUrl); // Cập nhật video khi người dùng nhấn vào tập
    });
});

// Đảm bảo video đầu tiên sẽ phát ngay khi trang tải
window.onload = function() {
    const defaultEmbedUrl = "<?= htmlspecialchars($default_embed_url) ?>";
    updateVideo(defaultEmbedUrl);
};
</script>

</body>
</html>
