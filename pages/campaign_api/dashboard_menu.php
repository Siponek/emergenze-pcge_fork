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
            require __DIR__ . "/../req.php";
            # Getting the conn.php file from the parent directory
            $conn_php_path =
                explode("emergenze-pcge", getcwd())[0] .
                "emergenze-pcge/conn.php";
            // This is workaround for SPID account check
            require "../check_event_fake.php";
            // This is for the navbar component
            require "../navbar_up.php";
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
        body {
            margin-top: 100px;
        }

        .select,
        #locale {
            width: 100%;
        }

        .create_campaign {
            margin-right: 10px;
        }
        </style>
    </head>

    <body>
        <div class="container" id="foretext_container">
            <p id="dashboard_text">This is a dashboard for the Python API. You can use it to send messages to the users
                of the application. You can also visualise the campaign and get the list of users.</p>
        </div>
        <div class="container" id="tabs_container">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#user_tab" aria-controls="users" role="tab"
                        data-toggle="tab">Users</a></li>
                <li role="presentation"><a href="#msg_tab" aria-controls="messages" role="tab"
                        data-toggle="tab">Messages</a></li>
                <li role="presentation"><a href="#camp_tab" aria-controls="campaigns" role="tab"
                        data-toggle="tab">Campaigns dashboad</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="user_tab">
                    <h1 id="dashboard_header">Users Dashboard</h1>
                    <div class="container " id="bstr_user" style="display: none;">
                        <h3 id="user_list_header">Users list</h3>
                        <!-- Data table for users -->
                        <table class="table-hover" id="user_table_1">
                        </table>
                        </tr>
                    </div>
                    <hr class="hr" />
                </div>
                <div role="tabpanel" class="tab-pane fade" id="msg_tab">
                    <h1 id="dashboard_header">Messages dashboard</h1>
                    <div class="container" id="API_bttn_msg_container">
                        <button class="btn btn-primary" id="button_msg_list" type="button">Get message list </button>
                        </button>
                        <hr class="hr" />
                        <form>
                            <div class="form-group">
                                <label for="comment">Message:</label>
                                <textarea class="form-control" rows="5" id="msg_content"
                                    placeholder="Message content"></textarea>
                                <input type="text" class="form-control" id="msg_note" placeholder="Message note ">
                                <input type="text" class="form-control" id="msg_id"
                                    placeholder="ID of pre-made message ">
                            </div>
                        </form>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" value=1 name="group_option" id="radio_grp_1" checked> Group 1
                            </label>
                            <label class="btn btn-primary">
                                <input type="radio" value=2 name="group_option" id="radio_grp_2"> Group 2
                            </label>
                        </div>

                        <!-- Buttons voice -->
                        <div class="btn-group">
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-primary active" id="voice_picker_female">
                                    <input type="radio" value="F" name="voice_options" checked> Female voice</input>
                                </label>
                                <label class="btn btn-primary" id="voice_picker_male">
                                    <input type="radio" value="M" name="voice_options"> Male voice</input>
                                </label>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="btn-group" data-toggle="buttons">
                                <button class="btn btn-success" type="submit" id="button_create_message">Create a
                                    message</button>
                            </div>
                            <!-- <div class="col-2 text-left" role="group"> -->
                            <div class="btn-group" data-toggle="buttons">
                                <button class="btn btn-warning" type="submit" id="button_create_campaign"
                                    data-toggle="tooltip" data-placement="bottom"
                                    title="Create campaign with the message contents specified">Create and
                                    start a
                                    campaign</button>
                            </div>
                        </div>
                        <!-- Add an outline for container -->
                        <!-- Data table for messages -->
                        <div class="container" id="bstr_message" style="display: none;">
                            <h3 id="msg_list_header">Messages visualization</h3>
                            <div id="msg_toolbar">
                                <button id="button_delete" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Delete selected messages
                                </button>
                            </div>
                            <table class="table-hover " id="msg_table" data-togle="table" data-toolbar="msg_toolbar">
                            </table>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="camp_tab">
                    <h1 id="dashboard_header">Campaigns Dashboard</h1>
                    <div class="container" id="API_bttn_camp_container">
                        <input type="text" class="form-control" id="camp_id" placeholder="ID of campaign to visualize ">
                        <button class="btn btn-primary" id="button_vis_campaign" type="button">Visualise campaign
                        </button>
                        <hr class="hr" />

                    </div>

                    <div class="container" id="API_date_container">
                        <h3 id="date_header">Select a date range for campaign search</h3>
                        <div class="input-group input-daterange date datepicker">
                            <div class="input-group-addon">From</div>
                            <input type="text" placeholder="Select start date" class="form-control" value="2020-04-05"
                                id="ui_date_start">
                            <div class="input-group-addon">to</div>
                            <input type="text" placeholder="Select end date" class="form-control" value="2022-04-19"
                                id="ui_date_end">
                        </div>
                        <button class="btn btn-primary" id="button_campaign_from_to" type="button">Get campaign
                            from/to</button>
                        <hr class="hr" />

                    </div>
                    <!-- Add an outline for container -->
                    <!-- Data table for campaigns -->
                    <div class="container " id="bstr_camp_vis" style="display: none;">
                        <hr class="hr" />
                        <h3 id="camp_vis_header">Campaign visualization</h3>
                        <table class="table-hover" id="camp_table" data-togle="table">
                        </table>
                    </div>
                    <!-- Data table for campaign -->
                    <div class="container" id="bstr_camp" style="display: none;">
                        <hr class="hr" />
                        <h3 id="camp_list_header">Campaign list</h3>
                        <div id="camp_toolbar">
                            <!-- <button id="button_vis" class="btn btn-primary">
                    <i class="fa fa-eye"></i> Visualize selected campaigns
                </button> -->
                        </div>
                        <table class="table-hover" id="camp_table_time" data-togle="table" data-toolbar="camp_toolbar">
                        </table>
                    </div>
                </div>
            </div>
        </div>



        <!-- defer blocks execution of script untill document is loaded -->
        <script type="text/javascript" defer src="dashboard_js.js"></script>
    </body>

</html>