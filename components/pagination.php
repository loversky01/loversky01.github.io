<section class="pagination">
    <!-- Hiển thị nút "Trước" nếu không phải trang đầu tiên -->
    <?php if ($page > 1): ?>
        <a href='index.php?page=<?= $page - 1 ?>' class='pagination-link prev'>
            <span class='material-icons'>chevron_left</span>
        </a>
    <?php else: ?>
        <span class='pagination-link prev disabled'><span class='material-icons'>chevron_left</span></span>
    <?php endif; ?>

    <!-- Hiển thị các trang giữa các trang -->
    <?php 
    $range = 2; // Hiển thị 2 trang trước và sau trang hiện tại
    for ($i = max(1, $page - $range); $i <= min($totalPages, $page + $range); $i++): ?>
        <a href='index.php?page=<?= $i ?>' class='pagination-link <?= $i == $page ? 'active' : '' ?>'>
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <!-- Hiển thị nút "Sau" nếu không phải trang cuối -->
    <?php if ($page < $totalPages): ?>
        <a href='index.php?page=<?= $page + 1 ?>' class='pagination-link next'>
            <span class='material-icons'>chevron_right</span>
        </a>
    <?php else: ?>
        <span class='pagination-link next disabled'><span class='material-icons'>chevron_right</span></span>
    <?php endif; ?>
</section>
