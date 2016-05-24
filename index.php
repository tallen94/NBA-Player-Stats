<?php
    require_once('GetPlayer.php');
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

            <form action="GetPlayer.php" method="get">
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
