<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");

// التحقق من وجود المعرف
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM opportunities WHERE id = $id LIMIT 1");
if ($result->num_rows == 0) {
    echo "لم يتم العثور على الفرصة المطلوبة.";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $type     = $_POST['type'];
    $location = $_POST['location'];
    $area     = $_POST['area'];
    $duration = $_POST['duration'];
    $lastDate = $_POST['lastDate'];
    $status   = $_POST['status'];

    $stmt = $conn->prepare("UPDATE opportunities SET name=?, type=?, location=?, area=?, duration=?, lastDate=?, status=? WHERE id=?");
    $stmt->bind_param("sssssssi", $name, $type, $location, $area, $duration, $lastDate, $status, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>تعديل الفرصة</title>
  <style>
    body { font-family: Arial; background: #f7f7f7; padding: 2rem; }
    form { max-width: 700px; margin: auto; background: white; padding: 2rem; border-radius: 10px; }
    label { display: block; margin-top: 10px; font-weight: bold; }
    input, select { width: 100%; padding: 8px; margin-top: 5px; }
    button { margin-top: 20px; padding: 10px 20px; background: #0d8b47; color: white; border: none; border-radius: 6px; cursor: pointer; }
    a.back { display: inline-block; margin-top: 10px; text-decoration: none; color: #333; }
  </style>
</head>
<body>
  <form method="post">
    <h2>تعديل الفرصة</h2>

    <label>اسم الفرصة:</label>
    <input type="text" name="name" required value="<?= htmlspecialchars($row['name']) ?>">

    <label>النوع:</label>
    <select name="type" required>
      <option value="تجاري" <?= $row['type'] == 'تجاري' ? 'selected' : '' ?>>تجاري</option>
      <option value="ترفيهي" <?= $row['type'] == 'ترفيهي' ? 'selected' : '' ?>>ترفيهي</option>
      <option value="خدمي" <?= $row['type'] == 'خدمي' ? 'selected' : '' ?>>خدمي</option>
    </select>

    <label>الموقع:</label>
    <input type="text" name="location" required value="<?= htmlspecialchars($row['location']) ?>">

    <label>المساحة:</label>
    <input type="text" name="area" required value="<?= htmlspecialchars($row['area']) ?>">

    <label>مدة العقد:</label>
    <input type="text" name="duration" required value="<?= htmlspecialchars($row['duration']) ?>">

    <label>آخر موعد:</label>
    <input type="date" name="lastDate" required value="<?= htmlspecialchars($row['lastDate']) ?>">

    <label>الحالة:</label>
    <select name="status" required>
      <option value="متاحة" <?= $row['status'] == 'متاحة' ? 'selected' : '' ?>>متاحة</option>
      <option value="منتهية" <?= $row['status'] == 'منتهية' ? 'selected' : '' ?>>منتهية</option>
    </select>

    <button type="submit">✔️ حفظ التعديلات</button>
    <a class="back" href="dashboard.php">← رجوع</a>
  </form>
</body>
</html>
