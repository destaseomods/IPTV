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
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if (curl_errno($ch) || $httpCode !== 200) {
    die("Error: Gagal mengambil data dari API. HTTP Code: $httpCode");
}

// Asumsi API mengembalikan JSON
$data = json_decode($response, true);

if (!$data || empty($data['playlists']) && empty($data['channels'])) {
    // Coba tampilkan response asli untuk debug
    echo "<pre>";
    echo "HTTP Code: $httpCode\n\n";
    echo htmlspecialchars($response);
    echo "</pre>";
    die("Data playlist tidak ditemukan.");
}

// Mulai buat konten M3U
$m3u = "#EXTM3U\n";

// Sesuaikan struktur JSON sesuai hasil API kamu
// Biasanya ada array 'playlists' atau 'channels'
$playlists = $data['playlists'] ?? $data['channels'] ?? $data;

foreach ($playlists as $item) {
    $title = $item['name'] ?? $item['title'] ?? 'Unknown Channel';
    $url_stream = $item['url'] ?? $item['stream_url'] ?? $item['link'] ?? '';
    $logo = $item['logo'] ?? $item['image'] ?? '';
    $group = $item['group'] ?? $item['category'] ?? 'General';

    if (empty($url_stream)) continue;

    $m3u .= "#EXTINF:-1 group-title=\"{$group}\" tvg-logo=\"{$logo}\",{$title}\n";
    $m3u .= $url_stream . "\n";
}

// Simpan ke file M3U
$filename = "playlist_" . date("Ymd_His") . ".m3u";
file_put_contents($filename, $m3u);

echo "✅ Playlist berhasil dibuat!<br>";
echo "📁 File: <strong>$filename</strong><br><br>";
echo "<a href='$filename' download>⬇️ Download Playlist M3U</a><br><br>";

// Tampilkan preview
echo "<pre>" . htmlspecialchars(substr($m3u, 0, 1500)) . "...</pre>";
?>
