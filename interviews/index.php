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
            <h1>إدارة مقابلات العمل</h1>
            <button class="add-member-btn" onclick="window.location='add_interview.php'">
    <i class="fas fa-plus"></i>
    إضافة مقابلة جديدة
</button>
        </div>
        <table class="table table-striped table-bordered committee-table">
            <thead>
                <tr>
                    <th>المتقدم</th>
                    <th>الوظيفة</th>
                    <th>تاريخ</th>
                    <th>التوقيت</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            // استعلام لجلب جميع المقابلات
            $query = "SELECT * FROM `interviews`"; // تأكد من أن اسم الجدول صحيح
            $result = mysqli_query($connection, $query);

            if (!$result) {
                die("فشل الاستعلام: " . mysqli_error($connection));
            } else {
                while ($row = mysqli_fetch_assoc($result)) {
                    // استعلام لجلب اسم الوظيفة بناءً على job_id
                    $job_id = $row['job_id'];
                    $job_query = "SELECT title FROM jops WHERE id = $job_id";
                    $job_result = mysqli_query($connection, $job_query);
                    $job_name = '';
                    if ($job_result && mysqli_num_rows($job_result) > 0) {
                        $job_row = mysqli_fetch_assoc($job_result);
                        $job_name = $job_row['title'];
                    }

                    // استعلام لجلب اسم الموظف بناءً على employee_id
                    $employee_id = $row['employee_id'];
                    $employee_query = "SELECT name FROM employees WHERE id = $employee_id"; // تأكد من أن اسم الجدول واسم العمود صحيحين
                    $employee_result = mysqli_query($connection, $employee_query);
                    $employee_name = '';
                    if ($employee_result && mysqli_num_rows($employee_result) > 0) {
                        $employee_row = mysqli_fetch_assoc($employee_result);
                        $employee_name = $employee_row['name'];
                    }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee_name); ?></td> <!-- عرض اسم الموظف -->
                    <td><?php echo htmlspecialchars($job_name); ?></td>
                    <td><?php echo htmlspecialchars($row['interview_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['interview_time']); ?></td>
                    <td>
                    <button class="btn btn-primary btn-sm" onclick="window.location='edit_interview.php?id=<?php echo $row['id']; ?>'">تعديل</button>
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
        window.location.href = 'delete_employees.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف الحذف
    }
}

function editJob(jobId) {
    window.location.href = 'edit_job.php?id=' + jobId;
}

function toggleStatus(jobId, currentStatus) {
    if (confirm('هل تريد تغيير حالة هذه الوظيفة؟')) {
        window.location.href = 'change_status.php?id=' + jobId; // تأكد من تعديل الرابط حسب مسار ملف تغيير الحالة
    }
}
</script>

</body>
</html>