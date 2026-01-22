<!DOCTYPE html>
<html>
<head>
    <title>Error Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .container {
            padding: 20px;
        }
        .alert {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }
        .info {
            font-size: 16px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="alert">
        <h2>Error Occurred!</h2>
        <p>An internal server error has occurred. Here are the details:</p>
    </div>

    <div class="info">
        <p><strong>Date/Time:</strong> {{ now()->toDayDateTimeString() }}</p>
        <p><strong>Error Message:</strong> {{ $exception->getMessage() }}</p>
        <p><strong>Status Code:</strong> 500</p>
        <p><strong>File:</strong> {{ $exception->getFile() }}</p>
        <p><strong>Line:</strong> {{ $exception->getLine() }}</p>
        <p><strong>URL:</strong> {{ request()->fullUrl() }}</p>
        <p><strong>IP Address:</strong> {{ request()->ip() }}</p>


        <h2>Simplified Stack Trace:</h2>
        @foreach ($stackTrace as $traceLine)
            <p>{{ $traceLine['file'] ?? 'N/A' }}:{{ $traceLine['line'] ?? 'N/A' }} - {{ $traceLine['function'] ?? 'N/A' }}</p>
        @endforeach
    </div>
</div>
</body>
</html>
