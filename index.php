<?php
    require_once('player.php');

    if(isset($_GET["player"])) {
        $player_name = $_GET["player"];
        $host = 'info344assign1.caorj1pxcht2.us-west-2.rds.amazonaws.com';
        $port = '3306';
        $dbname = 'NBA_Stats';
        $user = 'info344user';
        $pass = 'Supertr00per';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

        $playerNames = file('names.txt');
        $shortest = -1;

        foreach($playerNames as $name) {
            $lev = levenshtein($player_name, $name);
            if ($lev == 0) {
                $closest = trim($name);
                $shortest = 0;
                break;
            }

            if ($lev <= $shortest || $shortest < 0) {
                $closest = trim($name);
                $shortest = $lev;
            }
        }

        $opt = [
            PDO::ATTR_ERRMODE		         => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE	 => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES	     => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $opt);

        $sql = "SELECT * FROM PLAYER WHERE name LIKE '%$closest%'";
        
        try {
            $stmt = $pdo->query($sql);
            $data = $stmt->fetchAll();
        } catch(PDOException $ex) {
            echo "PDO Error: " . $ex;
        }
        $player = new Player($data);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>NBA Player Stats</title>
        <link rel='stylesheet' type='text/css' href='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'/>
        <link rel='stylesheet' type='text/css' href='index.css' />
    </head>

    <body>

        <div class="container search"> 
            <h1>NBA Player Stats</h1>
            <p >Look for your favorite NBA Player's Stats for the 2015-2016 season.</p>

            <form action="index.php" method="get">
                <div class="form-group">
                    <label for="player">Player Name</label>
                    <input type="text" name="player" id="player" class="form-control">
                </div>
                <div class="form-group">
                    <button class="search-btn" type="submit">Search</button>
                </div>
            </form>
        </div>
        
       <div class="container player"> 
            <?php
                if(isset($player)) {
                    $stats = $player->getStats();
            ?>
            
            <div class="player-general">
                <h2><?=$stats[name]?></h2>
                <div class="player-general info">
                    <p><span class="bold">Team:</span> <?=$stats[team]?></p>
                    <p><span class="bold">Games Played:</span> <?=$stats[gp]?></p>
                    <p><span class="bold">Playtime:</span> <?=$stats[min]?> minutes</p>
                </div>
                <div class="line"></div>
                <div class="player-general stats">
                    <div>
                        <p>Assists: <?=$stats[ast]?></p>
                        <p>Turnovers: <?=$stats[_to]?></p>
                        <p>Steals: <?=$stats[stl]?></p>
                    </div>
                    <div>
                        <p>Blocks: <?=$stats[blk]?></p>
                        <p>Personal Fouls: <?=$stats[pf]?></p>
                        <p>Points Per Game: <?=$stats[ppg]?></p>
                    </div>
                </div>
            </div>

            <div class="player-stats-main">
                <div class="player-stats-main-section">
                    <h3>field goals</h3>
                    <p>Made: <span class="value"><?=$stats[fg_made]?></span></p>
                    <p>Attempted: <span class="value"><?=$stats[fg_attempted]?></span></p>
                    <p>Percent: <span class="value"><?=$stats[fg_percent]?></span></p>
                </div>
                <div class="player-stats-main-section">
                    <h3>three pointers</h3>
                    <p>Made: <span class="value"><?=$stats[three_made]?></span></p>
                    <p>Attempted: <span class="value"><?=$stats[three_attempted]?></span></p>
                    <p>Percent: <span class="value"><?=$stats[three_percent]?></span></p>
                </div>
                <div class="player-stats-main-section">
                    <h3>free throws</h3>
                    <p>Made: <span class="value"><?=$stats[ft_made]?></span></p>
                    <p>Attempted: <span class="value"><?=$stats[ft_attempted]?></span></p>
                    <p>Percent: <span class="value"><?=$stats[ft_percent]?></span></p>
                </div>
            </div>

            <?php
                }   
            ?>
        </div>
    </body>
</html>
