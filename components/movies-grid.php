<section class="movies-grid">
    <?php
        // Hiển thị phim
        if (count($pagedMovies) > 0) {
            foreach ($pagedMovies as $movie): ?>
                <div class="movie-card">
                    <!-- Tiêu đề phim -->
                    <div class="movie-info">
                        <h3><?= htmlspecialchars($movie['name']) ?></h3>
                    </div>
                    <!-- Ảnh trong card chiếm toàn bộ diện tích của card -->
                    <a href="movie-details.php?slug=<?= urlencode($movie['slug']) ?>">
                        <img src="<?= htmlspecialchars($movie['thumb_url']) ?>" alt="<?= htmlspecialchars($movie['name']) ?>" class="movie-img">
                    </a>
                </div>
            <?php endforeach;
        } else {
            echo "Không có phim nào để hiển thị.";
        }
    ?>
</section>
