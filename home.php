<?php
require 'auth.php'; 
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="home.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  
    <title> NewsExperst</title>
</head>
<body> 
<div class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="navbar-header">
                        <button class="navbar-toggle" data-target="#mobile_menu" data-toggle="collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                        <a href="/home/world" class="navbar-brand">NewsExperst.COM</a>
                    </div>

                    <div class="navbar-collapse collapse" id="mobile_menu">
                        <ul class="nav navbar-nav">
                            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">About Us <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">About One</a></li>
                                    <li><a href="#">About Two</a></li>
                                    <li><a href="#">About Three</a></li>
                                    <li><a href="#">About Four</a></li>
                                    <li><a href="#">About Five</a></li>
                                    <li><a href="#">About Six</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Welcome</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                        <ul class="nav navbar-nav">
                            <li>
                                <form method="post" action="/home/news/" class="navbar-form">
                                    {% csrf_token%}
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="search" name="search_term"  placeholder="Search Anything Here..." class="form-control">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-search"></span></span>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="/profile"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
                            <li><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in"></span> Login / Logout <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/profile/login">Login</a></li>
                                    <li><a href="/profile/logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class='upper-section'>

        <div class="user-information-section">

            <?php
            echo '<div>';
            echo '<h2> Weclome admin </h2>';
            echo '<p>Username: ' . $_SESSION["username"] . '</p>';
            echo '<p>Email: ' . $_SESSION["email"] . '</p>';
            ?>
        </div>
    </div>


        <div class="weather-information-section">
            <div class="current-weather"> 
                <?php
    $base_url='http://api.weatherapi.com/v1/current.json';
    $weather_api_key='ab2af2712b7a4f3b82b175311241112';
    //srtting the parameters for the api 

    $params=[ 
        'q'=>'Mostaganem',
        'key'=>$weather_api_key,
    ];
    $url = $base_url . '?' . http_build_query($params);
    $ch = curl_init($url);

    // setting the curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        die("cURL Error: " . $error); 
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {

        $data = json_decode($response, true);
        
        if ($data !== null) {
            if (isset($data['current'])) {
                $current=$data['current'];

                echo '<div>';

                echo '<h3> Current Weather </h3>';
                    echo "<p>Tempeeure: {$current['temp_c']}</p>";

                    echo "<p> Description{$current['condition']['text']}</p>";

                    echo "<p> Wind-kph{$current['wind_kph']}</p>";

                echo '</div>';
              
                echo "<img src=\"{$current['condition']['icon']}\"  class=\"weather_icon\"> ";

                }

            } else {
                echo "No weather informatino found in the response.\n";
                if (isset($data['message'])) {
                    echo "API Error Message: " . $data['message'] . "\n";
                }
            }
        }
    else{
        echo "API request failed with  code: " . $httpCode . "\n";
        }
