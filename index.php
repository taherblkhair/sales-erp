<?php 
include('header.php'); 
include('dbconnect.php'); 
include('sidebar.php'); 
?>
<style>
     /* Main Content Styles */
     .main-content {
            margin-right: 280px;
            padding: 2rem;
            width: calc(100% - 280px);
        }

        .search-bar {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-input {
            flex-grow: 1;
            border: none;
            padding: 0.5rem;
            font-size: 1rem;
        }

        .search-input:focus {
            outline: none;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.1rem;
            color: #333;
            font-weight: 600;
        }

., [09/01/2025 10:51 م]
.card-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .bg-blue { background: #2557a7; }
        .bg-green { background: #28a745; }
        .bg-orange { background: #fd7e14; }
        .bg-purple { background: #6f42c1; }

        .card-value {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin: 1rem 0;
        }

        .card-label {
            color: #666;
            font-size: 0.9rem;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            width: 100%;
            justify-content: center;
            border-top: 1px solid #eee;
            margin-top: auto;
        }

        .logout-btn:hover {
            background: #fff5f5;
        }
</style>
<main class="main-content">
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="البحث...">
        </div>

        <?php
$job_query = "SELECT COUNT(*) as available_jobs FROM jops WHERE status = 'open'";

$job_result = mysqli_query($connection, $job_query);


if ($job_result) {

    $job_data = mysqli_fetch_assoc($job_result);

    $available_jobs = $job_data['available_jobs'];

} else {

    $available_jobs = 0; // في حالة حدوث خطأ في الاستعلام

}

?>
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-header">
                    <h3 class="card-title">jjjj الوظائف متاحة</h3>
                    <div class="card-icon bg-blue">
                        <i class="fas fa-briefcase"></i>
                    </div>
                </div>
                <div class="card-value"><?php echo htmlspecialchars($available_jobs); ?></div>
                <div class="card-label">وظيفة متاحة</div>
            </div>
            <?php
// استعلام لجلب عدد المتقدمين الجدد
$user_query = "SELECT COUNT(*) as user_jobs FROM employees WHERE status = 'متقدم للوظيفة'";

// تنفيذ الاستعلام
$user_result = mysqli_query($connection, $user_query);

if ($user_result) {
    // جلب البيانات
    $user_data = mysqli_fetch_assoc($user_result);
    $user_jobs = $user_data['user_jobs'];
} else {
    // في حالة حدوث خطأ في الاستعلام
    $user_jobs = 0; 
}
?>

<div class="dashboard-card">
    <div class="card-header">
        <h3 class="card-title">المتقدمين الجدد</h3>
        <div class="card-icon bg-green">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="card-value"><?php echo htmlspecialchars($user_jobs); ?></div>
    <div class="card-label">متقدم جديد</div>
</div>
<?php
// استعلام لجلب عدد المستخدمين
$user_query = "SELECT COUNT(*) as total_users FROM users";
$user_result = mysqli_query($connection, $user_query);

if ($user_result) {
    // جلب البيانات
    $user_data = mysqli_fetch_assoc($user_result);
    $total_users = $user_data['total_users'];
} else {
    // في حالة حدوث خطأ في الاستعلام
    $total_users = 0; 
}
?>

<div class="dashboard-card">
    <div class="card-header">
        <h3 class="card-title">لجنة التوظيف</h3>
        <div class="card-icon bg-green">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="card-value"><?php echo htmlspecialchars($total_users); ?></div>
    <div class="card-label">لجنة التوظيف</div>
</div>


            <?php
// استعلام لجلب عدد مقابلات العمل
$interview_query = "SELECT COUNT(*) as total_interviews FROM interviews";
$interview_result = mysqli_query($connection, $interview_query);

if ($interview_result) {
    // جلب البيانات
    $interview_data = mysqli_fetch_assoc($interview_result);
    $total_interviews = $interview_data['total_interviews'];
} else {
    // في حالة حدوث خطأ في الاستعلام
    $total_interviews = 0; 
}
?>

<div class="dashboard-card">
    <div class="card-header">
        <h3 class="card-title">مقابلات العمل</h3>
        <div class="card-icon bg-green">
            <i class="fas fa-users"></i>
        </div>
    </div>
    <div class="card-value"><?php echo htmlspecialchars($total_interviews); ?></div>
    <div class="card-label">متقدم جديد</div>
</div>
 
</main>
</body>
</html>




