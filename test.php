<?php
$videoUrl = "https://embed12.streamc.xyz/embed.php?hash=4250d894d2599dd423c03ce20b7d8541";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Video Không Quảng Cáo</title>
    <style>
        iframe {
            width: 100%;
            height: 500px;
            border: none;
        }
        /* Chặn quảng cáo trong iframe (ẩn popup) */
        iframe[src*="streamc.xyz"] {
            display: block;
        }
    </style>
</head>
<body>
    <iframe src="<?= $videoUrl ?>" allowfullscreen></iframe>
    <script>
        // Chặn quảng cáo bằng cách loại bỏ phần tử trong iframe
        const iframe = document.querySelector('iframe');
        iframe.onload = function() {
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;

            // Ẩn quảng cáo theo các class/id (tùy từng trang)
            const ads = iframeDoc.querySelectorAll('.ad, .ads, #ad-container, .popup');
            ads.forEach(ad => ad.remove());
        };
    </script>
</body>
</html>
