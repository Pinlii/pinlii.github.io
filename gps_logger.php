<?php

date_default_timezone_set('Asia/Taipei');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $latitude = $_POST['latitude'] ?? 'Unknown';
    $longitude = $_POST['longitude'] ?? 'Unknown';
    $device_info = $_POST['device_info'] ?? 'Unknown';  // 获取设备和浏览器信息
    $timestamp = date('Y-m-d H:i:s');
    
    $data = "時間: $timestamp, 緯度: $latitude, 經度: $longitude, \n瀏覽器/裝置資訊: $device_info\n\n";
    file_put_contents('location.txt', $data, FILE_APPEND);
    
    echo json_encode(['message' => '儲存成功']);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get User Location</title>
    <script>
        function sendLocation(position) {
            let data = new FormData();
            data.append('latitude', position.coords.latitude);
            data.append('longitude', position.coords.longitude);
            
            fetch('gps_logger.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.text())
            .then(result => console.log(result))
            .catch(error => console.error('Error:', error));
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendLocation);
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }
    </script>
</head>
<body onload="getLocation()">
    <h1>Getting Location...</h1>
</body>
</html>
