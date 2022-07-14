<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey= $_ENV['API_KEY'];

$apiUrl = "https://www.litecoinpool.org/api?api_key=".$apiKey;
echo $apiUrl;


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Litecoin Mining Statistic</title>
</head>
<body>
    
</body>
</html>