<?php
session_start();
include('header.php'); 
include('dbconnect.php'); 
include('sidebar.php'); 

// تأكد من الاتصال بقاعدة البيانات

// تحقق من وجود معرف المستخدم في الطلب
if (isset($_GET['id'])) {
    $userId = intval($_GET['id']);

    // استعلام لجلب بيانات المستخدم
    $query = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("فشل الاستعلام: " . mysqli_error($connection));
    }

    $user = mysqli_fetch_assoc($result);
    if (!$user) {
        die("لم يتم العثور على المستخدم.");
    }
} else {
    die("معرف المستخدم مفقود.");
}

// التعامل مع نموذج التعديل
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    // استعلام لتحديث بيانات المستخدم
    $updateQuery = "UPDATE users SET name = '$name', email = '$email', role = '$role' WHERE id = $userId";

    if (mysqli_query($connection, $updateQuery)) {
        $_SESSION['success_message'] = "تم تعديل بيانات المستخدم بنجاح.";
        header("Location: index.php"); // إعادة التوجيه بعد النجاح
        exit();
    } else {
        $_SESSION['error_message'] = "فشل في تعديل بيانات المستخدم: " . mysqli_error($connection);
    }
}
?>


<!-- Main Content -->

<main class="main-content">

    <div class="container">
 
        <div class="page-header">
            <h1>تعديل موظف  جديد</h1>
        </div>
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
        <div>
        <form action="edit_user.php?id=<?php echo $userId; ?>" method="POST">
            <div class="form-group">
                <label for="name">الاسم الكامل</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="role">الدور في اللجنة</label>
                <select id="role" name="role" required>
                    <option value="رئيس اللجنة" <?php echo ($user['role'] === 'رئيس اللجنة') ? 'selected' : ''; ?>>رئيس اللجنة</option>
                    <option value="عضو" <?php echo ($user['role'] === 'عضو') ? 'selected' : ''; ?>>عضو</option>
                    <option value="رئيس" <?php echo ($user['role'] === 'رئيس') ? 'selected' : ''; ?>>رئيس</option>
                    <option value="أخرى" <?php echo ($user['role'] === 'أخرى') ? 'selected' : ''; ?>>أخرى</option>
                </select>
            </div>
            <button type="submit" class="submit-btn">تحديث</button>
        </form>
</div>


    </div>
</main>


</body>
</html>
