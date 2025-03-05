<?php 
include('header.php'); 
include('dbconnect.php'); 
include('C:\xampp\htdocs\myapp\sidebar.php'); 
?>

<!-- Main Content -->
<main class="main-content">
<?php if (isset($_GET['status_change']) && $_GET['status_change'] === 'success'): ?>
    <div class="alert alert-success">تم تغيير الحالة بنجاح!</div>
<?php endif; ?>

    <div class="container">
        <div class="page-header">
       
            <h1>إدارة موظف</h1>

            <button class="add-member-btn" onclick="window.location='add_employe.php'">
    <i class="fas fa-plus"></i>
    إضافة موظف جديدة
</button>
        </div>
        <table class="table table-striped table-bordered committee-table">
    <thead>
        <tr>
            <th>الموظف</th>
            <th>العمر</th>
            <th>رقم هاتف</th>
            <th>العنوان</th>
            <th>البريد الإكتروني</th>
            <th>الحالة</th>
            <th>الإجراءات</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    // استعلام لجلب جميع الموظفين
    $query = "SELECT * FROM `employees`"; // تأكد من أن اسم الجدول صحيح
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("فشل الاستعلام: " . mysqli_error($connection));
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['age']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="window.location='edit_employee.php?id=<?php echo $row['id']; ?>'">تعديل</button>
                    <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $row['id']; ?>)">حذف</button>
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
    if (confirm('هل أنت متأكد من حذف هذه الموظف')) {
        // إذا أكد المستخدم، قم بإرسال طلب الحذف إلى الخادم
        window.location.href = 'delete_employees.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف الحذف
    }
}

function editJob(jobId) {
    window.location.href = 'edit_job.php?id=' + jobId;
}
function toggleStatus(jobId, currentStatus) {
    if (confirm('هل تريد تغيير حالة هذه الوظيفة؟')) {
        // إذا أكد المستخدم، قم بإرسال طلب تغيير الحالة إلى الخادم
        window.location.href = 'change_status.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف تغيير الحالة
    }
}

</script>

</body>
</html>
