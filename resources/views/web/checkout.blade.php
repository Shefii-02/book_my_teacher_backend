<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BookMyTeacher | Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --brand: #4CAF50;
            --brand2: #6ec172;
            --dark: #0f172a;
            --muted: #64748b;
            --border: rgba(15, 23, 42, .10);
        }

        body {
            background: #f6f8ff;
            color: var(--dark);
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        }

        .pay-wrap {
            max-width: 1100px;
            margin: 30px auto;
        }

        .pay-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .06);
        }

        .pay-head {
            background: linear-gradient(135deg, rgba(76, 175, 80, .12), rgba(110, 193, 114, .12));
            border-bottom: 1px solid var(--border);
            padding: 18px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .logo-box {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 900;
        }

        .logo-circle {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            color: #fff;
            font-size: 20px;
        }

        .pay-body {
            padding: 22px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, .14);
            padding: 12px 14px;
        }

        .btn-brand {
            background: linear-gradient(135deg, var(--brand), var(--brand2));
            border: none;
            color: #fff;
            font-weight: 800;
            border-radius: 16px;
            padding: 12px 14px;
        }

        .side-card {
            background: rgba(255, 255, 255, .95);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 18px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .05);
        }

        .pill {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .08);
            background: rgba(15, 23, 42, .03);
            font-weight: 800;
            color: var(--dark);
            font-size: 13px;
        }

        .price-big {
            font-size: 32px;
            font-weight: 900;
            letter-spacing: -0.02em;
            color: var(--brand);
        }

        .list li {
            margin-bottom: 10px;
            font-weight: 600;
            color: #0f172a;
        }

        .list i {
            color: var(--brand);
        }

        .small-muted {
            color: var(--muted);
        }

        .terms {
            background: rgba(15, 23, 42, .03);
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 18px;
            padding: 14px;
        }
    </style>
</head>

<body>

    <div class="pay-wrap">
        <div class="pay-card">
            <div class="pay-head">
                <div class="logo-box">
                    <div class="logo-circle"><i class="bi bi-mortarboard-fill"></i></div>
                    <div>
                        <div class="fw-black">BookMyTeacher</div>
                        <div class="small-muted">Payment Details</div>
                    </div>
                </div>
                <span class="pill"><i class="bi bi-shield-check"></i> Secure PhonePe Payment</span>
            </div>

            <div class="pay-body">
                <div class="row g-4">

                    <!-- LEFT: Payment Form -->
                    <div class="col-lg-6">
                        <h5 class="fw-black mb-3">Payment Details</h5>

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('phonepe.pay') }}">
                            @csrf

                            <!-- PLAN -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold" >Select Plan</label>
                                <select class="form-select" id="planSelect" name="plan" required>
                                    <option value="1year" selected data-price="5999">Standard Plan - 1 Year (₹5,999)
                                    </option>
                                    <option value="2year" data-price="10999">Pro Plan - 2 Years (₹10,999)</option>
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Your full name"
                                    required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="example@gmail.com" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Mobile Number</label>
                                <input type="tel" class="form-control" name="mobile" placeholder="9876543210"
                                    required minlength="10" maxlength="10">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" id="amountInput" value="Auto based on Plan" disabled>
                                </div>
                                <div class="small-muted mt-2">
                                    Amount will be calculated automatically based on your plan selection.
                                </div>
                            </div>

                            <button type="submit" class="btn btn-brand w-100">
                                Pay Now with PhonePe <i class="bi bi-arrow-right ms-1"></i>
                            </button>

                            <div class="small-muted text-center mt-3">
                                By continuing, you agree to our <a href="{{ url('terms-conditions') }}">Terms &
                                    Conditions</a>.
                            </div>
                        </form>
                    </div>

                    <!-- RIGHT: Plan Details -->
                    <div class="col-lg-6">
                        <div class="side-card">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <h5 class="fw-black mb-1">Get Your Own Teaching App</h5>
                                    <div class="small-muted">Recommended for creators & coaching owners.</div>
                                </div>
                                <div class="price-big" id="priceBig">₹5,999/-</div>
                            </div>

                            <hr class="my-3">

                            <div class="fw-black mb-2">What do you get in this Plan?</div>
                            <ul class="list-unstyled list">
                                <li><i class="bi bi-check-circle-fill me-2"></i>Android App</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Website</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Admin Portal</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Recorded Courses</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Live Classes</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Student Enrolments</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>Unlimited Storage</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>A.I. Powered Leads</li>
                                <li><i class="bi bi-check-circle-fill me-2"></i>And Much More</li>
                            </ul>

                            <div class="terms mt-3">
                                <div class="fw-black mb-2">Terms & Conditions</div>
                                <ol class="mb-0 small-muted">
                                    <li>Processing of the app will begin only after successful payment.</li>
                                    <li>Payment amount must match the committed plan amount.</li>
                                    <li>Any incorrect payment may pause the process.</li>
                                    <li>This payment is non-refundable.</li>
                                </ol>
                            </div>

                            <hr class="my-3">

                            <div class="fw-black mb-1">Contact Us</div>
                            <div class="small-muted">
                                <div><i class="bi bi-envelope me-2"></i>support@bookmyteacher.com</div>
                                <div><i class="bi bi-telephone me-2"></i>+91 7510 115544</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        $(document).ready(function() {

          $('body').on('change','#planSelect',function(){
                let selectedOption = $('#planSelect option:selected');
                let price = selectedOption.data('price');
                // Format price with comma
                let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Update fields
                $('#amountInput').val(formattedPrice);
                $('#priceBig').text('₹' + formattedPrice + '/-');
          });
            function updatePrice() {
                let selectedOption = $('#planSelect option:selected');
                let price = selectedOption.data('price');

                // Format price with comma
                let formattedPrice = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Update fields
                $('#amountInput').val(formattedPrice);
                $('#priceBig').text('₹' + formattedPrice + '/-');
            }

            // Initial load
            updatePrice();

            // On plan change
            $('#planSelect').on('change', function() {
                updatePrice();
            });

        });
    </script>

</body>

</html>
