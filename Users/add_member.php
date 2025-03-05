<?php
session_start(); // بدء الجلسة
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // استقبال البيانات من النموذج
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = 'password'; // كلمة المرور الافتراضية
    $role=mysqli_real_escape_string($connection, $_POST['role']);
    // استعلام لإضافة المستخدم إلى قاعدة البيانات
    $query = "INSERT INTO users (name, email, password,role) VALUES ('$name', '$email', '$password','$role')";

    if (mysqli_query($connection, $query)) {
        // تعيين رسالة النجاح في الجلسة
        $_SESSION['success_message'] = "تم إضافة المستخدم بنجاح.";
    } else {
        // تعيين رسالة الخطأ في الجلسة
        $_SESSION['error_message'] = "فشل في إضافة المستخدم: " . mysqli_error($connection);
    }

    // إعادة توجيه المستخدم إلى نفس الصفحة
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit(); // تأكد من إنهاء السكربت بعد إعادة التوجيه
}
?>