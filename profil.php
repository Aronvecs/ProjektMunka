<?php
                        
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/users/".$_GET["name"]);
    $output = curl_exec($ch);
    $UserData = json_decode($output, true);       
    curl_close ($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Mylist/".$UserData[0]["username"]);
    $output = curl_exec($ch);
    $allGames = json_decode($output, true);
    curl_close ($ch);


    function MeanScore($allGames)
    {

      if (!empty($allGames)) {

      $numScore = 0;
      $sumScore = 0;
      
        for ($i=0; $i < count($allGames); $i++)
        { 
          if ($allGames[$i]["rating"] != 0)
          {
            $sumScore += $allGames[$i]["rating"];
            $numScore++;
          }
        }


      return number_format((float)($sumScore/$numScore), 2, '.', '');
      }
      else{
        
        return "No rated games yet";
      }
    }

    function GameCount($UserData, $status)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Mylist/".$UserData[0]["username"]."/".$status);
      $output = curl_exec($ch);
      $gamesByStatus = json_decode($output, true);
      curl_close ($ch);

      if (!empty($gamesByStatus))
      {
        return Count($gamesByStatus);
      }
      else
      {
        return 0;
      }

    }

    function NumOfGivenScore($allGames, $rating)
    {
      if (!empty($allGames))
      {
        $NumOfRating = 0;
        for ($i=0; $i < Count($allGames); $i++) 
        { 
          if($rating == $allGames[$i]["rating"])
          {
          $NumOfRating++;
          }
        }              
        return $NumOfRating;
      }
      else
      {
        return 0;
      }
    }

    if(empty($UserData))
    {
      header("Location: 404.php");
    }

    function GameData($allGames, $gameId)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Game/GameData/".$gameId);
      $output = curl_exec($ch);
      $gameDataById = json_decode($output, true);
      curl_close ($ch);

      return $gameDataById;
    }

    function FavoriteGame($UserData)
    {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,"http://rest-api.com/Favorite/".$UserData[0]['email']);
      $output = curl_exec($ch);
      $favoriteGame = json_decode($output, true);
      curl_close ($ch);

      return $favoriteGame;
    }


    include("sablon/sablon.php");
