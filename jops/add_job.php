<?php
session_start();
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

// التعامل مع نموذج إضافة الوظيفة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $company_id = intval($_POST['company_id']); // تأكد من الحصول على company_id بشكل صحيح
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // استعلام لإضافة الوظيفة إلى قاعدة البيانات
    $query = "INSERT INTO jops (title, description, company_id, status) VALUES ('$title', '$description', $company_id, '$status')";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success_message'] = "تم إضافة الوظيفة بنجاح.";
        header("Location: add_job.php"); // إعادة التوجيه بعد النجاح
        exit();
    } else {
        $_SESSION['error_message'] = "فشل في إضافة الوظيفة: " . mysqli_error($connection);
    }
}
?>



    <?php include('header.php'); ?>
    <?php include('C:\xampp\htdocs\myapp\sidebar.php'); ?>

    <main class="main-content">
        <div class="container">
            <h1>إضافة وظيفة جديدة</h1>

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

                <form action="add_job.php" method="POST">
                <div class="form-group">
                    <label for="title">عنوان الوظيفة</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">الوصف</label>
                    <textarea id="description" name="description" required></textarea>
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
                                echo '<option value="' . htmlspecialchars($company_row['id']) . '">' . htmlspecialchars($company_row['name']) . '</option>';
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
                        <option value="open">متاحة</option>
                        <option value="closed">غير متاحة</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">إضافة الوظيفة</button>
            </form>
        </div>
    </main>
</body>
</html>