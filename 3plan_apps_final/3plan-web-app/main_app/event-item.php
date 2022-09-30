<?php
require_once "../php_scripts/login-checker.php";
require_once "../php_scripts/EventDTL.php";
require_once "../php_scripts/EventUserDTL.php";
require_once '../php_scripts/neo4j-connect.php';
require_once "../php_scripts/EventCommDTL.php";
require_once "../php_scripts/UserDTL.php";
require_once "../php_scripts/combinationAlgorithm.php";
require_once "../php_scripts/db-connect.php";

$eventID = $_GET["id"];

$event = getEventByEventId($conn, $eventID)->fetch_assoc();
$comments = getAllCommentsByEventID($conn, $eventID);

function realEvent($event){
    if(empty($event["EvLand"]) && empty($event["EvStrasseNr"]) && empty($event["EvPLZOrt"])){
        return true;
    }else{
        return false;
    }
}

$onlineEvent = realEvent($event);

function displayAddress($onlineEvent, $event){
    if($onlineEvent == true){
        echo "Online";
    }else{
        echo $event["EvStrasseNr"] . " - " . $event["EvPLZOrt"] . " - " . $event["EvLand"];
    }
}

function map($event){
    $eventaddress = $event["EvStrasseNr"] . " " . $event["EvPLZOrt"] . " " . $event["EvLand"];
    str_replace(" ", "%20", $eventaddress);
    str_replace("ö", "%C3%B6", $eventaddress);
    str_replace("Ö", "%C3%96", $eventaddress);
    str_replace("ä", "%C3%A4", $eventaddress);
    str_replace("Ä", "%C3%84", $eventaddress);
    str_replace("ü", "%C3%BC", $eventaddress);
    str_replace("Ü", "%C3%9C", $eventaddress);
    str_replace("ß", "%C3%9F", $eventaddress);

    return $eventaddress;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3plan</title>

    <!--Globale Styles-->
    <link rel='stylesheet' type='text/css' media='screen' href='/css/design.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/app-nav.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/elements.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='/css/default-page-structure.css'>
    
    <link rel='stylesheet' type='text/css' media='screen' href='/css/event-item.css'>


</head>
<body>
    
    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html"?>

       <div class="page-structure">
            <div class="page-content">
                
                <div class="ei-top-block">
                    <div class="event-color-container" style="background-color: <?php echo $event["EvColor"];?>;"></div>

                    <div class="ei-headline-form">
                        <div class="ei-title-container">
                            <input type="text" value=<?php echo '"'.$event["EvTitle"].'"' ?> class="ei-headline-input h2-app" readonly>
                        </div>
                        <div class="ei-descr-container">
                            <textarea readonly maxlength="80" id="descr" name="descr" class="ei-descr regular-p-app" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'><?php echo '"'.$event["EvBeschr"].'"' ?></textarea>
                        </div>

                        <!-- save and delte btn -->
                        <div class="ei-save-delete-container">
                            <?php if ($_SESSION["kuid"] == $event["KUID"]) { ?>
                            <form action="/php_scripts/DeleteEventDAO.php?id=<?php echo $event["EVID"] ?>" method="POST">
                                <div class="c-delete-btn-container">
                                    <button id="deleteEventBTN" name="deleteEventBTN" type="submit" class="delete-btn small-p-app">delete</button>
                                </div>
                            </form>
                           <?php } else { ?>
                            <form action="/php_scripts/LeaveEvent.DAO.php" method="POST">
                                <input type="text" name="evid" hidden value=<?php echo '"'. $event["EVID"] .'"';?>>
                                <div class="c-delete-btn-container">
                                    <button id="leaveEventBTN" name="leaveEventBTN" type="submit" class="delete-btn small-p-app">leave</button>
                                </div>
                            </form>
                            <?php } ?>

                            <div class="friend-add-symbole">
                                <div class="fl-sym" onclick="toggleVisibilty()"><img src="/rsc/icons/Lucke_Projekt_WI_1_add_friend.svg" alt=""></div>
                                <div class="friend-add-list" style="display: none;">
                                    <?php 
                                    $part_result = getUserByEventId($conn, $eventID);
                                    $part_array = fetchUids($part_result);

                                    $final_friend_list = fetchNotAddedFriends($client, $conn, $part_array, $event["KUID"]);

                                    function fetchUids($part_assoc) {
                                        $array = [];

                                        while ($item = $part_assoc->fetch_assoc() ) {
                                            array_push($array, $item["KUID"]);
                                        }
                                        return $array;
                                    }
                                ?>
                                
                                <div class="fl-headline regular-p-app">Add friend</div>
                                <?php foreach ($final_friend_list as $friend => $friend_value) { ?>
                                    <div class="friend-item">
                                        <div class="friend-name regular-p-app"><?php echo $friend_value ?></div>
                                        <div class="c-save-btn-container"><button onclick="sendData('evID=<?php echo $eventID; ?>&uid=<?php echo $friend ?>', '/php_scripts/addUserToEventDAO.php')" class="save-btn">add</button></div>
                                    </div>
                                    <div class="fl-uline"></div>
                                <?php } ?>
                    
                                </div>
                            </div>

                        </div>
                        
                    </div>

                    

                </div>


                <div class="ei-main-content">

                    <div class="ei-place-container">
                        <div class="top-infos">
                            <div class="ei-left-block">
                                <div class="event-place-headline big-p-app">Place</div>
                                <div class="event-place big-p-app"><?php displayAddress($onlineEvent, $event) ?></div>
                            </div>
                            <div class="ei-right-block">
                                <div class="event-start-headline big-p-app">Event Start</div>
                                <div class="event-start-date-time big-p-app"><?php echo $event["EVStart"] ?></div>
                            </div>
                        </div>

                        <?php if($onlineEvent == false) { ?>
                        <div class="maps-block">
                            <!-- Button zu Google Maps Link  -->
                            <div class="mapouter">
                                <div class="gmap_canvas">
                                    <iframe width= "100%;" height="100%;" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo map($event)?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                                        <br><style>.mapouter{position:relative;text-align:right; width: 100%; height: 100%;}</style>
                                        <style>.gmap_canvas {overflow:hidden;background:none!important; width: 100%; height: 100%;}</style>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        
                    </div>

                    <div class="co-section">

                        <div class="co-headline big-p-app">Comments</div>

                        <div class="co-container">

                            <?php while($row = $comments->fetch_assoc())  { $userToComment = getUserById($conn, $row["KUID"])->fetch_assoc();?>
                            <div class="co-item">
                                <div class="co-uname regular-p-app"><?php echo $userToComment["KName"] ?></div>
                                <div class="co-text regular-p-app"><?php echo $row["Message"] ?></div>
                            </div>
                            <?php } ?>

                            <form action="../php_scripts/CreateEventCommDAO.php" method="post" style="display: block;">
                                <div class="co-text-container">
                                    <textarea spellcheck="false" maxlength="180" id="co-text" name="co-text" class="co-text regular-p-app" placeholder="Comment..." minlength="1" maxlength="200"></textarea>
                                </div>
                                <input id="evid" name="evid" type="hidden" value=<?php echo '"'.$eventID.'"' ?>>
                                <div class="c-enter-btn-container"><button name="createCommBTN" id="createCommBTN" type="submit" class="c-enter-link small-p-app">enter</button></div>
                            </form>
                        </div>

                    </div>

                </div>


            </div>
       </div>

    </section>

    <script>
        function toggleVisibilty() {
            var x = document.querySelector('.friend-add-list');
            x.style.display=x.style.display==="none" ? "block" : "none";
        }
    </script>

    <script src="/js/data-transfer.js"></script>

</body>
</html>