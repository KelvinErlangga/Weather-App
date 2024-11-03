<?php

$weather = "";
$error = "";
$kota = "";
error_reporting(0);

if (array_key_exists('submit', $_GET)) {
    // Check if the field is empty
    if (!$_GET['city']) {
        $error = "Field Tidak Boleh Kosong";
    } else {
        $city = urlencode($_GET['city']); // Encode city name to handle spaces and special characters

        // Initialize cURL
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.openweathermap.org/data/2.5/weather?q=" . $city . "&APPID=e872d065393af19b4b7448122588fced",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 10, // Set a timeout of 10 seconds
            CURLOPT_CONNECTTIMEOUT => 5, // Set a connection timeout of 5 seconds
        ]);

        $apiData = curl_exec($curl);
        if ($apiData === FALSE) {
            $error = "Failed to fetch data from API. Error: " . curl_error($curl);
        } else {
            $weatherArray = json_decode($apiData, true);
            if ($weatherArray['cod'] == 200) {
                // C = K - 273.15
                date_default_timezone_set('Asia/Jakarta');
                $tempCelcius = $weatherArray['main']['temp'] - 273.15;
                $currentDate = "<p>" . date("j F Y") . "</p>";
                $Time = "<p>" . date("g:i a") . "</p>";
                $weather =
                    "<div class='container-display'>" .
                    "<div class='card-header'>" .
                    "<h4>" . $weatherArray['name'] . ", " . $weatherArray['sys']['country'] . "</h4>" .
                    "<div class='flex-colom'>" .
                    "<p>" . $currentDate . "</p>" .
                    "<p class='time'>" . $Time . "</p>" .
                    "</div>" .
                    "</div>" .
                    "<h1>" . intval($tempCelcius) . "°</h1>" .
                    "<p>" .  $weatherArray['weather'][0]['description'] . "</p>";

                $sunrise = $weatherArray['sys']['sunrise'];
                $weather .= "<h5>" . "Sunrise : " . date("g:i a", $sunrise) . "</h5>";
                $weather .= "</div>";
            } else {
                $kota = "Nama Kota Tidak Valid.";
            }
        }
        curl_close($curl);
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
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="path_ke_font_awesome/css/all.min.css">
    <title>Weather App</title>
</head>

<body>

    <div class="container">
        <h2 class="animate__animated animate__fadeInDown">Search Global Weather</h2>
        <label class="animate__animated animate__fadeInDown" for="city">Masukkan kota kamu</label>
        <form action="" method="get">
            <div class="rowocon">
                <div class="input-col">
                    <input type="text" name="city" id="city" placeholder="Masukkan daerah anda">
                    <?php
                    if ($error) {
                        echo '<div class="alert" role="alert">' . $error . '</div>';
                    }
                    if ($kota) {
                        echo '<div class="alert" role="alert">' . $kota . '</div>';
                    }
                    ?>
                </div>
                <button type="submit" name="submit" class="btn btn-success">Submit</button>
            </div>
            <div class="output mt-4">
                <?php
                if ($weather) {
                    echo '<div role="alert">' . $weather . '</div>';
                }
                ?>
            </div>
        </form>
    </div>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>