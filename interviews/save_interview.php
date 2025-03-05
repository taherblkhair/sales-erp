<?php
include('dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];
    $job_id = $_POST['job_id'];
    $interview_date = $_POST['interview_date'];
    $interview_time = $_POST['interview_time'];

   
    $query = "INSERT INTO interviews (employee_id, job_id, interview_date, interview_time) VALUES ('$employee_id', '$job_id', '$interview_date', '$interview_time')";
    
    if (mysqli_query($connection, $query)) {
        header("Location: index.php?status_change=success");
    } else {
        echo "فشل في إضافة المقابلة: " . mysqli_error($connection);
    }
}
?>