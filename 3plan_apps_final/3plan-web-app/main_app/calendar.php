<?php 
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once '../php_scripts/EventDTL.php';
require_once "../php_scripts/UserDTL.php";
require_once '../php_scripts/EventUserDTL.php';

$user_result = getUserById($conn, $_SESSION["kuid"]);
$user = $user_result->fetch_assoc();

$result = array();
$event_owner = getEventsByOwnerId($conn, $_SESSION["kuid"]);

$count = 0;
while ($row = $event_owner->fetch_assoc()) {
    $result[$count][0] = $row["EVStart"];
    $result[$count][1] = $row["EvTitle"];
    $result[$count][2] = $row["EvColor"];

    $count++;
}

$event_part = getEventsByUserId($conn, $_SESSION["kuid"]);

while ($row = $event_part->fetch_assoc()) {
    $single_event_result = getEventByEventId($conn, $row["EVID"]);
    $single_event = $single_event_result->fetch_assoc();
    $result[$count][0] = $single_event["EVStart"];
    $result[$count][1] = $single_event["EvTitle"];
    $result[$count][2] = $single_event["EvColor"];

    $count++;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel='stylesheet' type='text/css' media='screen' href='/css/design.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/app-nav.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/elements.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/default-page-structure.css'>

    <link rel="stylesheet" href="/css/calendar.css">
    <title>Calendar</title>
</head>
<body>
    <section class="content-main-app">
        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html"?>

        <div class="page-structure">
            <div class="page-content">
            <div class="headline-container">
                    <div class="left-block">
                        <h1 class="app-headline h1-app">Hello and welcome back</h1>
                        <div class="user-name h2-app"><?php echo $user["KUname"] ?></div>
                        
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>
                <div class="content-section">
                    <div class="kalender_cont">
                        <table id="kalender"></table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="/js/calendar.js"></script>
    <script src="/js/time-loader.js"></script>

    <script>
        var arr = <?php echo json_encode($result) ?>; 
        setResultArray(arr);
        addEventDot();
    </script>
</body>
</html>