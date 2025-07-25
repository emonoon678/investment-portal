<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST['location'];
    $area = $_POST['area'];
    $duration = $_POST['duration'];
    $status = $_POST['status'];
    $lastDate = $_POST['lastDate'];
    $link = $_POST['link'];
    $map = $_POST['map'];

    $stmt = $conn->prepare("INSERT INTO opportunities (name, type, location, area, duration, status, lastDate, link, map) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        die("فشل في التحضير: " . $conn->error);
    }

    $stmt->bind_param("sssssssss", $name, $type, $location, $area, $duration, $status, $lastDate, $link, $map);
    $stmt->execute();
    $stmt->close();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة فرصة</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; padding: 0; margin: 0; }
        main { max-width: 700px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 6px; }
        button { margin-top: 15px; padding: 10px 15px; background: #8b1c2e; color: white; border: none; border-radius: 6px; cursor: pointer; }
        a.back { display: inline-block; margin-top: 15px; color: #555; text-decoration: none; }
    </style>
</head>
<body>
    <main>
        <h2>➕ إضافة فرصة جديدة</h2>
        <form method="POST">
            <label>اسم الفرصة:</label>
            <input type="text" name="name" required>

            <label>نوع النشاط:</label>
            <select name="type" required>
                <option value="تجاري">تجاري</option>
                <option value="ترفيهي">ترفيهي</option>
                <option value="خدمي">خدمي</option>
            </select>

            <label>الموقع:</label>
            <input type="text" name="location" required>

            <label>المساحة:</label>
            <input type="text" name="area" required>

            <label>مدة العقد:</label>
            <input type="text" name="duration" required>

            <label>الحالة:</label>
            <select name="status" required>
                <option value="متاحة">متاحة</option>
                <option value="منتهية">منتهية</option>
            </select>

            <label>آخر موعد:</label>
            <input type="date" name="lastDate" required>

            <label>رابط التفاصيل:</label>
            <input type="text" name="link">

            <label>رابط الخريطة:</label>
            <input type="text" name="map">

            <button type="submit">إضافة</button>
        </form>
        <a href="dashboard.php" class="back">← عودة للوحة التحكم</a>
    </main>
</body>
</html>
