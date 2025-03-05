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
       
            <h1>إدارة الوظائف</h1>

            <button class="add-member-btn" onclick="window.location='add_job.php'">
    <i class="fas fa-plus"></i>
    إضافة وظيفة جديدة
</button>
        </div>
        <table class="committee-table">
            <thead>
                <tr>
                    <th>عنوان الوظيفة</th>
                    <th>الوصف</th>
                    <th>الشركة</th>
                    <th>الحالة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // استعلام لجلب جميع الوظائف
                $query = "SELECT * FROM `jops`"; // تأكد من أن اسم الجدول صحيح
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    die("فشل الاستعلام: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // استعلام لجلب اسم الشركة بناءً على company_id
                        $company_id = $row['company_id'];
                        $company_query = "SELECT name FROM companies WHERE id = $company_id";
                        $company_result = mysqli_query($connection, $company_query);

                        // تحقق من وجود اسم الشركة
                        $company_name = '';
                        if ($company_result && mysqli_num_rows($company_result) > 0) {
                            $company_row = mysqli_fetch_assoc($company_result);
                            $company_name = $company_row['name'];
                        }
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($company_name); ?></td> <!-- عرض اسم الشركة -->
                            <td>
    <?php 
    $status = htmlspecialchars($row['status']); 
    if ($status === 'open') {
        echo '<span style="color: green;">متاحة</span>'; // حالة مفتوحة
    } elseif ($status === 'closed') {
        echo '<span style="color: red;">غير متاحة</span>'; // حالة مغلقة
    } else {
        echo '<span>' . $status . '</span>'; // حالات أخرى (إذا كانت موجودة)
    }
    ?>
</td>                            <td>
                            <button onclick="window.location='edit_job.php?id=<?php echo $row['id']; ?>'">تعديل</button>
                            <button onclick="confirmDelete(<?php echo $row['id']; ?>)">حذف</button>
                              <button onclick="toggleStatus(<?php echo $row['id']; ?>, '<?php echo $row['status']; ?>')">تغيير الحالة</button>

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
        window.location.href = 'delete_job.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف الحذف
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
