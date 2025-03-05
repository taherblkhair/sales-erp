<?php
session_start();
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

// تحقق من وجود معرف الوظيفة في الطلب
if (isset($_GET['id'])) {
    $jobId = intval($_GET['id']);

    // استعلام لجلب بيانات الوظيفة
    $query = "SELECT * FROM jops WHERE id = $jobId";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("فشل الاستعلام: " . mysqli_error($connection));
    }

    $job = mysqli_fetch_assoc($result);
    if (!$job) {
        die("لم يتم العثور على الوظيفة.");
    }
} else {
    die("معرف الوظيفة مفقود.");
}

// التعامل مع نموذج التعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $company_id = intval($_POST['company_id']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // استعلام لتحديث بيانات الوظيفة
    $updateQuery = "UPDATE jops SET title = '$title', description = '$description', company_id = $company_id, status = '$status' WHERE id = $jobId";

    if (mysqli_query($connection, $updateQuery)) {
        $_SESSION['success_message'] = "تم تعديل بيانات الوظيفة بنجاح.";
        header("Location: index.php"); // إعادة التوجيه بعد النجاح
        exit();
    } else {
        $_SESSION['error_message'] = "فشل في تعديل بيانات الوظيفة: " . mysqli_error($connection);
    }
}
?>


    <?php include('header.php'); ?>
    <?php include('C:\xampp\htdocs\myapp\sidebar.php'); ?>

    <main class="main-content">
        <div class="container">
            <h1>تعديل بيانات الوظيفة</h1>

            <?php
            // عرض رسالة النجاح أو الخطأ
            if (isset($_SESSION['success_message'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                unset($_SESSION['success_message']);
            }
            if (isset($_SESSION['error_message'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                unset($_SESSION['error_message']);
            }
            ?>

            <form action="edit_job.php?id=<?php echo $jobId; ?>" method="POST">
                <div class="form-group">
                    <label for="title">عنوان الوظيفة</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="description">الوصف</label>
                    <textarea id="description" name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="company_id">اسم الشركة</label>
                    <select id="company_id" name="company_id" required>
                        <option value="">اختر الشركة</option>
                        <?php
                        // استعلام لجلب جميع الشركات
                        $company_query = "SELECT * FROM companies"; // تأكد من أن اسم الجدول صحيح
                        $company_result = mysqli_query($connection, $company_query);

                        if ($company_result) {
                            while ($company_row = mysqli_fetch_assoc($company_result)) {
                                $selected = ($company_row['id'] == $job['company_id']) ? 'selected' : '';
                                echo '<option value="' . htmlspecialchars($company_row['id']) . '" ' . $selected . '>' . htmlspecialchars($company_row['name']) . '</option>';
                            }
                        } else {
                            echo '<option value="">لا توجد شركات متاحة</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">الحالة</label>
                    <select id="status" name="status" required>
                        <option value="open" <?php echo ($job['status'] === 'متاحة') ? 'selected' : ''; ?>>مفتوحة</option>
                        <option value="closed" <?php echo ($job['status'] === 'غير متاحة') ? 'selected' : ''; ?>>مغلقة</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">تحديث الوظيفة</button>
            </form>
        </div>
    </main>
</body>
</html>