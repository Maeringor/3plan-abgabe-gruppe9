<?php
require_once "../php_scripts/login-checker.php";
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/DeleteEventDAO.php";
require_once "../php_scripts/LeaveEvent.DAO.php";
require_once "../php_scripts/EventDTL.php";
require_once "../php_scripts/EventUserDTL.php";

$event_User_Owned = getEventsByOwnerId($conn, $_SESSION["kuid"]);
$event_User_PartOf = getEventsByUserId($conn, $_SESSION["kuid"]);

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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/events-planner.css'>

</head>
<body>
    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html"?>

        <div class="page-structure">

        <div id="empty-tab" class="empty-tab-container" style="position: absolute; width: 100%; height: 100vh; top: 0%; left: 0%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                <div class="h2-app" style="font-weight: bold; text-align: center;">Empty Tab</div>
                <div class="big-p-app" style="text-align: center; margin-top: 10px;">You dont have any open events</div>
            </div>

            <div class="page-content">
                <div class="headline-container">
                    <div class="left-block">
                        <h1 class="app-headline h1-app">Current Event List</h1>
                        <div class="user-name h2-app"><?php echo $_SESSION["kuname"]; ?></div>
                        
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="content-section event-list">
                    <div class="cs-headline h2-app">Open Events</div>

                    <div class="cards-container">

                        <?php while($row = $event_User_Owned->fetch_assoc()) { ?>

                        <!-- owner of event cards -->
                        <div class="card-large">
                            <div class="top-block">
                                <div class="image-container" style="background-color: <?php echo $row["EvColor"]?>;">
                                </div>
                            </div>
                            <div class="bottom-block">
                                <div class="c-headline-wrapper">
                                    <div class="c-title big-p-app"> <?php echo $row["EvTitle"]; ?> </div>
                                    <div class="c-descr regular-p-app"> <?php echo $row["EvBeschr"]; ?> </div>
                                </div>
                                <div class="c-btn-date-container">
                                    <div class="c-btn-container">
                                        <div class="c-enter-btn-container"><a href="/main_app/event-item.php?id=<?php echo $row["EVID"]?>" class="c-enter-link small-p-app">enter</a></div>
                                        <form action="/php_scripts/DeleteEventDAO.php" method="POST">
                                            <!-- contains id for cards object -->
                                            <input id="evid" name="evid" type="hidden" value=<?php echo '"'.$row["EVID"].'"' ?>>
                                            <div class="c-delete-btn-container"><button id="deleteEventBTN" name="deleteEventBTN" type="submit" class="delete-btn small-p-app">delete</button></div>
                                        </form>
                                    </div>
                                    <div class="event-date regular-p-app"> <?php echo date("d.m.Y", strtotime($row["EVStart"])); ?> </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                        <?php while($row = $event_User_PartOf->fetch_assoc()) { 
                                $event = getEventByEventId($conn, $row["EVID"])->fetch_assoc() ?>
                        <!-- not owner of event cards -->
                        <div class="card-large">
                            <div class="top-block">
                                <div class="image-container" style="background-color: <?php echo $event["EvColor"]?>;">
                                    
                                </div>
                            </div>
                            <div class="bottom-block">
                                <div class="c-headline-wrapper">
                                    <div class="c-title big-p-app"> <?php echo $event["EvTitle"]; ?> </div>
                                    <div class="c-descr regular-p-app"> <?php echo $event["EvBeschr"]; ?> </div>
                                </div>
                                <div class="c-btn-date-container">
                                    <div class="c-btn-container">
                                        <div class="c-enter-btn-container"><a href="/main_app/event-item.php?id=<?php echo $row["EVID"]?>" class="c-enter-link small-p-app">enter</a></div>
                                        <form action="/php_scripts/LeaveEvent.DAO.php" method="post">
                                            <!-- contains id for cards object -->
                                            <input name="evid" type="hidden" value=<?php echo '"'.$row["EVID"].'"' ?>>
                                            <div class="c-delete-btn-container"><button id="leaveEventBTN" name="leaveEventBTN" type="submit" class="delete-btn small-p-app">leave</button></div>
                                        </form>
                                    </div>
                                    <div class="event-date regular-p-app"> <?php echo date("d.m.Y", strtotime($event["EVStart"])); ?> </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                        <!-- add new card -->
                        <div class="card-large">
                            <div class="c-add-card-btn-container">
                                <button class="c-add-card-btn" type="submit">
                                    <img src="/rsc/icons/Lucke_Projekt_WI_1_Add_Button_Cross.svg" style="width: 30px; height: 30px;" alt="">
                                </button>
                            </div>
                        </div>

                    </div>
                    
                </div>

            </div>

            <div class="create-event-form-container" id="create-event-form-container" style="display: none;">
                <form action="/php_scripts/CreateEventDAO.php" method="POST">
                    <div class="headline h2-app">Create Event</div>
                    <div class="block-container">
                        <div class="left-container">
                            <div class="basic-input-container">
                                <input name="title" type="text" class="basic-input big-p-app" placeholder=" " minlength="1" maxlength="50">
                                <label for="title" class="basic-input-lable big-p-app">Title</label>
                                <span class="field_placeholder regular-p-app">Title</span>
                            </div>
                            <div class="basic-input-container">
                                <input name="descr" type="text" class="basic-input big-p-app" placeholder=" " minlength="1" maxlength="80">
                                <label for="descr" class="basic-input-lable big-p-app">Description</label>
                                <span class="field_placeholder regular-p-app">Description</span>
                            </div>

                            <div class="checkbox-btn-online"><input onclick="toggleLocation()" class="checkbox-online" type="checkbox" name="online-cbx" id="online-cbx"><label for="online-cbx" class="big-p-app">Online</label></div>
                            <div class="location-container">
                                <div class="basic-input-container">
                                    <input name="street-number" type="text" class="basic-input big-p-app" placeholder=" " maxlength="50">
                                    <label for="street-number" class="basic-input-lable big-p-app">Street, Number</label>
                                    <span class="field_placeholder regular-p-app">Street, Number</span>
                                </div>
                                <div class="basic-input-container">
                                    <input name="addr-city" type="text" class="basic-input big-p-app" placeholder=" " maxlength="50">
                                    <label for="addr-city" class="basic-input-lable big-p-app">Address, City</label>
                                    <span class="field_placeholder regular-p-app">Address, City</span>
                                </div>
                                <div class="basic-input-container">
                                    <input name="country" type="text" class="basic-input big-p-app" placeholder=" " maxlength="30">
                                    <label for="country" class="basic-input-lable big-p-app">Country</label>
                                    <span class="field_placeholder regular-p-app">Country</span>
                                </div>
                            </div>

                            <div class="date-time-container">
                                <div class="basic-input-container">
                                    <input name="time" type="time" class="basic-input big-p-app" placeholder=" ">
                                    <label for="time" class="basic-input-lable big-p-app">Start Time</label>
                                    <span class="field_placeholder regular-p-app">Start Time</span>
                                </div>
                                <div class="basic-input-container">
                                    <input name="date" type="date" class="basic-input big-p-app" placeholder=" ">
                                    <label for="date" class="basic-input-lable big-p-app">Event Date</label>
                                    <span class="field_placeholder regular-p-app">Event Date</span>
                                </div>
                            </div>
   
                        </div>
                        <div class="right-container">
                            <div class="radio-container">
                                <div class="radio-headline regular-p-app">Colors</div>
                                <input type="radio" name="colors" id="color-red" value="#f34e67" class="radio-colors" checked>
                                <input type="radio" name="colors" id="color-blue" value="#00a8ff" class="radio-colors">
                                <input type="radio" name="colors" id="color-green" value="#00ff96" class="radio-colors">
                                <input type="radio" name="colors" id="color-pink" value="#f331d8" class="radio-colors">
                            </div>
                            <!-- button submit -->
                            <div class="standart-btn-container">
                                <button id="createEventBTN" name="createEventBTN" type="submit" class="standart-btn regular-p-app">submit 
                                    <div class="arrow-container">
                                        <img src="/rsc/icons/Lucke_Projekt_WI_1_White_Arrow_Right.svg" class="left-arrow" alt="" width="20px" height="20px">
                                        <img src="/rsc/icons/Lucke_Projekt_WI_1_White_Arrow_Right.svg" class="right-arrow" alt="" width="20px" height="20px">
                                    </div>                    
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </section>

    <script>
        // checkbox logic show/no show 
        function toggleLocation() {
            const checkBox = document.getElementById('online-cbx');
            const locationContainer = document.querySelector('.location-container');
            const locationInputs = locationContainer.getElementsByClassName('basic-input');

            if (checkBox.checked) {
                locationContainer.style.display="none";
                for (var i = 0; i < locationInputs.length; i++) {
                    locationInputs[i].value="";
                }
                return;
            }

            locationContainer.style.display="block";
        }

        // close create form
        document.body.addEventListener('keydown', function(e) {
            const createFormContainer = document.getElementById('create-event-form-container');
            if (e.key === "Escape" && window.getComputedStyle(createFormContainer).display === "block") {
                createFormContainer.style.display="none";
            } 
        });

        // open create form
        document.querySelector('.c-add-card-btn-container').addEventListener('click', function() {
            const createFormContainer = document.getElementById('create-event-form-container');
            if(window.getComputedStyle(createFormContainer).display === "none") {
                createFormContainer.style.display="block";
                
            }
        });
        
    </script>
    <script src="/js/time-loader.js"></script>
    <script src="/js/empty-page-handler.js"></script>

</body>
</html>