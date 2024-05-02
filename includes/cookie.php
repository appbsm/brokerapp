<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cookie Consent</title>
<link rel="stylesheet" href="styles.css">
<style>
    .cookie-container {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    .cookie-btn {
        padding: 10px 20px;
        margin: 10px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        background-color: #4CAF50;
        color: #fff;
        transition: background-color 0.3s ease;
    }

    .cookie-btn:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .cookie-container {
            flex-direction: column;
            align-items: center;
        }

        .cookie-container p {
            margin-bottom: 10px;
        }

        .cookie-btn {
            margin-top: 10px;
        }
    }
</style>
</head>
<body>
    <div class="container">
        <div class="container-body">
            <div class="row">
                <div class="cookie-container" id="cookieContainer">
                    <p>This website uses cookies to ensure you get the best experience on our website. <a href="/includes/privacy-policy.php" style="color: #fff;" target="_blank">Learn More</a></p>
                    <button class="cookie-btn" id="accept">Accept</button>
                    <button class="cookie-btn" id="deny">Deny</button>
                </div>
            </div>
        </div>
    </div>

<script>
// ตรวจสอบสถานะคุกกี้เมื่อโหลดหน้าเว็บเพจ
window.onload = function() {
    var cookieConsent = getCookie('cookieConsent');
    if (cookieConsent === 'accepted') {
        // ถ้ามีการยอมรับคุกกี้แล้ว ให้ซ่อนคอนเทนเนอร์ของคุกกี้
        document.getElementById('cookieContainer').style.display = 'none';
    }
};

document.getElementById('accept').addEventListener('click', function() {
    // บันทึกสถานะการยอมรับลงในคุกกี้หรือ Local Storage
    setCookie('cookieConsent', 'accepted', 365); // บันทึกคุกกี้ที่มีชื่อว่า 'cookieConsent' และค่าเป็น 'accepted' เป็นเวลา 1 ปี (365 วัน)

    // ซ่อนคอนเทนเนอร์ของคุกกี้
    document.getElementById('cookieContainer').style.display = 'none';
});

document.getElementById('deny').addEventListener('click', function() {
    // ปิดคอนเทนเนอร์ของคุกกี้
    document.getElementById('cookieContainer').style.display = 'none';

    // แสดงคอนเทนเนอร์ของคุกกี้ทุกๆ 1 วินาที
    var interval = setInterval(function() {
        // แสดงคอนเทนเนอร์ของคุกกี้
        document.getElementById('cookieContainer').style.display = 'block';
    //}, 1000); // 1 วินาที
	}, 5 * 60 * 1000); // 5 นาที

    // เมื่อคลิกปุ่ม "Accept" หรือ "Deny" ใหม่ ให้หยุดการแสดงคอนเทนเนอร์ของคุกกี้ทันที
    document.getElementById('accept').addEventListener('click', function() {
        clearInterval(interval);
    });

    document.getElementById('deny').addEventListener('click', function() {
        clearInterval(interval);
    });
});

function setCookie(name, value, days) {
    var expires = '';
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + (value || '')  + expires + '; path=/';
}

function getCookie(name) {
    var nameEQ = name + '=';
    var cookies = document.cookie.split(';');
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) === ' ') {
            cookie = cookie.substring(1, cookie.length);
        }
        if (cookie.indexOf(nameEQ) === 0) {
            return cookie.substring(nameEQ.length, cookie.length);
        }
    }
    return null;
}
</script>
</body>
</html>
