<?php
ini_set("allow_url_fopen", 1);
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = $_ENV['API_KEY'];
$apiUrl = "http://www.litecoinpool.org/api?api_key=" . $apiKey;

$data = file_get_contents($apiUrl);
$data = json_decode($data, true);
// echo $data['user']['hash_rate'];
//print complete object, just echo the variable not work so you need to use print_r to show the result



?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

  <title>Litecoin Mining Statistic</title>
</head>

<body>

  <div class="container">
    <h2 class="text-center">Account Info</h2>
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Current Hashrate</th>
            <th scope="col">Balance</th>
            <th scope="col">24 Hours</th>
            <th scope="col">Paid Rewards</th>
            <th scope="col">Total Rewards</th>
            <th scope="col">Total Work</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo substr($data['user']['hash_rate'], 0, 5); ?> MH/s </td>
            <td><?php echo  substr($data['user']['unpaid_rewards'], 0, 7); ?></td>
            <td><?php echo  substr($data['user']['past_24h_rewards'], 0, 7); ?>&nbsp;Ł</td>
            <td><?php echo  substr($data['user']['paid_rewards'], 0, 7); ?>&nbsp;Ł</td>
            <td><?php echo  substr($data['user']['total_rewards'], 0, 7); ?>&nbsp;Ł</td>
            <td><?php echo  substr($data['user']['total_work'], 0, 5); ?>&nbsp;TH</td>
          </tr>
        </tbody>
      </table>
    </div>
    <h2 class="text-center">My Workers <?php echo $data['pool']['pps_ratio'] . "/" . $data['pool']['pps_ratio']; ?> </h2>
    <div id="accordion">
      <!-- Workers Start -->
    
      <?php 
       $index = 1;
      foreach($data['workers'] as $key => $worker) { ?>
      <div class="card">
        <div class="card-header" id="headingOne">
          <h5 class="mb-0">
            <button class="btn btn-link" 
            data-toggle="collapse" 
            data-target="#<?php echo substr($key,0,-2).$index; ?>" 
            aria-expanded="<?php echo $index == 1 ?  "true" :  "false"; ?>" 
            aria-controls="<?php echo $key; ?>">
            <?php 
              echo $key;  
              echo $worker['connected'] ? "&nbsp;&nbsp;&nbsp;<span class='badge badge-success'>online</span>" : "&nbsp;&nbsp;&nbsp;<span class='badge badge-danger'>offline</span>" ;
              ?> 
            </button>
          </h5>
        </div>

        <div id="<?php echo substr($key,0,-2).$index  ; ?>" class="collapse <?php echo $index == 1 ?  "show" :  ""; ?> " data-parent="#accordion">
          <div class="card-body">
            <table class="table table-hover table-borderless">
                <tr>
                  <td>Hashrate (24h)</td>
                  <td><?php echo substr($worker['hash_rate_24h'], 0, 5); ?> MH/s</td>
                </tr>
                <tr>
                  <td>Rewards</td>
                  <td><?php echo substr($worker['rewards'], 0, 7); ?></td>
                </tr>
                <tr>
                  <td>Rewards (24h)</td>
                  <td><?php echo substr($worker['rewards_24h'], 0, 7); ?> </td>
                </tr>
                <tr>
                  <td>Valid Shares</td>
                  <td><?php echo substr($worker['valid_shares'], 0, 7); echo "&nbsp;(" . bcsub("100",$worker['invalid_shares']) ."%)"  ?> </td>
                </tr>
                <tr>
                  <td>Invalid Shares</td>
                  <td><?php echo $worker['invalid_shares']; echo "&nbsp;(" . $worker['invalid_shares'] ."%)"  ?> </td>
                </tr>
                <tr>
                  <td>Stale Shares</td>
                  <td><?php echo substr($worker['stale_shares'], 0, 7); ?> </td>
                </tr>
            </table>
          </div>
        </div>
      </div>
      <?php $index++;}  ?>
       <!-- Workers End -->
    </div>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>
    -->
</body>

</html>