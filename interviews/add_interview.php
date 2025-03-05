<?php 
include('header.php'); 
include('dbconnect.php');
include('C:\xampp\htdocs\myapp\sidebar.php'); 

?>

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <div class="page-header">
            <h1>إضافة مقابلة عمل جديدة</h1>
            <button class="add-member-btn" onclick="window.location='interviews.php'">
                <i class="fas fa-arrow-left"></i>
                العودة إلى قائمة المقابلات
            </button>
        </div>

        <form action="save_interview.php" method="POST">
            <div class="form-group">
                <label for="employee_id">الموظف:</label>
                
                <select name="employee_id" id="employee_id" class="form-control" required>
                <option value="" disabled selected></option> <!-- الخيار الأول -->
    <?php
    // استعلام لجلب الموظفين الذين لديهم حالة "متقدم للوظيفة"
    $employee_query = "SELECT id, name FROM employees WHERE status = 'متقدم للوظيفة'";
    $employee_result = mysqli_query($connection, $employee_query);
    
    // تحقق من وجود نتائج
    if (mysqli_num_rows($employee_result) > 0) {
        while ($employee = mysqli_fetch_assoc($employee_result)) {
            echo "<option value='{$employee['id']}'>{$employee['name']}</option>";
        }
    } else {
        echo "<option value=''>لا يوجد موظفين متقدمين للوظيفة</option>";
    }
    ?>
</select>
            </div>

            <div class="form-group">
                <label for="job_id">الوظيفة:</label>
                <select name="job_id" id="job_id" class="form-control" required>
                    <?php
                    // استعلام لجلب جميع الوظائف
                    $job_query = "SELECT id, title FROM jops";
                    $job_result = mysqli_query($connection, $job_query);
                    while ($job = mysqli_fetch_assoc($job_result)) {
                        echo "<option value='{$job['id']}'>{$job['title']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="interview_date">تاريخ المقابلة:</label>
                <input type="date" name="interview_date" id="interview_date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="interview_time">وقت المقابلة:</label>
                <input type="time" name="interview_time" id="interview_time" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">إضافة مقابلة</button>
        </form>
    </div>
</main>

</body>
</html>