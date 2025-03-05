<?php
include 'dbconnect.php'; // تأكد من تضمين ملف الاتصال بقاعدة البيانات

if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']);
    $query = "DELETE FROM users WHERE id = $jobId";
    
    if (mysqli_query($connection, $query)) {
        // إذا تم الحذف بنجاح، ارجع إلى index.php
        header("Location: index.php"); // تأكد من استخدام Location
        exit(); // تأكد من إنهاء السكربت بعد إعادة التوجيه
    } else {
        // في حالة حدوث خطأ، يمكنك عرض رسالة أو إعادة توجيه إلى صفحة خطأ
        echo "خطأ في الحذف: " . mysqli_error($connection);
    }
}
?>