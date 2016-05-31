<?php
    dl('extension=php_pdo_mysql.dll');
    require_once('player.php');
    $player_name = $argv[0];
    $callback = $argv[1];
    if(isset($_GET['player_name'])) {
        
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
        $sth = $pdo->prepare('SELECT * FROM PLAYER WHERE name LIKE :name');
        $sth->bindParam(':name', "%{$closest}%");
        $sth->execute();

        $result = $sth->fetchAll();
        print($callback . "(" . $result . ")");
    }
?>
