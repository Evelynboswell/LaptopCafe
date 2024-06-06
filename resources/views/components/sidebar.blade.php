<div class="d-flex flex-column flex-shrink-0 p-3 text-white" style="width: 280px; height: 100vh; background-color: #067D40">
    <style>
        .nav-link:hover, .nav-link.active, .nav-link-button:hover, .nav-link-button.active {
            background-color: rgba(255, 255, 255, 0.2); /* Optional: Change background color on hover */
        }
        .bg-custom {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .nav-link, .nav-link-button {
            color: white !important;
            font-size: 1.2rem;
            padding: 0.75rem 1.25rem;
        }
        .nav-link:visited {
            color: white !important;
        }
        .nav-link-button {
            background-color: transparent;
            border: none;
            text-align: left;
            width: 100%;
            font-weight: bold;
        }
        .bi-chevron-right {
            transition: transform 0.3s ease;
        }
        .bi-chevron-right.rotate {
            transform: rotate(90deg);
        }
        .nav-link svg, .nav-link-button svg {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }
    </style>

    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <x-application-newlogo alt="Laptop Cafe Jogjakarta" class="img-fluid rounded-circle" width="80" />
        <h4 style="text-align: center; margin-left: -10px; margin-top: 15px">Laptop Cafe Jogjakarta</h4>
    </a>
    <br>

    {{-- Menu Side Nav --}}
    <ul class="nav nav-link-secondary flex-column fw-bold gap-2">
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="{{ Route::is('dashboard') ? 'text-white bg-custom rounded active' : '' }} nav-link">
                @include('components.icons.svg-dashboard')
                Dashboard
            </a>
        </li>
        <li>
            <a href="#transaksi-submenu" class="nav-link text-white d-flex justify-content-between align-items-center" onclick="toggleCollapse('transaksi-submenu', this)">
                <span>
                    @include('components.icons.svg-transaksi')
                    Transaksi
                </span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <div id="transaksi-submenu" class="collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li class="nav-item">
                        <a href="{{ route('service_transactions.index') }}" class="{{ Request::is('service_transactions*') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">
                            Servis
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sparepart') }}" class="{{ Request::is('sparepart') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">
                            Sparepart
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#database-submenu" class="nav-link text-white d-flex justify-content-between align-items-center" onclick="toggleCollapse('database-submenu', this)">
                <span>
                    @include('components.icons.svg-database')
                    Database
                </span>
                <i class="bi bi-chevron-right"></i>
            </a>
            <div id="database-submenu" class="collapse">
                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                    <li><a href="{{ route('users.index') }}" class="{{ Request::is('users*') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">Teknisi</a></li>
                    <li><a href="{{ route('customers.index') }}" class="{{ Request::is('customers*') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">Pelanggan</a></li>
                    <li><a href="{{ route('laptops.index') }}" class="{{ Request::is('laptops*') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">Laptop</a></li>
                    <li><a href="{{ route('services.index') }}" class="{{ Request::is('services*') ? 'text-white bg-custom rounded active' : '' }} nav-link ps-4">Jasa Servis</a></li>
                </ul>
            </div>
        </li>
        <li>
            <a href="#" class="nav-link text-white">
                @include('components.icons.svg-laporan')
                Laporan Keuangan
            </a>
        </li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link nav-link-button {{ Route::is('logout') ? 'active' : '' }}">
                    @include('components.icons.svg-logout')
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

{{-- JS --}}
<script>
    function toggleCollapse(id, element) {
        const submenu = document.getElementById(id);
        const isCollapsed = submenu.classList.contains('show');
        if (isCollapsed) {
            submenu.classList.remove('show');
        } else {
            submenu.classList.add('show');
        }
        // Save the state to local storage
        localStorage.setItem(id, submenu.classList.contains('show'));

        // Rotate the arrow
        const arrow = element.querySelector('.bi-chevron-right');
        if (submenu.classList.contains('show')) {
            arrow.classList.add('rotate');
        } else {
            arrow.classList.remove('rotate');
        }
    }

    // Load the state of the submenus from local storage
    document.addEventListener('DOMContentLoaded', function() {
        const submenus = ['transaksi-submenu', 'database-submenu'];
        submenus.forEach(function(id) {
            const submenu = document.getElementById(id);
            const isOpen = localStorage.getItem(id) === 'true';
            if (isOpen) {
                submenu.classList.add('show');
                // Rotate the arrow
                const arrow = document.querySelector(`a[href="#${id}"] .bi-chevron-right`);
                if (arrow) {
                    arrow.classList.add('rotate');
                }
            }
        });
    });

    // Highlight the active link
    document.querySelectorAll('.nav-link, .nav-link-button').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });
</script>