?>
            </div>
            <div class="weather-forcast"> 
                <div >
                    <?php
    $forecast_url = "http://api.weatherapi.com/v1/forecast.json";

    //srtting the parameters for the api 
    $params=[ 
        'q'=>'Mostaganem',
        'key'=>$weather_api_key,
        'day'=>1,
    ];
    $url = $forecast_url . '?' . http_build_query($params);
    $ch = curl_init($url);

    // setting the curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        die("cURL Error: " . $error); 
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {

        $data = json_decode($response, true);
        
        if ($data !== null) {
            $forecast=$data['forecast']['forecastday'][0]['day'];
            if (isset($forecast)) {


                echo '<h3>  Weather Forecast </h3>';

                    echo "<p>Max Temp: {$forecast['maxtemp_c']}</p>";

                    echo "<p> Min Temp{$forecast['mintemp_c']}</p>";

                    echo "<p> Avg Temp{$forecast['avgtemp_c']}</p>";

                    if ($forecast['daily_will_it_rain']){
                        echo '<p>will it rain : YES </p>';
                    }
                    else{
                        echo '<p>will it rain : NO </p>';        
                    }

                echo '</div>';
              
                echo "<img src=\"{$forecast['condition']['icon']}\"  class=\"weather_icon\"> ";

                echo'</div>';

                }

            } else {
                echo "No articles found in the response.\n";
                if (isset($data['message'])) {
                    echo "API Error Message: " . $data['message'] . "\n";
                }
            }
        }
    else{
        echo "API request failed with  code: " . $httpCode . "\n";
        }
        ?>

                </div>
        </div>

    <div class="lower-section">
        <div class="news-section">
            <div class="top-news-section">
                <h1>NEWS</h1>
                <div class="catigories">
                    <ul style=" display:flex">
                        <li> <a href="/home/Sports">Sports</a>  </li>
                        <li> <a href='/home/Economy'>Economy</a> </li>
                        <li> <a href="/home/Opinion">Opinion</a> </li>
                        <li> <a href="/home/Space/">Space </a> </li>
                    </ul>
                </div>
            </div>


        <?php
    
        $base_url='https://newsapi.org/v2/everything';
        $api_key='10f52cca4c424851ae09f32027b3b908';
        //srtting the parameters for the api 
        $params=[ 
            'q'=>'News',
            'from'=>'2025-01-01',
            'sortBy'=>'popularity',
            'apiKey'=>$api_key,
        ];
        $url = $base_url . '?' . http_build_query($params);
        $ch = curl_init($url);

        // setting the curl options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            die("cURL Error: " . $error); 
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {

            $data = json_decode($response, true);
            
            if ($data !== null) {
                if (isset($data['articles']) && is_array($data['articles'])) {
                    foreach ($data['articles'] as $article) {
                        if ($article['urlToImage']){ 
                            echo '<div class="articale">';

                            echo "<img src=\"{$article['urlToImage']}\"  class=\"news-image\"> ";
        
        
                            echo '<div>';
                                echo "<a href=\"{$article['url']}\" class=\"news-title\">{$article['title']}</a>";
        
                                echo "<p  class=\"news-summury\">{$article['description']}</p>";
        
                                echo "<p  class=\"pub-date\">{$article['publishedAt']}</p>";
        
                            echo '</div>';
        
                            echo '</div>';
                        }

                    }
                } else {
                    echo "No articles found in the response.\n";
                    if (isset($data['message'])) {
                        echo "API Error Message: " . $data['message'] . "\n";
                    }
                }
            }
        }
        else{
            echo "API request failed with  code: " . $httpCode . "\n";
            }
    ?>
        </div>
        <div class="event-section">
            <div class="top-event-section"><h1>TOP NEWS</h1></div>
            <?php
    
    $base_url='https://newsapi.org/v2/top-headlines';

    //srtting the parameters for the api 
    $url = $base_url . '?' . http_build_query($params);
    $ch = curl_init($url);

    // setting the curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        curl_close($ch);
        die("cURL Error: " . $error); 
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {

        $data = json_decode($response, true);
        
        if ($data !== null) {
            if (isset($data['articles']) && is_array($data['articles'])) {
                foreach ($data['articles'] as $article) {
                echo '<div class="top-news">';

                echo "<img src=\"{$article['urlToImage']}\"  class=\"top-news-image\"> ";

                echo '<div>';
                    echo "<a href=\"{$article['url']}\" class=\"top-news-title\">{$article['title']}</a>";

                    echo "<p  class=\"news-summury\">{$article['description']}</p>";

                    echo "<p  class=\"pub-date\">{$article['publishedAt']}</p>";

                echo '</div>';

                echo '</div>';
                }
            } else {
                echo "No headlines found in the response.\n";
                if (isset($data['message'])) {
                    echo "API Error Message: " . $data['message'] . "\n";
                }
            }
        }
    }
    else{
        echo "API request failed with  code: " . $httpCode . "\n";
        }
?>
        </div>
    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</html>