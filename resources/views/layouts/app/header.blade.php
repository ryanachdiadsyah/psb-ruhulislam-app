<div class="page-header">
    <nav class="navbar navbar-expand-lg d-flex justify-content-between">
        <div id="navbarNav">
            <ul class="navbar-nav" id="leftNav">
                <li class="nav-item">
                    <a class="nav-link" id="sidebar-toggle" href="#"><i data-feather="arrow-left"></i></a>
                </li>
            </ul>
        </div>
        <div class="logo">
            <a class="navbar-brand" href="{{ route('dashboard') }}"></a>
        </div>
        <div id="headerNav">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link notifications-dropdown" href="#" id="notificationsDropDown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">3</a>
                    <div class="dropdown-menu dropdown-menu-end notif-drop-menu"
                        aria-labelledby="notificationsDropDown">
                        <h6 class="dropdown-header">Notifications</h6>
                        <a href="#">
                            <div class="header-notif">
                                <div class="notif-image">
                                    <span class="notification-badge bg-info text-white">
                                        <i class="fas fa-bullhorn"></i>
                                    </span>
                                </div>
                                <div class="notif-text">
                                    <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                                    <small>19:00</small>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="header-notif">
                                <div class="notif-image">
                                    <span class="notification-badge bg-primary text-white">
                                        <i class="fas fa-bolt"></i>
                                    </span>
                                </div>
                                <div class="notif-text">
                                    <p class="bold-notif-text">faucibus dolor in commodo lectus mattis</p>
                                    <small>18:00</small>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="header-notif">
                                <div class="notif-image">
                                    <span class="notification-badge bg-success text-white">
                                        <i class="fas fa-at"></i>
                                    </span>
                                </div>
                                <div class="notif-text">
                                    <p>faucibus dolor in commodo lectus mattis</p>
                                    <small>yesterday</small>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="header-notif">
                                <div class="notif-image">
                                    <span class="notification-badge">
                                        <img src="../../assets/images/avatars/profile-image.png" alt="">
                                    </span>
                                </div>
                                <div class="notif-text">
                                    <p>faucibus dolor in commodo lectus mattis</p>
                                    <small>yesterday</small>
                                </div>
                            </div>
                        </a>
                        <a href="#">
                            <div class="header-notif">
                                <div class="notif-image">
                                    <span class="notification-badge">
                                        <img src="../../assets/images/avatars/profile-image.png" alt="">
                                    </span>
                                </div>
                                <div class="notif-text">
                                    <p>faucibus dolor in commodo lectus mattis</p>
                                    <small>yesterday</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link profile-dropdown" href="#" id="profileDropDown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="profile">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-drop-menu" aria-labelledby="profileDropDown">
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="user"></i>Profile</a>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="key"></i>Update Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0)"><i data-feather="settings"></i>Settings</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"><i data-feather="log-out"></i>Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>