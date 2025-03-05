<?php 
include('header.php'); 
include('dbconnect.php'); 
include('sidebar.php'); 

session_start(); // بدء الجلسة

?>

<style>
    #memberForm {
        margin-top: 20px;
        width: 600px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .form-group {
        flex: 1;
        margin-right: 10px;
    }

    .form-group:last-child {
        margin-right: 0;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    input:focus, select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    .submit-btn {
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #5b1fbc;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }
</style>
<!-- Main Content -->
<main class="main-content">

    <div class="container">
    <?php
        // عرض رسالة النجاح إذا كانت موجودة
        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // حذف الرسالة بعد العرض
        }

        // عرض رسالة الخطأ إذا كانت موجودة
        if (isset($_SESSION['error_message'])) {
            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
            unset($_SESSION['error_message']); // حذف الرسالة بعد العرض
        }
        ?>
        <div class="page-header">
            <h1>إنشاء موظف  جديد</h1>
        </div>
        <div>
        <form action="add_member.php" method="POST">
    <div class="form-row">
        <div class="form-group">
            <label for="name">الاسم الكامل</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإكتروني</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group" style="display: none;">
            <label for="password">كلمة المرور</label>
            <input value="password" id="password" name="password" hidden>
        </div>
       
    </div>

    <div class="form-group">
        <label for="role">الدور في اللجنة</label>
        <select id="role" name="role" required>
            <option value="">اختر الدور</option>
            <option value="رئيس اللجنة">رئيس اللجنة</option>
            <option value="عضو">عضو</option>
            <option value="رئيس">رئيس</option>
            <option value="أخرى">أخرى</option>
        </select>
    </div>

    <button type="submit" class="submit-btn">حفظ</button>
</form>
</div>


    </div>
</main>


</body>
</html>
