<?php

    function getDatabaseConnection($dbname = 'ottermart') {
        
        $host ='localhost'; // Cloud9
        //$dbname = 'tcp';
        $username = 'root';
        $password = '';
        
        //when connecting from Heroku
        if  (strpos($_SERVER['HTTP_HOST'], 'herokuapp') !== false) {
            $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
            $host = $url["host"];
            $dbname = substr($url["path"], 1);
            $username = $url["user"];
            $password = $url["pass"];
        } 
        
        // Create the new db connection
        $dbconn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Display errors when accessing tables
        $dbconn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $dbconn;
        
    }

?>