<?php

$url = "https://dashim.biz.id/api/android/api_get_playlists.php";

$headers = [
    "Device-ID: aedab7ac79134d3e",
    "Vip-Status: 1",
    "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3ODA0ODU5MjUsImRhdGEiOiJzYW50dl9hcHAifQ.vQwaOR6Fx9q0UGkMNsaSxVWdQ8Gz_f_lwsH7G_C9q1s",
    "X-Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJleHAiOjE3ODA0ODU5MjUsImRhdGEiOiJzYW50dl9hcHAifQ.vQwaOR6Fx9q0UGkMNsaSxVWdQ8Gz_f_lwsH7G_C9q1s",
    "Device-Fingerprint: 22111317PG|moonstone|POCO/moonstone_p_id/moonstone:14/UKQ1.231003.002/V816.0.21.0.UMPIDXM:user/release-keys",
    "App-Build: 26",
    "Device-Name: Xiaomi 22111317PG",
    "User-Agent: okhttp/4.12.0"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     // Jika SSL bermasalah
curl_setopt($ch, CURLOPT_ENCODING, "");                 // Support gzip

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
} else {
    echo "HTTP Code: " . $httpCode . "\n\n";
    echo $response;
}

curl_close($ch);
?>
