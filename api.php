<?php
    
    set_time_limit (0);

    $address = '192.168.10.110';

    $port = 8880;
    $con = 1;
    $word = "";

    $sock = socket_create(AF_INET, SOCK_STREAM, 0);
    $bind = socket_bind($sock, $address, $port);

    socket_listen($sock);

    while ($con == 1)
    {
        $client = socket_accept($sock);
        $input = socket_read($client, 4000);
       
        
        echo "KDS is recieving information";
        $input = trim($input);

        if (strpos($input, 'key') !== false) {
            echo 'true';
            $pieces = explode(":", $input);
            echo $pieces[0]; // piece1
            echo $pieces[1]; // piece
        }
        
        if (!file_exists("upload"))
        {
           mkdir("upload", 0777, true);
        }


        if ($input == 'exit') 
        {
            $close = socket_close($sock);
            $con = 0;
        }

        if($con == 1)
        {
            $word .= $input;
        }
    }

    //echo $word;

?>