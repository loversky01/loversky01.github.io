// Hàm để phát video khi người dùng nhấn vào liên kết
function playVideo(videoUrl) {
    const videoFrame = document.getElementById('video-frame');
    
    if (videoUrl) {
        // Gán URL video vào iframe src
        videoFrame.src = videoUrl;
        console.log("Video URL:", videoUrl);  // Kiểm tra xem video URL có đúng không
    }
}
