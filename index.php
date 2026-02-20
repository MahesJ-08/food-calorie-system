<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Based Calorie Measurement System</title>

    <?php include("bootstrap/cdn.html") ?>

    <style>
        body {
            background-color: #f8f9fa;
        }
        .section {
            padding: 60px 0;
        }
        .feature-card {
            transition: 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="fa-solid fa-house me-2"></i>Calorie System
        </a>
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <div class="ms-lg-auto text-center mt-3 mt-lg-0">
                <a href="register.php"
                   class="btn btn-success rounded-pill px-4 me-lg-2 mb-lg-0">
                    Register
                </a>
                <a href="login.php"
                   class="btn btn-primary rounded-pill px-4">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<section class="section">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="fw-bold mb-3">Track Your Daily Calories Easily</h1>
                <p class="text-muted">
                    Monitor your daily food intake, track calorie history,
                    and maintain a healthy lifestyle with our simple system.
                </p>
                <a href="register.php" class="btn btn-success rounded-pill px-4 me-2">Get Started</a>
                <a href="login.php" class="btn btn-outline-primary rounded-pill px-4">Login</a>
            </div>

            <div class="col-lg-6 text-center">
                <img src="images/h1.png" class="img-fluid rounded shadow" alt="Home Image">
            </div>

        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">Features</h2>

        <div class="row g-4">

            <div class="col-md-6 col-lg-3">
                <div class="card feature-card shadow-sm border-0 p-3 h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-chart-line fa-2x mb-3 text-success"></i>
                        <h5 class="fw-bold">Track Calories</h5>
                        <p class="text-muted">Monitor daily calorie intake easily.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card feature-card shadow-sm border-0 p-3 h-100">
                    <div class="card-body">
                        <i class="fa-regular fa-calendar-days fa-2x mb-3 text-primary"></i>
                        <h5 class="fw-bold">History</h5>
                        <p class="text-muted">View past calorie records by date.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card feature-card shadow-sm border-0 p-3 h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-arrow-up-right-from-square fa-2x mb-3 text-warning"></i>
                        <h5 class="fw-bold">Set Goals</h5>
                        <p class="text-muted">Set and achieve daily calorie targets.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card feature-card shadow-sm border-0 p-3 h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-shield-halved fa-2x mb-3 text-danger"></i>
                        <h5 class="fw-bold">Secure Login</h5>
                        <p class="text-muted">Protected user authentication system.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
</section>

</body>
</html>
