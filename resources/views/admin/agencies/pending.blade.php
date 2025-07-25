<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paid Agencies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0a192f, #172a45);
            color: #ccd6f6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        .card {
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }
        .card-header {
            background: linear-gradient(135deg, #64ffda, #00bcd4);
            color: #0a192f;
            border-radius: 15px 15px 0 0;
            padding: 15px;
            font-size: 1.25rem;
            font-weight: bold;
            text-align: center;
        }
        .agency-list {
            list-style-type: none;
            padding: 0;
        }
        .agency-list li {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background 0.3s ease;
        }
        .agency-list li:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #64ffda, #00bcd4);
            color: #0a192f;
        }
        .btn-primary:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 10px rgba(100, 255, 218, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4" style="color: #64ffda;">Paid Agencies</h1>

        <!-- Display inactive agencies -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-building me-2"></i>Agencies Pending Activation
            </div>
            <div class="card-body">
                @if($pendingAgencies->count() > 0)
                    <ul class="agency-list">
                        @foreach($pendingAgencies as $agency)
                            <li>
                                <span>{{ $agency->name_agency }}</span>
                                <form action="{{ route('admin.agencies.activateSubscription', $agency->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Activate Subscription</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center">No agencies pending activation.</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>