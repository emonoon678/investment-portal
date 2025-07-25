<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include("includes/db.php");
$result = $conn->query("SELECT * FROM opportunities ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <style>
        body { font-family: Arial; background: #f7f7f7; margin: 0; padding: 0; }
        header { background: #8b1c2e; color: white; padding: 1rem; text-align: center; }
        main { max-width: 1000px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 14px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 0.8rem; text-align: center; }
        a.btn { padding: 6px 10px; border-radius: 4px; text-decoration: none; color: white; }
        .edit { background: #0d8b47; }
        .delete { background: #b30000; }
        .add-btn { background: #00695c; color: white; padding: 10px; display: inline-block; border-radius: 6px; margin-bottom: 10px; }
        .logout { float: left; color: white; text-decoration: none; background: #555; padding: 6px 12px; border-radius: 4px; }
    </style>
</head>
<body>
    <header>
        <h2>لوحة التحكم - إدارة الفرص</h2>
        <a href="logout.php" class="logout">تسجيل الخروج</a>
    </header>
    <main>
        <a class="add-btn" href="add.php">➕ إضافة فرصة جديدة</a>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الفرصة</th>
                    <th>النوع</th>
                    <th>الموقع</th>
                    <th>المساحة</th>
                    <th>مدة العقد</th>
                    <th>الحالة</th>
                    <th>آخر موعد</th>
                    <th>خريطة</th>
                    <th>الرابط</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['type']) ?></td>
                    <td><?= htmlspecialchars($row['location']) ?></td>
                    <td><?= htmlspecialchars($row['area']) ?></td>
                    <td><?= htmlspecialchars($row['duration']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td><?= htmlspecialchars($row['lastDate']) ?></td>
                    <td><a href="<?= htmlspecialchars($row['map']) ?>" target="_blank">📍</a></td>
                    <td>
                        <?php if ($row['link']): ?>
                            <a href="<?= htmlspecialchars($row['link']) ?>" target="_blank">رابط</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a class="btn edit" href="edit.php?id=<?= $row['id'] ?>">تعديل</a>
                        <a class="btn delete" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('هل أنت متأكد من الحذف؟');">حذف</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
