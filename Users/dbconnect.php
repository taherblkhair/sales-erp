<?php 
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "mysqlhr");

// استخدم mysqli_connect بدلاً من mysql_connect
$connection = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// تحقق من الاتصال
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully";
}

// لا تنسَ إغلاق الاتصال بعد ال
?>