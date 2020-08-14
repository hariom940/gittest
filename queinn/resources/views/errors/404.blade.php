<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <style type="text/css">
        body{
            margin-top: 150px;
            background-color: #C4CCD9;
        }
        .error-main{
            background-color: #fff;
            box-shadow: 0px 10px 10px -10px #5D6572;
            padding: 30px;
        }
        .error-main h1{
            font-weight: bold;
            color: #444444;
            font-size: 100px;
            text-shadow: 2px 4px 5px #6E6E6E;
        }
        .error-main h6{
            color: #42494F;
        }
        .error-main p{
            color: #9897A0;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-md-8 offset-md-2 col-sm-12 error-main">
            <div class="row">
                <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                    <h1 class="m-0">404</h1>
                    <h6>Page not found</h6>
                    <a href="{{ url('/') }}" class="btn btn-danger">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>