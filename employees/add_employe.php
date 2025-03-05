<?php
session_start();
include('dbconnect.php'); // تأكد من الاتصال بقاعدة البيانات

// التعامل مع نموذج إضافة الموظف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $age = intval($_POST['age']); // تأكد من تحويل العمر إلى عدد صحيح
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $jop_id = intval($_POST['jop_id']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // استعلام لإضافة الموظف إلى قاعدة البيانات
    $query = "INSERT INTO employees (name, age, phone, address, email, status, jop_id) VALUES ('$name', '$age', '$phone', '$address', '$email', '$status', '$jop_id')";

    if (mysqli_query($connection, $query)) {
        $_SESSION['success_message'] = "تم إضافة الموظف بنجاح.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "فشل في إضافة الموظف: " . mysqli_error($connection);
    }
}
?>

<?php include('header.php'); ?>
<?php include('C:\xampp\htdocs\myapp\sidebar.php'); ?>

<main class="main-content">
    <div class="container">
        <h1>إضافة موظف جديدة</h1>

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

        <form action="add_employe.php" method="POST">
            <div class="form-group">
                <label for="name">اسم الموظف</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">العمر</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="phone">رقم الهاتف</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">عنوان السكن</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" required>
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
                            echo '<option value="' . htmlspecialchars($jops_row['id']) . '">' . htmlspecialchars($jops_row['title']) . '</option>'; // تأكد من استخدام العمود الصحيح
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
        <option value="متقدم للوظيفة">متقدم للوظيفة</option>
        <option value="متدرب">متدرب</option>
        <option value="غير مقبول">غير مقبول</option>
        <option value="موظف" selected>موظف</option> <!-- تعيين الخيار الافتراضي هنا -->
    </select>
</div>
            <button type="submit" class="submit-btn">إضافة الموظف</button>
        </form>
    </div>
</main>
</body>
</html>