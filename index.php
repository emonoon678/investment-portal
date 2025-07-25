<?php
include("admin/includes/db.php");

$where = [];

if (!empty($_GET['search'])) {
    $search = '%' . $conn->real_escape_string($_GET['search']) . '%';
    $where[] = "(name LIKE '$search' OR location LIKE '$search')";
}
if (!empty($_GET['type'])) {
    $type = $conn->real_escape_string($_GET['type']);
    $where[] = "type = '$type'";
}
if (!empty($_GET['location'])) {
    $location = $conn->real_escape_string($_GET['location']);
    $where[] = "location = '$location'";
}
if (!empty($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $where[] = "status = '$status'";
}

$sql = "SELECT * FROM opportunities";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC";

$result = $conn->query($sql);
$totalCount = $result->num_rows;

function calculateRemainingTime($endDate) {
    $now = new DateTime();
    $end = new DateTime($endDate);
    if ($end < $now) return false;
    $diff = $now->diff($end);
    return "{$diff->days} يوم / {$diff->h} ساعة / {$diff->i} دقيقة";
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>الفرص الاستثمارية – أمانة الأحساء</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<header class="top-header">
  <div class="header-logos">
    <img src="images/logo-alhasa.PNG" alt="شعار الأحساء" />
    <h1>الفرص الاستثمارية – أمانة الأحساء</h1>
    <img src="images/.png" alt="شعار الفرص" />
    <img src="images/momah.SVG" alt="شعار الوزارة" />
  </div>
</header>

<section class="welcome">
  <h2>مرحبًا بكم في بوابة الفرص الاستثمارية</h2>
  <p>
    توفر أمانة الأحساء مجموعة متنوعة من الفرص الاستثمارية المتميزة للمستثمرين من مختلف المجالات. تهدف هذه المبادرات إلى تعزيز التنمية المستدامة ودعم النمو الاقتصادي في المنطقة، مع توفير بيئة جاذبة للاستثمار وتعزيز الشراكة مع القطاع الخاص.
  </p>
    <a href="brochure.pdf" class="btn-download" download><i class="fas fa-download"></i> تحميل النشرة</a>
</section>

<div class="total-opportunities">
  <div class="circle">
    <?= $totalCount ?> <br>فرصة استثمارية
  </div>
</div>

<form method="GET" class="filters">
  <input type="text" name="search" placeholder="ابحث باسم الفرصة أو الموقع..." value="<?= $_GET['search'] ?? '' ?>" class="search-bar" />

  <select name="type" class="dropdown">
    <option value="">نوع النشاط</option>
    <option value="تجاري" <?= ($_GET['type'] ?? '') === 'تجاري' ? 'selected' : '' ?>>تجاري</option>
    <option value="ترفيهي" <?= ($_GET['type'] ?? '') === 'ترفيهي' ? 'selected' : '' ?>>ترفيهي</option>
    <option value="خدمي" <?= ($_GET['type'] ?? '') === 'خدمي' ? 'selected' : '' ?>>خدمي</option>
    <option value="صناعي" <?= ($_GET['type'] ?? '') === 'صناعي' ? 'selected' : '' ?>>صناعي</option>
  </select>

  <select name="location" class="dropdown">
    <option value="">الجهة</option>
    <option value="الهفوف" <?= ($_GET['location'] ?? '') === 'الهفوف' ? 'selected' : '' ?>>الهفوف</option>
    <option value="المبرز" <?= ($_GET['location'] ?? '') === 'المبرز' ? 'selected' : '' ?>>المبرز</option>
  </select>

  <select name="status" class="dropdown">
    <option value="">الحالة</option>
    <option value="متاحة" <?= ($_GET['status'] ?? '') === 'متاحة' ? 'selected' : '' ?>>متاحة</option>
    <option value="منتهية" <?= ($_GET['status'] ?? '') === 'منتهية' ? 'selected' : '' ?>>منتهية</option>
  </select>

  <button type="submit" class="filter-btn">تصفية</button>
</form>

<main class="opportunity-list" id="opportunityList">
<?php $i = 0; ?>
<?php while($row = $result->fetch_assoc()): ?>
  <?php
    $remaining = calculateRemainingTime($row['lastDate']);
    $is_even = $i % 2 === 0;

    preg_match('/@([0-9\.-]+),([0-9\.-]+)/', $row['map'], $coords);
    $lat = $coords[1] ?? '25.383';
    $lng = $coords[2] ?? '49.595';
    $embedUrl = "https://maps.google.com/maps?q={$lat},{$lng}&hl=ar&z=15&output=embed";
  ?>
  <div class="opportunity-card-row <?= $is_even ? 'normal' : 'reversed' ?>">
    <div class="opportunity-map">
      <iframe src="<?= $embedUrl ?>" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <div class="opportunity-info">
      <h3><?= htmlspecialchars($row['name']) ?></h3>
      <p><strong>الموقع:</strong> <?= htmlspecialchars($row['location']) ?></p>
      <p><strong>المساحة:</strong> <?= htmlspecialchars($row['area']) ?></p>
      <p><strong>نوع النشاط:</strong> <?= htmlspecialchars($row['type']) ?></p>
      <p><strong>مدة العقد:</strong> <?= htmlspecialchars($row['duration']) ?></p>
      <p><strong>الحالة:</strong> <?= htmlspecialchars($row['status']) ?></p>
      <p><strong>آخر موعد:</strong> <?= htmlspecialchars($row['lastDate']) ?></p>

      <div class="<?= $remaining ? 'countdown' : 'expired' ?>">
        <?= $remaining ? "⏳ متبقي: $remaining" : "⛔ انتهى التقديم" ?>
      </div>

      <div class="buttons">
        <a class="btn btn-details" href="details.php?id=<?= $row['id'] ?>">📄 عرض التفاصيل</a>
        <a class="btn btn-map" href="<?= htmlspecialchars($row['map']) ?>" target="_blank">📍 عرض الخريطة</a>
      </div>
    </div>
  </div>
  <?php $i++; ?>
<?php endwhile; ?>
</main>

<footer class="footer">
  <p>تم التطوير بواسطة <a href="https://mazeej.com.sa/" target="_blank">مزيج</a> © 2025</p>
</footer>

</body>
</html>
