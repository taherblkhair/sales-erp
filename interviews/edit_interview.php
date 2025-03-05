<?php
include('dbconnect.php'); // تأكد من أن لديك اتصال بقاعدة البيانات
include('header.php'); 

// تحقق من وجود معرف المقابلة في GET
if (isset($_GET['id'])) {
    $interview_id = $_GET['id'];

    // استعلام لجلب معلومات المقابلة
    $query = "SELECT * FROM interviews WHERE id = $interview_id";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $interview = mysqli_fetch_assoc($result);
    } else {
        die("فشل في جلب بيانات المقابلة: " . mysqli_error($connection));
    }
} else {
    die("معرف المقابلة غير موجود.");
}

// استعلام لجلب جميع الموظفين
$employee_query = "SELECT id, name FROM employees";
$employee_result = mysqli_query($connection, $employee_query);

// استعلام لجلب جميع الوظائف
$job_query = "SELECT id, title FROM jops";
$job_result = mysqli_query($connection, $job_query);
?>



<div class="container">
    <h1>تعديل مقابلة العمل</h1>
    <form action="update_interview.php" method="POST">
        <input type="hidden" name="interview_id" value="<?php echo htmlspecialchars($interview['id']); ?>">

        <div class="form-group">
            <label for="employee_id">الموظف:</label>
            <select name="employee_id" id="employee_id" class="form-control" required>
                <?php while ($employee = mysqli_fetch_assoc($employee_result)): ?>
                    <option value="<?php echo $employee['id']; ?>" <?php echo $employee['id'] == $interview['employee_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($employee['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="job_id">الوظيفة:</label>
            <select name="job_id" id="job_id" class="form-control" required>
                <?php while ($job = mysqli_fetch_assoc($job_result)): ?>
                    <option value="<?php echo $job['id']; ?>" <?php echo $job['id'] == $interview['job_id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($job['title']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="interview_date">تاريخ المقابلة:</label>
            <input type="date" name="interview_date" id="interview_date" class="form-control" value="<?php echo htmlspecialchars($interview['interview_date']); ?>" required>
        </div>

        <div class="form-group">
            <label for="interview_time">وقت المقابلة:</label>
            <input type="time" name="interview_time" id="interview_time" class="form-control" value="<?php echo htmlspecialchars($interview['interview_time']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">تحديث المقابلة</button>
        <a href="index.php" class="btn btn-secondary">إلغاء</a>
    </form>
</div>

</body>
</html>