<?php
session_start();
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

// التحقق من وجود معرف الموظف في الرابط
if (isset($_GET['id'])) {
    $employee_id = intval($_GET['id']);

    // استعلام لجلب بيانات الموظف
    $query = "SELECT * FROM employees WHERE id = $employee_id";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['error_message'] = "لم يتم العثور على الموظف.";
        header("Location: employees_list.php"); // إعادة التوجيه إلى قائمة الموظفين
        exit();
    }
} else {
    $_SESSION['error_message'] = "معرف الموظف غير موجود.";
    header("Location: employees_list.php"); // إعادة التوجيه إلى قائمة الموظفين
    exit();
}

// التعامل مع نموذج تعديل الموظف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $age = intval($_POST['age']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $jop_id = intval($_POST['jop_id']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // استعلام لتحديث بيانات الموظف
    $update_query = "UPDATE employees SET name='$name', age='$age', phone='$phone', address='$address', email='$email', jop_id='$jop_id', status='$status' WHERE id=$employee_id";

    if (mysqli_query($connection, $update_query)) {
        $_SESSION['success_message'] = "تم تعديل بيانات الموظف بنجاح.";
        header("Location: index.php"); // إعادة التوجيه بعد النجاح
        exit();
    } else {
        $_SESSION['error_message'] = "فشل في تعديل بيانات الموظف: " . mysqli_error($connection);
    }
}
?>

<?php include('header.php'); ?>
<?php include('C:\xampp\htdocs\myapp\sidebar.php'); ?>

<main class="main-content">
    <div class="container">
        <h1>تعديل بيانات الموظف</h1>

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

        <form action="edit_employee.php?id=<?php echo $employee_id; ?>" method="POST">
            <div class="form-group">
                <label for="name">اسم الموظف</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="age">العمر</label>
                <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($employee['age']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">رقم الهاتف</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label for="address">عنوان السكن</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($employee['address']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jop_id">اسم الوظيفة</label>
                <select id="jop_id" name="jop_id" required>
                    <option value="">اختر الوظيفة</option>
                    <?php
                    // استعلام لجلب جميع الوظائف
                    $jops_query = "SELECT * FROM jops";
                    $jops_result = mysqli_query($connection, $jops_query);

                    if ($jops_result) {
                        while ($jops_row = mysqli_fetch_assoc($jops_result)) {
                            $selected = ($jops_row['id'] == $employee['jop_id']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($jops_row['id']) . '" ' . $selected . '>' . htmlspecialchars($jops_row['title']) . '</option>';
                        }
                    } else {
                        echo '<option value="">لا توجد وظائف متاحة</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="status">الحالة</label>
                <select id="status" name="status" required>
                    <option value="متقدم للوظيفة" <?php echo ($employee['status'] == 'متقدم للوظيفة') ? 'selected' : ''; ?>>متقدم للوظيفة</option>
                    <option value="متدرب" <?php echo ($employee['status'] == 'متدرب') ? 'selected' : ''; ?>>متدرب</option>
                    <option value="غير مقبول" <?php echo ($employee['status'] == 'غير مقبول') ? 'selected' : ''; ?>>غير مقبول</option>
                    <option value="موظف" <?php echo ($employee['status'] == 'موظف') ? 'selected' : ''; ?>>موظف</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">تعديل الموظف</button>
        </form>
    </div>
</main>
</body>
</html>