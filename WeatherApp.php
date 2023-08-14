<?php 

$weather = "";
$error = "";
if (array_key_exists('submit', $_GET)) {
    // cek jika field kosong
    if (!$_GET['city']) {
        $error = "Sorry, your input field is empty";
    }
    if ($_GET['city']) {
        $apiData = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=". 
        $_GET['city'] ."&APPID=e872d065393af19b4b7448122588fced");
        $weatherArray = json_decode($apiData, true);
        if ($weatherArray['cod'] == 200) {
            // C = K - 273.15
            $tempCelcius = $weatherArray['main']['temp'] - 273.15;
        
            $weather = "<b>" . $weatherArray['name'] . ", " . $weatherArray['sys']['country'] . "<br>" . 
            "<b>Temperature : </b>" . intval($tempCelcius) . "°C" . 
            "<br>" . "<b>Weather Condition : </b>" . $weatherArray['weather'][0]['description'] . 
            "<br>" . "<b>Atmospheric Condition : <b>" . $weatherArray['main']['pressure'] . "hPa" . 
            "<br>" . "<b>Wind Speed : <b>" . $weatherArray['wind']['speed'] . " meter/sec" . 
            "<br>" . "<b>Cloudness : <b>" . $weatherArray['clouds']['all'] . "%";
            date_default_timezone_set('Asia/Jakarta');
            $sunrise = $weatherArray['sys']['sunrise'];
            $weather .= "<br>" . "<b>Sunrise : <b>" . date("g:i a", $sunrise) . 
            "<br>" . "<b>Current Time : <b>" . date("F j, Y, g:i a");
        } else {
            $error = "Couldn't process, your city is not valid";
        }
    } 
}

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.rtl.min.css" integrity="sha384-PRrgQVJ8NNHGieOA1grGdCTIt4h21CzJs6SnWH4YMQ6G5F5+IEzOHz67L4SQaF0o" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Quicksand", sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url("img/pict.jpg");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            color: white;
        }
        .container {
            text-align: center;
            justify-content: center;
            align-items: center;
            width: 440px;
        }
        .btn {
            border-radius: 10px;
        }
        h2 {
            font-weight: 1000;
            margin-top: 150px;
        }
        input {
            width: 200px;
            padding: 5px;
        }
        form {
            margin-top: 10px;
        }
        input[type="text"] {
            width: 85%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            outline: none;
        }
        .alert {
            margin-top: 10px;
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
        }
        .alert-success {
            background-color: rgba(0, 128, 0, 0.8);
            color: white;
            border-radius: 25px;
        }
        .alert-danger {
            background-color: rgba(255, 0, 0, 0.8);
            color: white;
            border-radius: 25px;
        }
        @media (max-width: 768px) {
            .container {
                width: 100%;
            }
        }
    </style>
    <title>Weather App</title>
</head>
<body>
<div class="container">
    <h2>Search Global Weather</h2>
    <form action="" method="get">
        <p><label for="city">Enter your city name</label></p>
        <p><input type="text" name="city" id="city" placeholder="City Name"></p>
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
        <div class="Output">
            <?php 
            if ($weather) {
                echo '<p><div class="alert alert-success" role="alert">
                '. $weather .'
                </div></p>';
            }
            if ($error) {
                echo '<p><div class="alert alert-danger" role="alert">
                '. $error .'
                </div></p>';
            }
            ?>
        </div>
    </form>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
-->
</body>
</html>
