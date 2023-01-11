<!-- create a HTML page -->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="Szymon at Gter">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Emergenze PCGE Dashboard</title>
        <?php
        $_DEBUG = false;
        define("ROOT_DIR", realpath(__DIR__ . "/.."));
        try {
            $config_path = __DIR__ . "/config.php";
            $path_to_boostrap = explode("/", __DIR__);
            require "./req.php";
            require "./check_evento.php";
            # Getting the conn.php file from the parent directory
            $conn_php_path =
                explode("emergenze-pcge", getcwd())[0] .
                "emergenze-pcge/conn.php";
            // This is workaround for SPID account check
            //require "./check_event_fake.php";
            // This is for the navbar component



        } catch (Exception $e) {
            echo "Caught exception: ", $e->getMessage(), "\n";
        }
        ?>
        <!-- // This is an example of how to use SQL queries:
        // $my_query = "SELECT * FROM users.utenti WHERE username = '$_SESSION[username]';";
        // $result = pg_query($conn, $my_query);
        // $r = pg_fetch_assoc($result);
        // echo $r['username']; -->
        <style>

        .select,
        #locale {
            width: 100%;
        }

        .create_campaign {
            margin-right: 10px;
        }
        </style>
    </head>

    <body data-spy="scroll" data-target=".navbar">
    <div id="wrapper" >

        <div id="navbar1">
	    <?php
	    require('navbar_up.php');
	    ?>
    </div>
    <?php
            require "./navbar_left.php";
           require "./req_bottom.php";
           require('./footer.php');
    ?>

</div>
    </body>

</html>
