<header class="header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="mobile-menu-btn me-3 d-lg-none">
                    <button class="btn btn-light" id="menuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="hospital-info">
                    <div class="hospital-logo">
                        <i class="fas fa-hospital"></i>
                    </div>
                    <div>
                        <h2>Welcome back, Dr. {{ $user->detail->first_name ?? 'Doctor' }}</h2>
                        <p>Hospital: {{ $hospital->name ?? 'Not Assigned' }}</p>
                    </div>
                </div>
            </div>
            
            <div class="header-right">
                <!-- put this in your nav bar or header -->
                <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="badge bg-danger" id="notificationCount">0</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" id="notificationList">
        <li class="dropdown-item">No new notifications</li>
    </ul>
</li>


                <div class="user-profile d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">JD</div>
                        <div>
                            <div class="user-name">Dr. {{ $user->detail->first_name ?? 'Doctor' }}</div>
                            <div class="user-role">Blood Bank Manager at {{ $hospital->name ?? 'Not Assigned' }}</div>
                        </div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="ms-3">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
