<?php
    // ตำแหน่งของโฟลเดอร์ที่ต้องการตรวจสอบ
    $folderPath = "E:/brokerapp_upload/nn-advisory";

    // ขนาดสูงสุดของโฟลเดอร์ (ในเลขไบต์)
	//$maxSizeBytes = 50 * 1024 * 1024 * 1024; // 50 GB
	$maxSizeBytes = 200 * 1024 * 1024; // 200 MB

    // ขนาดของโฟลเดอร์ที่ต้องการแจ้งเตือน (ในเลขไบต์)
	//$alertSizeBytes = 40 * 1024 * 1024 * 1024; // 40 GB
    $alertSizeBytes = 190 * 1024 * 1024; // 190 MB
	

    // ตรวจสอบขนาดของโฟลเดอร์
    $currentSizeBytes = 0;
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
    foreach ($objects as $name => $object) {
        $currentSizeBytes += $object->getSize();
    }

    // ตรวจสอบว่าใกล้จะถึงขนาดสูงสุดหรือไม่
    if ($currentSizeBytes >= $alertSizeBytes && $currentSizeBytes < $maxSizeBytes) {
        // เตรียมข้อความแจ้งเตือน
        //$remainingSizeGB = round(($maxSizeBytes - $currentSizeBytes) / (1024 * 1024 * 1024), 2);
		$remainingSizeMB = round(($maxSizeBytes - $currentSizeBytes) / (1024 * 1024), 2); // เปลี่ยนเป็น MB
        $subject = "Alert: Low disk space!";
		//$message = "Low disk space warning for the folder. Remaining space: $remainingSpaceGB GB.";
		$message = "Low disk space warning for the folder. Remaining space: $remainingSizeMB MB.";

        // แสดง Alert โดยใช้ JavaScript
        echo "<script>alert('$message');</script>";
    }
?>
