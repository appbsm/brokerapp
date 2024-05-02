<?php
include('includes/config_path.php');

    // $folderPath = "E:/brokerapp_upload/nn-advisory";
    $folderPath = $sourceFilePath;
	
	// ขนาดสูงสุดของโฟลเดอร์ (ในเลขไบต์)
    $maxSizeBytes = 50 * 1024 * 1024 * 1024; // 50 GB
	//$maxSizeBytes = 200 * 1024 * 1024; // 200 MB
	
	// ขนาดของโฟลเดอร์ที่ต้องการแจ้งเตือน (ในเลขไบต์)
    $alertSizeBytes = 40 * 1024 * 1024 * 1024; // 40 GB
    //$alertSizeBytes = 190 * 1024 * 1024; // 190 MB
	
	// ตรวจสอบขนาดของโฟลเดอร์
    $currentSizeBytes = 0;
    $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
    foreach ($objects as $name => $object) {
        $currentSizeBytes += $object->getSize();
    }
	
	// ตรวจสอบว่าใกล้จะถึงขนาดสูงสุดหรือไม่
    $response = array();
    if ($currentSizeBytes >= $alertSizeBytes && $currentSizeBytes < $maxSizeBytes) {
        $remainingSizeGB = round(($maxSizeBytes - $currentSizeBytes) / (1024 * 1024 * 1024), 2);
		//$remainingSizeMB = round(($maxSizeBytes - $currentSizeBytes) / (1024 * 1024), 2); // เปลี่ยนเป็น MB
        $response['alert'] = true;
        $response['folderPath'] = $folderPath;
        $response['remainingSizeGB'] = $remainingSizeGB;
    } else {
        $response['alert'] = false;
    }
    echo json_encode($response);
?>
