<?php
include('dbconnect.php'); // تأكد من أن لديك اتصال بقاعدة البيانات

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $interview_id = $_POST['interview_id'];
    $employee_id = $_POST['employee_id'];
    $job_id = $_POST['job_id']; // تم تصحيح هذا السطر
    $interview_date = $_POST['interview_date'];
    $interview_time = $_POST['interview_time'];

    // استعلام لتحديث بيانات المقابلة
    $query = "UPDATE interviews SET employee_id = $employee_id, job_id = $job_id, interview_date = '$interview_date', interview_time = '$interview_time' WHERE id = $interview_id";

    if (mysqli_query($connection, $query)) {
        header("Location: index.php?message=تم تحديث المقابلة بنجاح");
        exit();
    } else {
        die("فشل في تحديث المقابلة: " . mysqli_error($connection));
    }
} else {
    die("طلب غير صالح.");
}