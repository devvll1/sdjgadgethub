@extends('layout.main')

@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            gap: 0px; /* space between squares */
        }

        .square1 {
            width: 400px;
            height: 500px;
            background-color: blue;
            opacity: 0.5;
        }
        .square2 {
            width: 400px;
            height: 500px;
            background-color: yellow;
            opacity: 0.5;
        }
    </style>
<body>

    <div class="container">
        <div class="square1"></div>
        <div class="square2"></div>
    </div>
</body>
@endsection  