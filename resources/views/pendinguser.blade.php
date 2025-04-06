<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AssignPro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .container {
        max-width: 800px;
        min-width: 450px;

            margin: 5px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .user-info p {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .user-info {
            background-color: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .no-user {
            color: #e74c3c;
            text-align: center;
            font-size: 18px;
        }

        .btn-back {
            display: block;
            width: 100%;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
        }
        .btn-back a{
        }

        .btn-back:hover {
            background-color: #2980b9;
            color: #ecf0f1;
        }
    </style>
</head>

<body>

    <div class="container w-75">
        @if($user)
        <h1>an admin will look at your request</h1>
        <h3 class="text-center">User Information</h3>
        <div class="user-info">
            <p><strong>First Name:</strong> {{ $user['firstname'] }}</p>
            <p><strong>Last Name:</strong> {{ $user['lastname'] }}</p>
            <p><strong>Email:</strong> {{ $user['email'] }}</p>
        </div>
        @else
        <p class="no-user">No user data available.</p>
        <a href="{{ route('pendinguser') }}" class="btn-back">Back to Pending Users</a>
        @endif
        <a href="{{ url('/') }}" class="btn-back">Back</a>
    </div>

</body>

</html>
