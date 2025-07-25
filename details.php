<?php
include("admin/includes/db.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("فرصة غير صالحة.");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM opportunities WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("الفرصة غير موجودة.");
}

$opportunity = $result->fetch_assoc();

// ✅ تحديد فئة الحالة
$status = $opportunity['status'];
$statusClass = ($status === 'متاحة') ? 'status-available' : 'status-expired';

function calculateRemainingTime($endDate) {
    $now = new DateTime();
    $end = new DateTime($endDate);
    if ($end < $now) return false;
    $diff = $now->diff($end);
    return "{$diff->days} يوم / {$diff->h} ساعة / {$diff->i} دقيقة";
}
$remaining = calculateRemainingTime($opportunity['lastDate']);
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($opportunity['name']) ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<header class="top-header">
    <div class="header-logos">
        <img src="images/logo-left.png" alt="شعار الوزارة">
        <h1>تفاصيل الفرصة الاستثمارية</h1>
        <img src="images/logo-right.png" alt="شعار الأمانة">
    </div>
</header>

<main class="opportunity-card details-container">

    <p class="status-label <?= $statusClass ?>">📄 الحالة: <?= htmlspecialchars($status) ?></p>

    <h2><?= htmlspecialchars($opportunity['name']) ?></h2>

    <p>🏷️ <strong>القطاع:</strong> <?= htmlspecialchars($opportunity['type']) ?></p>
    <p>📍 <strong>الموقع:</strong> <?= htmlspecialchars($opportunity['location']) ?></p>
    <p>📐 <strong>المساحة:</strong> <?= htmlspecialchars($opportunity['area']) ?> م²</p>
    <p>⏱ <strong>مدة العقد:</strong> <?= htmlspecialchars($opportunity['duration']) ?> سنوات</p>
    <p>📅 <strong>آخر موعد:</strong> <?= htmlspecialchars($opportunity['lastDate']) ?></p>

    <?php if ($remaining): ?>
        <div class="countdown">⏳ متبقي: <?= $remaining ?></div>
    <?php else: ?>
        <div class="expired">⛔ انتهى التقديم</div>
    <?php endif; ?>

    <div class="details-buttons">
        <a class="btn btn-map" href="<?= htmlspecialchars($opportunity['map']) ?>" target="_blank">📍 عرض الخريطة</a>
        <a class="btn btn-details" href="index.php">↩️ منصة فرص</a>
    </div>
</main>

<footer class="footer">
  <p>تم التطوير بواسطة <a href="https://mazeej.com.sa/" target="_blank">مزيج</a> © 2025</p>
</footer>

</body>
</html>
