<?php 
include('header.php'); 
include('dbconnect.php'); 
include('sidebar.php');
?>

<!-- Main Content -->
<main class="main-content">

    <div class="container">
        <div class="page-header">
            <h1>إدارة لجنة التوظيف</h1>
            <button class="add-member-btn" onclick="window.location='create.php'">
                <i class="fas fa-plus"></i>
                إضافة موظف جديدة
            </button>
        </div>
        <table class="committee-table">
            <thead>
                <tr>
                    <th>اسم الموظف</th>
                    <th>البريد الإكتروني</th>
                    <th>الدور</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // استعلام لجلب جميع الوظائف
                $query = "SELECT * FROM `users`"; // تأكد من أن اسم الجدول صحيح
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    die("فشل الاستعلام: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                     
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td>
                            <button onclick="window.location='edit_user.php?id=<?php echo $row['id']; ?>'">تعديل</button>
                              <button onclick="confirmDelete(<?php echo $row['id']; ?>)">حذف</button>
                              

                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</main>
<script>
function confirmDelete(jobId) {
    if (confirm('هل أنت متأكد من حذف هذه الوظيفة؟')) {
        // إذا أكد المستخدم، قم بإرسال طلب الحذف إلى الخادم
        window.location.href = 'delete_user.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف الحذف
    }
}



</script>

</body>
</html>
