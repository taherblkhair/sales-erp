<?php
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

// تحقق من وجود معرف الوظيفة
if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']);
    
    // استعلام للحصول على الحالة الحالية
    $query = "SELECT status FROM `jops` WHERE id = $jobId";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['status'];

        // تحديد الحالة الجديدة
        $newStatus = ($currentStatus === 'open') ? 'closed' : 'open';

        // تحديث الحالة في قاعدة البيانات
        $updateQuery = "UPDATE `jops` SET status = '$newStatus' WHERE id = $jobId";
        if (mysqli_query($connection, $updateQuery)) {
            header("Location: index.php?status_change=success"); // إعادة التوجيه إلى الصفحة الرئيسية بعد النجاح
        } else {
            die("فشل في تحديث الحالة: " . mysqli_error($connection));
        }
    } else {
        die("لم يتم العثور على الوظيفة.");
    }
} else {
    die("معرف الوظيفة مفقود.");
}
?>