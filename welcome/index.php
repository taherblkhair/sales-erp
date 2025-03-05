<?php 
include('dbconnect.php'); 
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
وظفني
  </title>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   body {
    font-family: 'Cairo', sans-serif;
}
        .navbar {
            background-color: #f8f9fa;
        }
        .navbar-nav .nav-link {
            color: #000;
        }
        .navbar-nav .nav-link:hover {
            color: #007bff;
        }
        .featured-jobs, .latest-jobs {
            margin-top: 20px;
        }
        .job-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .job-card img {
            max-width: 100%;
            height: auto;
        }
        .job-card .job-title {
            font-size: 1.25rem;
            font-weight: bold;
        }
        .job-card .job-company {
            color: #666;
        }
        .job-card .job-type, .job-card .job-location {
            font-size: 0.875rem;
            color: #666;
        }
        .job-card .job-summary {
            margin-top: 10px;
        }
        .job-card .view-more {
            background-color: #2557a7;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            margin-top: 10px;
        }
        .job-card .view-more:hover {
            background-color: #2557a7;
        }
        .job-card .actions {
            margin-top: 10px;
        }
        .job-card .actions a {
            color: #007bff;
            margin-right: 10px;
        }
        .job-card .actions a:hover {
            text-decoration: underline;
        }
  </style>
 </head>
<body>
    <?php include('component/nav.php'); ?>   

    <div class="container">
        <div class="row">
            <div class="col-md-6 featured-jobs">
                <h2>وظائف مميزة</h2>
                <div class="job-card">
                    <div class="row">
                        <div class="col-3">
                            <img alt="Company logo for ERP D365 Support" src="https://placehold.co/100x100"/>
                        </div>
                        <div class="col-9">
                            <div class="job-title">ERP D365 Support</div>
                            <div class="job-company">Mabruk Oil Operation</div>
                            <div class="actions">
                                <a href="#"><i class="fas fa-heart"></i> Save</a>
                                <a href="#"><i class="fas fa-share"></i> Share</a>
                            </div>
                            <div class="job-type">Contract</div>
                            <div class="job-type">Volunteer</div>
                            <div class="job-location">Tripoli</div>
                            <div class="job-summary">
                                Job Summary: The ERP D365 Support Specialist is responsible for providing technical support and assistance for Microsoft Dynamics 365 ERP systems. This role involves troubleshooting.
                            </div>
                            <button class="view-more">View more</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 latest-jobs">
                <h2>Latest jobs - آخر الوظائف</h2>
                <?php 
                // استعلام لجلب جميع الوظائف
                $query = "SELECT * FROM `jops`"; // تأكد من أن اسم الجدول صحيح
                $result = mysqli_query($connection, $query);

                if (!$result) {
                    die("فشل الاستعلام: " . mysqli_error($connection));
                } else {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // استعلام لجلب اسم الشركة بناءً على company_id
                        $company_id = intval($row['company_id']);
                        $company_query = "SELECT name FROM companies WHERE id = $company_id";
                        $company_result = mysqli_query($connection, $company_query);

                        // تحقق من وجود اسم الشركة
                        $company_name = '';
                        if ($company_result && mysqli_num_rows($company_result) > 0) {
                            $company_row = mysqli_fetch_assoc($company_result);
                            $company_name = $company_row['name'];
                        }
                        ?>
                        <div class="job-card">
                            <div class="row">
                                <div class="col-3">
                                    <div class="job-company">
                                        <!-- يمكنك إضافة شعار الشركة هنا إذا كان موجودًا -->
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="job-title"><?php echo htmlspecialchars($row['title']); ?></div>
                                    <div class="job-company"><?php echo htmlspecialchars($company_name); ?></div>
                                    <div class="job-type"><?php echo htmlspecialchars($row['description']); ?></div>
                                    <div class="actions">
                                        <a href="#"><i class="fas fa-envelope"></i> Send to friend</a>
                                        <a href="#"><i class="fas fa-heart"></i> Save</a>
                                        <a href="#"><i class="fas fa-share"></i> Share</a>
                                    </div>
                                    <button class="view-more" onclick="window.location='job_details.php?id=<?php echo $row['id']; ?>'">تفاصيل</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

        <div class="mask" style="background-color: rgba(255, 255, 255, 0.6);">
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="text-black">
                    <h1 class="mb-3">الشركات</h1>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($companies as $company): ?>
                <div class="col">
                    <div class="card">
                        <?php if ($company->logo_path): ?>
                            <img src="<?php echo htmlspecialchars(asset('storage/' . $company->logo_path)); ?>" alt="<?php echo htmlspecialchars($company->name); ?>" class="card-img-top">
                        <?php else: ?>
                            <span>لا يوجد شعار</span>
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($company->name); ?></h5>
                            <p>عنوان الشركة: <b><?php echo htmlspecialchars($company->address); ?></b></p>
                            <p>رقم هاتف الشركة: <?php echo htmlspecialchars($company->phone); ?></p>
                            <p>البريد الإلكتروني: <?php echo htmlspecialchars($company->email); ?></p>
                            <a href="jobs_company.php?id=<?php echo $company->id; ?>" class="btn btn-primary">عرض الوظائف</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>