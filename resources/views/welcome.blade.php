<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Blood Donation System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ALL YOUR EXISTING CSS REMAINS EXACTLY THE SAME */
        :root {
            --primary-red: #d32f2f;
            --dark-red: #b71c1c;
            --light-red: #ffcdd2;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(211, 47, 47, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
            padding: 4rem 0;
            border-radius: 0 0 20px 20px;
            margin-bottom: 3rem;
        }

        .display-4 {
            font-weight: 700;
            color: var(--dark-red);
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }

        .lead {
            font-size: 1.4rem;
            color: #555;
        }

        .btn-donate {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
            padding: 0.8rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-donate:hover {
            background-color: var(--dark-red);
            border-color: var(--dark-red);
            transform: translateY(-2px);
        }

        .btn-login {
            border-width: 2px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
        }

        .stats-section {
            background-color: white;
            padding: 3rem 0;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin: 3rem 0;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-red);
        }

        .stat-label {
            font-size: 1.1rem;
            color: #666;
        }

        .benefits-section {
            padding: 3rem 0;
        }

        .benefit-card {
            border: none;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s;
            height: 100%;
            background-color: #fff;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .benefit-icon {
            font-size: 2.5rem;
            color: var(--primary-red);
            margin-bottom: 1rem;
        }

        footer {
            background-color: var(--dark-red);
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        footer a {
            color: white;
            transition: color 0.2s;
        }

        footer a:hover {
            color: var(--light-red);
        }
    </style>
</head>
<body>
    <!-- Hero Section - ONLY THIS SECTION CHANGED -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-4 mb-4">Welcome to the Blood Donation System</h1>
                    <h2 class="mb-4" style="color: var(--dark-red); font-weight: 600;">Become a Donor</h2>
                    <p class="lead mb-5">Every drop counts. Join our life-saving mission and become a hero in your community.</p>

                    
                    <p class="mt-3 mb-2">Already have an account?</p>
                    <a href="{{ url('/login') }}" class="btn btn-login btn-outline-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- REST OF THE PAGE REMAINS EXACTLY THE SAME -->
    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 stat-item">
                    <div class="stat-number">10,000+</div>
                    <div class="stat-label">Lives Saved</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">5,000+</div>
                    <div class="stat-label">Active Donors</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Partner Hospitals</div>
                </div>
                <div class="col-md-3 stat-item">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Emergency Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <h2 class="text-center mb-5">Why Donate Blood?</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-heartbeat"></i>
                        </div>
                        <h3>Save Lives</h3>
                        <p>A single donation can save up to three lives. Your contribution makes a direct impact.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>Health Benefits</h3>
                        <p>Donating blood can improve your health by reducing harmful iron stores and stimulating cell regeneration.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Community Impact</h3>
                        <p>Be part of a compassionate network ensuring a reliable blood supply for those in urgent need.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <h3 class="mb-3">Blood Donation System</h3>
                    <p class="mb-4">Connecting donors with those in need since 2023.</p>
                    <div class="mb-4">
                        <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                    <p class="small mb-0">&copy; {{ date('Y') }} Blood Donation System. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>