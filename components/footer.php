<footer>
    <p>&copy; 2024 Phim Mới Cập Nhật - Tất cả quyền sở hữu.</p>
</footer>
<script src="script.js"></script>
</body>
</html>

<script>
// API URL lấy danh sách phim (thay bằng URL thực tế của bạn)
let currentPage = 1; // Biến theo dõi trang hiện tại
const apiUrl = 'https://phim.nguonc.com/api/films/phim-moi-cap-nhat?page=' + currentPage;

// Hàm lấy poster_url từ API
async function fetchPosters(page) {
    try {
        const response = await fetch(`https://phim.nguonc.com/api/films/phim-moi-cap-nhat?page=${page}`);
        const data = await response.json();

        // Kiểm tra dữ liệu trả về và lấy poster_url
        if (data.status === 'success' && data.items.length > 0) {
            const posterUrls = data.items.map(movie => movie.poster_url); // Lấy poster_url từ dữ liệu phim

            // Bắt đầu thay đổi ảnh nền mỗi 10 giây
            setInterval(() => changeBackground(posterUrls), 10000);

            // Thay đổi ảnh nền ngay khi trang được tải
            changeBackground(posterUrls);
        } else {
            console.error('Không có dữ liệu poster từ API.');
        }
    } catch (error) {
        console.error('Lỗi khi gọi API:', error);
    }
}

// Hàm để thay đổi ảnh nền của banner
function changeBackground(posterUrls) {
    const banner = document.getElementById('banner');
    const randomIndex = Math.floor(Math.random() * posterUrls.length);
    const newPosterUrl = posterUrls[randomIndex];

    // Thay đổi background-image của banner
    banner.style.backgroundImage = `url(${newPosterUrl})`;
}

// Hàm để thay đổi trang
function changePage(page) {
    currentPage = page;
    fetchPosters(currentPage); // Gọi lại hàm để tải dữ liệu của trang mới
}

// Gọi hàm để lấy poster_url và bắt đầu thay đổi ảnh nền
fetchPosters(currentPage);

// Sử dụng hàm changePage để thay đổi trang khi có sự kiện (Ví dụ: khi bấm vào phân trang)
document.getElementById("nextPage").addEventListener("click", function() {
    changePage(currentPage + 1);
});
document.getElementById("prevPage").addEventListener("click", function() {
    if (currentPage > 1) {
        changePage(currentPage - 1);
    }
});
</script>
