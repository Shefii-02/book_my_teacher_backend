<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Payment Success</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="card border-0 shadow-sm rounded-4 mx-auto" style="max-width:700px;">
      <div class="card-body p-4 text-center">
        <h2 class="text-success fw-bold">✅ Payment Successful</h2>
        <p class="text-muted mb-2">Thank you! Your payment has been completed successfully.</p>

        @if(session('tx'))
          <div class="alert alert-success mt-3">
            Transaction ID: <b>{{ session('tx') }}</b>
          </div>
        @endif

        <a href="{{ url('/') }}" class="btn btn-success rounded-4 px-4 mt-2">Go Home</a>
      </div>
    </div>
  </div>
</body>
</html>
