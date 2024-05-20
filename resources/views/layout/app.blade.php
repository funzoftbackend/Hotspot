<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard Hotspot</title>
    <link rel="shortcut icon" href="{{ asset('/public/Vector.png') }}">
    <link rel="icon" href="{{ asset('/public/Vector.png') }}" type="image/x-icon">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
        }
        .bg,.btn.mb-4{
            background: #C1272D;

        }
        @media(max-width:2000px){
            .mt{
                margin-top:4% !important;
            }
        }
          .container, .container-lg, .container-md, .container-sm, .container-xl {
                max-width: 100%;
              }
            }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img src = "{{asset('/public/Vector.png')}}"></a>
            <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">-->
            <!--    <span class="navbar-toggler-icon"></span>-->
            <!--</button>-->
            
        </div>
    </nav>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
