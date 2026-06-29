<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonCard Hub - Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-color: #f4f7f6;
            --text-main: #2d3748;
            --text-muted: #718096;
            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.05);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            --table-header-bg: #f8fafc;
            --table-row-hover: #f1f5f9;
            --placeholder-color: #a0aec0;
            --date-warning: #d97706;
            --date-danger: #dc2626;
            
            /* Wiersze podświetleń */
            --highlight-new: rgba(16, 185, 129, 0.05);
            --highlight-updated: rgba(59, 130, 246, 0.05);
        }

        [data-theme="dark"] {
            --bg-color: #1a202c;
            --text-main: #ffffff;
            --text-muted: #cbd5e1;
            --card-bg: #2d3748;
            --card-border: rgba(255, 255, 255, 0.08);
            --shadow: 0 10px 30px rgba(255, 255, 255, 0.02);
            --table-header-bg: #232a38;
            --table-row-hover: #2d3748;
            --placeholder-color: #a0aec0;
            --date-warning: #fbbf24;
            --date-danger: #f87171;

            --highlight-new: rgba(16, 185, 129, 0.15);
            --highlight-updated: rgba(59, 130, 246, 0.15);
        }

        body {
            background-color: var(--bg-color) !important;
            color: var(--text-main) !important;
            font-family: system-ui, -apple-system, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .custom-muted {
            color: var(--text-muted) !important;
        }

        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 24px;
            margin-bottom: 30px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .stat-box {
            border-radius: 12px;
            padding: 16px 20px;
            color: white;
            height: 100%;
        }

        .btn-theme {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
        }

        .search-input {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            color: var(--text-main) !important;
            border-radius: 10px !important;
        }

        [data-theme="dark"] .search-input {
            color: #ffffff !important;
        }
        [data-theme="dark"] .search-input::placeholder {
            color: rgba(255, 255, 255, 0.75) !important;
            opacity: 1 !important;
        }

        .form-select {
            background-color: var(--card-bg) !important;
            border: 1px solid var(--card-border) !important;
            color: var(--text-main) !important;
            border-radius: 10px !important;
            transition: background-color 0.3s, color 0.3s;
        }

        [data-theme="dark"] .form-select {
            color: #ffffff !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") !important;
        }
        [data-theme="dark"] .form-select option {
            background-color: #2d3748 !important;
            color: #ffffff !important;
        }

        .table-premium {
            color: var(--text-main) !important;
        }

        .table-premium th {
            background-color: var(--table-header-bg) !important;
            color: var(--text-muted) !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--card-border) !important;
        }

        .table-premium td {
            padding: 16px;
            vertical-align: middle;
            background-color: transparent !important;
            border-bottom: 1px solid var(--card-border) !important;
        }

        .table-premium tbody tr {
            transition: background-color 0.2s;
        }

        .table-premium tbody tr:hover {
            background-color: var(--table-row-hover) !important;
        }

        .row-highlight-new {
            background-color: var(--highlight-new) !important;
        }

        .row-highlight-updated {
            background-color: var(--highlight-updated) !important;
        }

        .card-number-font {
            font-family: monospace;
            font-size: 1.05rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .date-active { color: var(--text-main) !important; }
        [data-theme="dark"] .table-premium td.date-active,
        [data-theme="dark"] .table-premium td.date-active i {
            color: #ffffff !important;
        }

        .date-warning { color: var(--date-warning) !important; font-weight: 600; }
        .date-danger { color: var(--date-danger) !important; font-weight: 600; }

        .pagination .page-link {
            background-color: var(--card-bg) !important;
            border-color: var(--card-border) !important;
            color: var(--text-main) !important;
        }

        .pagination .page-item.active .page-link {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: white !important;
        }

        .pagination .page-item.disabled .page-link {
            opacity: 0.5;
        }

        .pin-badge {
            background-color: var(--bg-color) !important;
            border: 1px solid var(--card-border) !important;
        }

        /* Styl dla okna modala w Dark Mode */
        [data-theme="dark"] .modal-content {
            background-color: var(--card-bg);
            color: var(--text-main);
            border-color: var(--card-border);
        }
        [data-theme="dark"] .modal-header, [data-theme="dark"] .modal-footer {
            border-color: var(--card-border);
        }
    </style>
</head>
<body class="py-5">

    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>

    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded-3" style="width: 45px; height: 45px;">
                    <i class="bi bi-credit-card-2-front-fill fs-4"></i>
                </div>
                <div>
                    <h1 class="fs-3 fw-bold m-0 tracking-tight">BonCard Hub</h1>
                    <p class="custom-muted small m-0">Gift Card Management System</p>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-theme shadow-sm dropdown-toggle d-inline-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle text-primary"></i> {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" aria-labelledby="userMenu" style="background: var(--card-bg);">
                        <li>
                            <button class="dropdown-item d-flex align-items-center gap-2 py-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal" style="color: var(--text-main);">
                                <i class="bi bi-shield-lock text-secondary"></i> Change Password
                            </button>
                        </li>
                        <li><hr class="dropdown-divider" style="opacity: 0.1;"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>

                <button id="themeToggle" class="btn-theme shadow-sm">
                    <i id="themeIcon" class="bi bi-moon"></i> <span id="themeText">Dark Mode</span>
                </button>
            </div>
        </div>

        @if($errors->updatePassword->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> Password update failed. Check your current password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success') || session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') ?: 'Password updated successfully!' }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-box shadow-sm d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-bold">Total Balance</span>
                        <h2 class="fs-1 fw-bold m-0 mt-1">{{ number_format($stats['total_balance'], 2, '.', ' ') }} <span class="fs-5 fw-normal">PLN</span></h2>
                    </div>
                    <i class="bi bi-wallet2 fs-1 text-white-50"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box shadow-sm d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-bold">Total Cards Included</span>
                        <h2 class="fs-1 fw-bold m-0 mt-1">{{ $stats['total_cards'] }} <span class="fs-5 fw-normal">pcs</span></h2>
                        <span class="small text-white-70" style="font-size: 0.85rem;">Active: <strong>{{ $stats['active_cards'] }}</strong></span>
                    </div>
                    <i class="bi bi-card-list fs-1 text-white-50"></i>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-box shadow-sm d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
                    <div>
                        <span class="text-white-50 small text-uppercase fw-bold">Blocked & Expired</span>
                        <h2 class="fs-1 fw-bold m-0 mt-1">{{ $stats['blocked_cards'] + $stats['expired_cards'] }} <span class="fs-5 fw-normal">pcs</span></h2>
                        <span class="small text-white-70" style="font-size: 0.85rem;">Blocked: <strong>{{ $stats['blocked_cards'] }}</strong> | Expired: <strong>{{ $stats['expired_cards'] }}</strong></span>
                    </div>
                    <i class="bi bi-exclamation-octagon fs-1 text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="dashboard-card">
            <form action="{{ url('/') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control search-input" placeholder="Search by card number..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="blocked" {{ request('status') === 'blocked' ? 'selected' : '' }}>Blocked</option>
                    </select>
                </div>
                <div class="col-md-4 class d-flex gap-2 justify-content-md-end">
                    @if(request('search') || request('status'))
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary rounded-3 px-3"><i class="bi bi-x-circle"></i> Clear</a>
                    @endif
                    <a href="{{ url('/cards/create') }}" class="btn btn-primary rounded-3 px-4 fw-medium"><i class="bi bi-plus-lg me-1"></i> Add New Card</a>
                </div>
            </form>
        </div>

        <div class="dashboard-card p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-premium m-0 align-middle">
                    <thead>
                        <tr>
                            <th>Card Number</th>
                            <th class="text-center">PIN</th>
                            <th>Balance</th>
                            <th>Start Date</th>
                            <th>Expiration Date</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cards as $card)
                            @php
                                $now = \Carbon\Carbon::now()->startOfDay();
                                $expiry = \Carbon\Carbon::parse($card->expiration_date)->startOfDay();
                                $daysLeft = (int) $now->diffInDays($expiry, false);

                                $dateClass = 'date-active';
                                if ($daysLeft < 0) {
                                    $dateClass = 'date-danger';
                                } elseif ($daysLeft <= 10) {
                                    $dateClass = 'date-warning';
                                }

                                $rowSessionClass = '';
                                if (session('new_card_id') == $card->id) {
                                    $rowSessionClass = 'row-highlight-new';
                                } elseif (session('updated_card_id') == $card->id) {
                                    $rowSessionClass = 'row-highlight-updated';
                                }
                            @endphp
                            <tr class="{{ $rowSessionClass }}">
                                <td class="card-number-font text-primary">
                                    <a href="{{ url('/cards/'.$card->id) }}" class="text-decoration-none">
                                        <i class="bi bi-credit-card me-1"></i>{{ implode(' ', str_split($card->card_number, 4)) }}
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge pin-badge text-danger font-monospace px-2 py-1">{{ $card->pin }}</span></td>
                                <td class="fw-bold text-success">{{ number_format($card->balance, 2, '.', ' ') }} PLN</td>
                                
                                <td class="date-active">
                                    <i class="bi bi-calendar3 me-1 small"></i>{{ $card->created_at ? \Carbon\Carbon::parse($card->created_at)->format('Y-m-d H:i') : '—' }}
                                </td>

                                <td class="{{ $dateClass }}">
                                    <i class="bi bi-calendar3 me-1 small"></i>{{ \Carbon\Carbon::parse($card->expiration_date)->format('Y-m-d H:i') }}
                                    @if($daysLeft >= 0 && $daysLeft <= 10)
                                        <span class="d-block custom-muted" style="font-size: 0.75rem;">(Expires in {{ $daysLeft }} days!)</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$card->is_active)
                                        <span class="badge bg-secondary px-2.5 py-1.5 small">BLOCKED</span>
                                    @elseif(\Carbon\Carbon::parse($card->expiration_date)->isPast())
                                        <span class="badge bg-danger px-2.5 py-1.5 small">EXPIRED</span>
                                    @else
                                        <span class="badge bg-success px-2.5 py-1.5 small">ACTIVE</span>
                                    @endif
                                </td>
                                <td class="text-end px-3">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ url('/cards/'.$card->id) }}" class="btn btn-sm btn-outline-primary rounded-2" title="View details"><i class="bi bi-eye"></i></a>
                                        <a href="{{ url('/cards/'.$card->id.'/edit') }}" class="btn btn-sm btn-outline-secondary rounded-2" title="Edit"><i class="bi bi-pencil"></i></a>
                                        
                                        <form action="{{ url('/cards/'.$card->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm {{ $card->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} rounded-2" title="{{ $card->is_active ? 'Block Card' : 'Unblock Card' }}">
                                                <i class="bi {{ $card->is_active ? 'bi-shield-slash' : 'bi-shield-check' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ url('/cards/'.$card->id.'/force') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you completely sure you want to permanently delete this card from the database? This action is irreversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="Delete permanently"><i class="bi bi-trash3"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 custom-muted">
                                    <i class="bi bi-credit-card-2-back fs-2 d-block mb-2 text-secondary"></i>
                                    No cards met your filtering criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cards->hasPages())
                <div class="p-3 border-top" style="border-color: var(--card-border) !important;">
                    {{ $cards->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg style-modal" style="border-radius: 16px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="changePasswordModalLabel"><i class="bi bi-key-fill text-primary me-2"></i>Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')
                    <div class="modal-body d-flex flex-column gap-3">
                        <div>
                            <label class="form-label small fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control search-input" required>
                        </div>
                        <div>
                            <label class="form-label small fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control search-input" required>
                        </div>
                        <div>
                            <label class="form-label small fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control search-input" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeText = document.getElementById('themeText');

        function updateButtonUI(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun text-warning';
                themeText.innerText = 'Light Mode';
            } else {
                themeIcon.className = 'bi bi-moon';
                themeText.innerText = 'Dark Mode';
            }
        }

        updateButtonUI(document.documentElement.getAttribute('data-theme'));

        toggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateButtonUI(newTheme);
        });
    </script>
</body>
</html>