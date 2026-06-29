<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BonCard Hub - Edit Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-color: #f4f7f6;
            --text-main: #2d3748;
            --text-muted: #718096;
            --card-bg: #ffffff;
            --card-border: rgba(0, 0, 0, 0.05);
            --shadow: 0 15px 35px rgba(0, 0, 0, 0.04);
            --input-bg: #ffffff;
            --input-border: #cbd5e1;
            --placeholder-color: #94a3b8;
            
            --card-preview-bg: linear-gradient(135deg, #6366f1 0%, #3b82f6 50%, #1d4ed8 100%);
            --card-preview-text: #ffffff;
            --card-preview-muted: rgba(255, 255, 255, 0.7);
            --card-chip: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        [data-theme="dark"] {
            --bg-color: #1a202c;
            --text-main: #ffffff;
            --text-muted: #cbd5e1;
            --card-bg: #2d3748;
            --card-border: rgba(255, 255, 255, 0.08);
            --shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            --input-bg: #1e293b;
            --input-border: #475569;
            --placeholder-color: #64748b;

            --card-preview-bg: linear-gradient(135deg, #4f46e5 0%, #2563eb 60%, #1e40af 100%);
            --card-chip: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        body {
            background-color: var(--bg-color) !important;
            color: var(--text-main) !important;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            transition: background-color 0.3s, color 0.3s;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .custom-muted {
            color: var(--text-muted) !important;
        }

        .main-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 40px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .card-preview {
            background: var(--card-preview-bg);
            color: var(--card-preview-text);
            border-radius: 22px;
            padding: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(37, 99, 235, 0.25);
            aspect-ratio: 1.586 / 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .card-preview::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .card-chip {
            width: 50px;
            height: 38px;
            background: var(--card-chip);
            border-radius: 8px;
            position: relative;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .card-chip::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            background-image: linear-gradient(90deg, transparent 24%, rgba(0,0,0,0.05) 25%, rgba(0,0,0,0.05) 26%, transparent 27%, transparent 49%, rgba(0,0,0,0.05) 50%, rgba(0,0,0,0.05) 51%, transparent 52%);
        }

        .card-preview-number {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            word-spacing: 2px;
            margin: 20px 0 10px 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 12px;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.05);
            white-space: nowrap;
        }

        .card-preview-label {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--card-preview-muted);
            margin-bottom: 2px;
            font-weight: 600;
        }

        .card-preview-value {
            font-family: 'JetBrains Mono', monospace;
            font-size: 1rem;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .card-preview-footer-box {
            background: rgba(0, 0, 0, 0.12);
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 8px;
            color: var(--text-main);
        }

        .form-control {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: var(--text-main) !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
            font-size: 0.95rem !important;
            transition: all 0.2s ease-in-out !important;
        }

        .form-control::placeholder {
            color: var(--placeholder-color) !important;
            opacity: 1;
        }

        .form-control:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15) !important;
        }

        .input-group-text {
            background-color: var(--input-bg) !important;
            border: 1px solid var(--input-border) !important;
            color: #6366f1 !important;
            border-radius: 12px 0 0 12px !important;
            padding-left: 16px;
            padding-right: 16px;
            font-weight: bold;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0 !important;
        }

        .input-counter-container {
            position: relative;
        }

        .input-counter-badge {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 6px;
            background-color: var(--bg-color);
            color: var(--text-muted);
            border: 1px solid var(--card-border);
            pointer-events: none;
            transition: all 0.2s ease;
        }

        .counter-filled {
            background-color: rgba(16, 185, 129, 0.1) !important;
            color: #10b981 !important;
            border-color: rgba(16, 185, 129, 0.2) !important;
        }

        .counter-invalid {
            background-color: rgba(239, 68, 68, 0.1) !important;
            color: #ef4444 !important;
            border-color: rgba(239, 68, 68, 0.2) !important;
        }

        .btn-theme {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-main);
            border-radius: 12px;
            padding: 10px 16px;
            font-weight: 500;
        }

        .btn-action {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .border-end-lg {
            border-right: 1px solid var(--card-border);
        }

        @media (max-width: 991px) {
            .border-end-lg {
                border-right: none;
                border-bottom: 1px solid var(--card-border);
                padding-bottom: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ url('/') }}" class="text-decoration-none custom-muted fw-medium d-inline-flex align-items-center gap-2">
                        <i class="bi bi-arrow-left fs-5 text-primary"></i> Back to Dashboard
                    </a>
                    <button id="themeToggle" class="btn-theme shadow-sm">
                        <i id="themeIcon" class="bi bi-moon"></i> <span id="themeText">Dark Mode</span>
                    </button>
                </div>

                <div class="main-card">
                    <div class="row g-5">
                        
                        <div class="col-lg-5 d-flex flex-column justify-content-center border-end-lg">
                            <div class="mb-4">
                                <h3 class="fw-bold m-0 tracking-tight">Live Card Preview</h3>
                                <p class="custom-muted small">See adjustments updated in real-time</p>
                            </div>
                            
                            <div class="card-preview">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="card-chip"></div>
                                    <i class="bi bi-credit-card-2-front-fill fs-2 text-white-50"></i>
                                </div>
                                
                                <div class="text-center">
                                    <div id="previewCardNumber" class="card-preview-number">0000 0000 0000 0000 0000</div>
                                </div>
                                
                                <div class="card-preview-footer-box">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <div class="card-preview-label">Card PIN</div>
                                            <div id="previewPIN" class="card-preview-value text-warning">••••</div>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="card-preview-label">Balance</div>
                                            <div id="previewBalance" class="card-preview-value text-white">0.00 PLN</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-7">
                            <div class="mb-4">
                                <h2 class="fw-bold m-0 tracking-tight text-primary">Edit Gift Card Parameters</h2>
                                <p class="custom-muted small">Update specific settings, dates or balance for the selected card</p>
                            </div>

                            @if($errors->any())
                                <div class="alert alert-danger rounded-3 p-3 mb-4">
                                    <ul class="m-0 ps-3 small">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form id="giftCardForm" action="{{ url('/cards/' . $card->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" id="card_number_hidden" name="card_number" value="{{ old('card_number', $card->card_number) }}">

                                <div class="mb-4">
                                    <label for="card_number_input" class="form-label">Card Number</label>
                                    <div class="input-counter-container">
                                        <input type="text" class="form-control font-monospace" id="card_number_input" placeholder="0000 0000 0000 0000 0000" autocomplete="off" value="{{ old('card_number', $card->card_number) }}">
                                        <span id="cardCounter" class="input-counter-badge">0 / 20</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="pin" class="form-label">PIN Code</label>
                                        <div class="input-counter-container">
                                            <input type="text" class="form-control font-monospace text-center" id="pin" name="pin" maxlength="4" placeholder="0000" autocomplete="off" value="{{ old('pin', $card->pin) }}">
                                            <span id="pinCounter" class="input-counter-badge">0 / 4</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="balance" class="form-label">Current Balance</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-currency-exchange"></i></span>
                                            <input type="number" step="0.01" min="0" class="form-control fw-bold text-success" id="balance" name="balance" placeholder="0.00" value="{{ old('balance', $card->balance) }}" onblur="if(this.value) this.value = parseFloat(this.value).toFixed(2);">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="activation_date" class="form-label">Activation Date & Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                                            <input type="datetime-local" class="form-control" id="activation_date" name="activation_date" value="{{ old('activation_date', $card->activation_date ? date('Y-m-d\TH:i', strtotime($card->activation_date)) : '') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label for="expiration_date" class="form-label">Expiration Date & Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-clock-history"></i></span>
                                            <input type="datetime-local" class="form-control" id="expiration_date" name="expiration_date" value="{{ old('expiration_date', $card->expiration_date ? date('Y-m-d\TH:i', strtotime($card->expiration_date)) : '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 justify-content-end mt-5 pt-3 border-top" style="border-color: var(--card-border) !important;">
                                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-action"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                                    <button type="submit" class="btn btn-primary btn-action px-4 shadow-sm"><i class="bi bi-check-circle me-1"></i> Update Card Details</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cardInput = document.getElementById('card_number_input');
        const cardHidden = document.getElementById('card_number_hidden');
        const cardCounter = document.getElementById('cardCounter');
        const previewCardNumber = document.getElementById('previewCardNumber');

        const pinInput = document.getElementById('pin');
        const pinCounter = document.getElementById('pinCounter');
        const previewPIN = document.getElementById('previewPIN');

        const balanceInput = document.getElementById('balance');
        const previewBalance = document.getElementById('previewBalance');

        function handleCardInput(value) {
            let clean = value.replace(/\D/g, '');
            if (clean.length > 20) {
                clean = clean.substring(0, 20);
            }
            
            let chunks = [];
            for (let i = 0; i < clean.length; i += 4) {
                chunks.push(clean.substring(i, i + 4));
            }
            
            cardInput.value = chunks.join(' ');
            cardHidden.value = clean;

            cardCounter.textContent = `${clean.length} / 20`;
            if (clean.length === 20) {
                cardCounter.className = 'input-counter-badge counter-filled';
            } else if (clean.length > 0) {
                cardCounter.className = 'input-counter-badge counter-invalid';
            } else {
                cardCounter.className = 'input-counter-badge';
            }

            if (clean.length < 20) {
                let combined = clean + '0'.repeat(20 - clean.length);
                let finalChunks = [];
                for(let i=0; i<20; i+=4) {
                    finalChunks.push(combined.substring(i, i+4));
                }
                previewCardNumber.textContent = finalChunks.join(' ');
            } else {
                previewCardNumber.textContent = chunks.join(' ');
            }
        }

        cardInput.addEventListener('input', (e) => {
            handleCardInput(e.target.value);
        });

        if(cardInput.value) {
            handleCardInput(cardInput.value);
        }

        function handlePinInput(value) {
            value = value.replace(/\D/g, '');
            if (value.length > 4) value = value.substring(0, 4);
            
            previewPIN.textContent = value.length > 0 ? value : '••••';
            pinCounter.textContent = `${value.length} / 4`;
            
            if (value.length === 4) {
                pinCounter.className = 'input-counter-badge counter-filled';
            } else if (value.length > 0) {
                pinCounter.className = 'input-counter-badge counter-invalid';
            } else {
                pinCounter.className = 'input-counter-badge';
            }
            
            return value;
        }

        pinInput.addEventListener('input', (e) => {
            e.target.value = handlePinInput(e.target.value);
        });

        if(pinInput.value) pinInput.value = handlePinInput(pinInput.value);

        function handleBalanceInput(value) {
            if (value.includes('.')) {
                const parts = value.split('.');
                if (parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                    balanceInput.value = value;
                }
            }

            let num = parseFloat(value);
            if (!isNaN(num)) {
                previewBalance.textContent = num.toLocaleString('pl-PL', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' PLN';
            } else {
                previewBalance.textContent = '0.00 PLN';
            }
        }
        balanceInput.addEventListener('input', (e) => handleBalanceInput(e.target.value));
        if(balanceInput.value) handleBalanceInput(balanceInput.value);

        document.getElementById('giftCardForm').addEventListener('submit', () => {
            cardHidden.value = cardInput.value.replace(/\s+/g, '');
        });

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
            const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            updateButtonUI(next);
        });
    </script>
</body>
</html>