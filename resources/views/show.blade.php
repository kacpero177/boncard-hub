<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonCard Hub - Card Details & History</title>
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
            --timeline-line: rgba(0, 0, 0, 0.05);
            --timeline-content-bg: #f8fafc;
        }

        [data-theme="dark"] {
            --bg-color: #1a202c;
            --text-main: #edf2f7;
            --text-muted: #cbd5e1;
            --card-bg: #2d3748;
            --card-border: rgba(255, 255, 255, 0.08);
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            --timeline-line: rgba(255, 255, 255, 0.1);
            --timeline-content-bg: #1e293b;
        }

        body {
            background-color: var(--bg-color) !important;
            color: var(--text-main) !important;
            transition: background-color 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .custom-muted {
            color: var(--text-muted) !important;
        }

        .main-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: var(--shadow);
            padding: 30px;
            margin-bottom: 30px;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background: var(--timeline-line);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #6366f1;
            border: 3px solid var(--card-bg);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .timeline-content {
            background: var(--timeline-content-bg);
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid var(--card-border);
        }

        .btn-theme {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 10px;
            padding: 8px 14px;
        }

        .badge-active { background-color: rgba(16, 185, 129, 0.15); color: #10b981; }
        .badge-blocked { background-color: rgba(239, 68, 68, 0.15); color: #ef4444; }
        .badge-expired { background-color: rgba(245, 158, 11, 0.15); color: #f59e0b; }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ url('/') }}" class="text-decoration-none custom-muted fw-medium d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-left fs-5 text-primary"></i> Back to Dashboard
            </a>
            <button id="themeToggle" class="btn-theme shadow-sm">
                <i id="themeIcon" class="bi bi-moon"></i> <span id="themeText">Dark Mode</span>
            </button>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="main-card">
                    <h4 class="fw-bold mb-4">Card Metadata</h4>
                    
                    <div class="mb-3">
                        <label class="small custom-muted d-block">Card Number</label>
                        <span class="font-monospace fw-bold fs-5">{{ implode(' ', str_split($card->card_number, 4)) }}</span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small custom-muted d-block">PIN Code</label>
                            <span class="font-monospace fw-bold text-warning">{{ $card->pin }}</span>
                        </div>
                        <div class="col-6">
                            <label class="small custom-muted d-block">Status</label>
                            @php
                                $isExpired = \Carbon\Carbon::parse($card->expiration_date)->isPast();
                            @endphp
                            @if(!$card->is_active)
                                <span class="badge badge-blocked px-2 py-1 rounded">Blocked</span>
                            @elseif($isExpired)
                                <span class="badge badge-expired px-2 py-1 rounded">Expired</span>
                            @else
                                <span class="badge badge-active px-2 py-1 rounded">Active</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small custom-muted d-block">Current Balance</label>
                        <span class="fw-bold fs-4 text-success">{{ number_format($card->balance, 2, '.', ' ') }} PLN</span>
                    </div>

                    <hr style="border-color: var(--card-border);">

                    <div class="mb-3">
                        <label class="small custom-muted d-block">Activation Timestamp</label>
                        <span class="small fw-semibold">{{ $card->activation_date }}</span>
                    </div>

                    <div class="mb-4">
                        <label class="small custom-muted d-block">Expiration Timestamp</label>
                        <span class="small fw-semibold text-danger">{{ $card->expiration_date }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ url('/cards/' . $card->id . '/edit') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil-square me-1"></i> Edit Details</a>
                        
                        <form action="{{ url('/cards/' . $card->id . '/force') }}" method="POST" onsubmit="return confirm('CRITICAL WARNING: Are you absolutely sure you want to permanently delete this card and its entire transaction history? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100"><i class="bi bi-trash3-fill me-1"></i> Delete Card</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="main-card">
                    <h4 class="fw-bold mb-4">System Timeline & Audit Trail</h4>

                    @if(count($transactions) > 0)
                        <div class="timeline">
                            @foreach($transactions as $transaction)
                                @php
                                    // Dzielimy opis na części używając znaku "|"
                                    $parts = explode('|', $transaction->description);
                                    $title = $parts[0]; // Pierwsza linia to zawsze tytuł operacji
                                @endphp
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold m-0 text-primary">{{ $title }}</h6>
                                            <span class="small font-monospace custom-muted ms-2" style="white-space: nowrap;">{{ $transaction->created_at }}</span>
                                        </div>
                                        
                                        {{-- Jeśli istnieją dodatkowe szczegóły edycji, wyświetlamy je jako ładną listę (Teraz bezpiecznie escapowaną) --}}
                                        @if(count($parts) > 1)
                                            <ul class="list-unstyled ps-2 mb-3 border-start border-2 border-secondary small custom-muted">
                                                @for($i = 1; $i < count($parts); $i++)
                                                    <li class="mb-1">&bull; {{ $parts[$i] }}</li>
                                                @endfor
                                            </ul>
                                        @endif

                                        <div class="small mt-1 pt-1 border-top" style="border-color: rgba(0,0,0,0.03) !important;">
                                            @if($transaction->amount > 0)
                                                Impact: <span class="text-success fw-bold">+{{ number_format($transaction->amount, 2) }} PLN</span>
                                            @elseif($transaction->amount < 0)
                                                Impact: <span class="text-danger fw-bold">{{ number_format($transaction->amount, 2) }} PLN</span>
                                            @else
                                                Impact: <span class="custom-muted fw-bold">None (Status Event)</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 custom-muted">
                            <i class="bi bi-exclamation-circle fs-2 d-block mb-2"></i> No transactions or system changes registered for this card.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const themeText = document.getElementById('themeText');

        function updateButtonUI(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun text-warning';
                themeText.innerText = 'Light Mode';
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                themeIcon.className = 'bi bi-moon';
                themeText.innerText = 'Dark Mode';
                document.documentElement.setAttribute('data-theme', 'light');
            }
        }

        updateButtonUI(localStorage.getItem('theme') || 'light');

        toggleBtn.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', newTheme);
            updateButtonUI(newTheme);
        });
    </script>
</body>
</html>