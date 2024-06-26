@extends('layout.main')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #e0e0e0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            gap: 5px; /* Space between the squares */
        }

        .square1 {
            width: 400px;
            height: 500px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .square1 img {
            max-width: 100%;
            max-height: 100%;
        }

        .square2 {
            width: 400px;
            height: 500px;
            background: #d9a52e;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .square2 h1 {
            font-family: "Bebas Neue", sans-serif;
            font-style: normal;
            margin-top: -100px;
            margin-bottom: 20px;
            color: #0a0a0a;
        }

        .square2 h2 {
            font-family: "Bebas Neue", sans-serif;
            font-style: normal;
            color: #0a0a0a;
        }

        .square2 form {
            display: flex;
            flex-direction: column;
            width: 90%;
        }

        .square2 form .input-group {
            margin-bottom: 15px;
        }

        .square2 form .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #0a0a0a;
        }

        .square2 form .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .square2 form button {
            padding: 10px;
            border: none;
            background-color: #446ef2;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .square2 form button:hover {
            background-color: #3df53d;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="square1">
            <a href="#"><img src="{{ asset('img/login.png') }}" alt="Login Image"></a>
        </div>
        <div class="square2">
            <h1>SDJ GADGET HUB</h1>
            <h2>LOGIN</h2>
            <form action="/process/login" method="post">
                @csrf
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">LOGIN</button>
            </form>
            @if (session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</body>
</html>
@endsection
