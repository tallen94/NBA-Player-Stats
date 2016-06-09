<?php
    $player_name = $_GET['player_name'];
    $callback = $_GET['callback'];
    if(isset($player_name) && isset($callback)) {
         
        $host = 'info344assign1.caorj1pxcht2.us-west-2.rds.amazonaws.com';
        $port = '3306';
        $dbname = 'NBA_Stats';
        $user = 'info344user';
        $pass = 'Supertr00per';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

        $opt = [
            PDO::ATTR_ERRMODE		         => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE	 => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES	     => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $opt);
        $sth = $pdo->prepare("SELECT * FROM PLAYER WHERE name LIKE :name");
        $param = '%' . $player_name . '%';
        $sth->bindParam(':name', $param, PDO::PARAM_STR);
        $sth->execute();

        $result = $sth->fetchAll();
        echo $callback . '(' . json_encode($result) . ')';
    }
?>