?>
  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
	  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/profil.css">
    <title>Document</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Rating', 'Number of ratings'],
          <?php
            for ($i=1; $i <= 10; $i++) { 
              echo("['".$i."',".NumOfGivenScore($allGames, $i)."],");
            }
            ?>
        ]);

        var options = {
          backgroundColor: { fill:'transparent' },
          titleTextStyle: { color: "white"},
          chartArea:{left:20,bottom:100,width:'100%',height:'100%'},
          legend:{position: 'right', textStyle: {color: 'white', fontSize: 18}},
          colors:['darkred','darkblue', 'darkmagenta', 'darkgreen', 'goldenrod', 'darkorange', 'green', 'purple', 'blue', 'brown']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }



      google.charts.load('current', {packages: ['corechart', 'bar']});
      google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {

            var data = google.visualization.arrayToDataTable([
              ['Status', 'Completed', 'Playing', 'On hold', 'Dropped', 'Plan to play'],
              ['Status', <?php echo(GameCount($UserData, "completed"))?>, <?php echo(GameCount($UserData, "playing"))?>, <?php echo(GameCount($UserData, "on%20hold"))?>, <?php echo(GameCount($UserData, "dropped"))?>, <?php echo(GameCount($UserData, "plan%20to%20play"))?>]
            ]);
            

            var options = {
              backgroundColor: { fill:'transparent' },
              chartArea: {width: '100%'},
              colors: ['darkblue','green', 'goldenrod', 'red', 'gray'],
              isStacked: 'percent',
                height: 100,
                width: 300,
                legend: {position: 'none'},
                hAxis: { ticks: [] }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

            chart.draw(data, options);
          }
    </script>
</head>
    <body class="body">
<div class="container">
    <div class="main-body">
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                  <img src="/images/user/<?php echo $UserData[0]["profile_picture"];?>" alt="" class=profilkep>
                    <div class="mt-3">
                      <?php
                    ?>
                      <h4><p class = "profilnev"> <?php echo $_GET["name"]?> </p></h4>
                      <?php if ($UserData[0]["birth_date"] != "0000-00-00")
                      {
                        echo("<p class = 'birthdate'>Birth date: ".$UserData[0]["birth_date"]."</p>");
                      } ?>
                      <?php if ($UserData[0]["gender"] != "0")
                      {
                        $gender = $UserData[0]["gender"];
                        
                        if($gender == 1)
                        {
                          echo("<p class = 'gender'>Gender: Male </p>");
                        }
                        else
                        {
                          echo("<p class = 'gender'>Gender: Female </p>");
                        }
                      } ?>
                      <?php if ($UserData[0]["joined_date"] != "0")
                      {
                        echo("<p class = 'Joined_date'>Joined date: ".$UserData[0]["joined_date"]."</p>");
                      } ?>
                      <button class="button friend-request">Friend Request</button>
                      <button class="button message">Message</button>
                      </br></br>
                      <a href="/MyList/<?php echo($UserData[0]['username']);?>"><button class="button message">Game List</button></a>
                      <button class="button friend-request">Edit Profile</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-9 text-secondary">
                    <p class = "section">About me </p>
                    <?php echo($UserData[0]["descriptions"])?>
                    </div>
                  </div>
                </div>
              </div>
                <div class="col-sm-6 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <p class = "section">Game Stats</p>
                      </br>
                      <div class = "stats">
                        <div class = "game_stats">
                          <?php if(!empty($UserData)) {
                          echo("Mean score: ".MeanScore($allGames)."&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;Total games: ".Count($allGames));}; ?>              
                          </br></br>
                          <div id="circle" style="background: darkblue;"></div> <a href="/MyList/<?php echo($UserData[0]['username']);?>/completed" class = 'link'>&nbsp;Completed:</a> <?php echo(GameCount($UserData, "completed")) ?> </br></br>
                          <div id="circle" style="background: green;"></div><a href="/MyList/<?php echo($UserData[0]['username']);?>/playing" class = 'link'>&nbsp;Playing:</a> <?php echo(GameCount($UserData, "playing")) ?> </br></br>
                          <div id="circle" style="background: goldenrod;"></div><a href="/MyList/<?php echo($UserData[0]['username']);?>/on%20hold" class = 'link'>&nbsp;On hold:</a> <?php echo(GameCount($UserData, "on%20hold")) ?> </br></br>
                          <div id="circle" style="background: red;"></div><a href="/MyList/<?php echo($UserData[0]['username']);?>/dropped" class = 'link'>&nbsp;Dropped:</a> <?php echo(GameCount($UserData, "dropped")) ?> </br></br>
                          <div id="circle" style="background: gray;"></div><a href="/MyList/<?php echo($UserData[0]['username']);?>/plan%20to%20play" class = 'link'>&nbsp;Plan to play:</a> <?php echo(GameCount($UserData, "plan%20to%20play")) ?> </br></br>
                          <?php if(!empty($allGames)) {
                            echo('<div id="chart_div"></div>');
                          }?>
                        </div>
                        <div class="latest">
                          
                          <?php
                          if(!empty($allGames)) {
                            echo(
                            "Latest Game Update: </br></br> <a href='/Game/".GameData($allGames, $allGames[Count($allGames)-1]["game_id"])[0]['game_id']."' class = 'link gameLink'>".GameData($allGames, $allGames[Count($allGames)-1]["game_id"])[0]['game_name']."</a>
                             </br></br> <a href='/Game/".GameData($allGames, $allGames[Count($allGames)-1]["game_id"])[0]['game_id']."' class = 'link'> <img src=/images/game/".GameData($allGames, $allGames[Count($allGames)-1]["game_id"])[0]['game_cover_image']." class=profilkep> </a>");
                          };
                          ?>
                        </div>
                      </div>
                      <?php if(!empty($allGames)) {
                      echo('
                      </br>
                      <div class = "chart-favorite">
                        <div class = "chart"> 
                          Number of rated games by Score
                          </br></br></br></br>
                          <div id="piechart" style="width: 400px; height: 350px;"></div>');}?>
                        </div>
                        <div class="favorite">                          
                          <?php
                          if(!empty(GameData($allGames, FavoriteGame($UserData))[0]['game_id'])) {
                            echo
                            (
                            "Favorite Game: </br></br> <a href='/Game/".GameData($allGames, FavoriteGame($UserData))[0]['game_id']."' class = 'link gameLink'>".GameData($allGames, FavoriteGame($UserData))[0]['game_name']."</a>
                            </br></br> <a href='/Game/".GameData($allGames, FavoriteGame($UserData))[0]['game_id']."' class = 'link'> <img src=/images/game/".GameData($allGames, FavoriteGame($UserData))[0]['game_cover_image']." class=profilkep> </a>"
                            );
                          };
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>

<script type="text/javascript">

</script>
    </body>
</html>