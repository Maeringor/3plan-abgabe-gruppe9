<?php 
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/ProjektDTL.php';
require_once '../php_scripts/ProjektUserDTL.php';
require_once '../php_scripts/UserDTL.php';

$all_proj_owner_list = getProjectsByOwnerId($conn, $_SESSION["kuid"]);
$all_proj_part_list = getProjectsByUserId($conn, $_SESSION["kuid"]);
$user_result = getUserById($conn, $_SESSION["kuid"]);
$user = $user_result->fetch_assoc();

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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/project-manager.css'>

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
                        <h1 class="app-headline h1-app">Current Project List</h1> 
                        <div class="user-name h2-app"><?php echo $user["KUname"]; ?></div>
                        
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="content-section project-list">

                    <div class="cs-headline h2-app">Open Projects</div>

                    <div class="cards-container">

                        <!-- owner of event cards -->
                        <?php while($row = $all_proj_owner_list->fetch_assoc()) { ?>
                            
                            <div class="card-large">
                                <div class="top-block">
                                    <div class="image-container" style="background-color: --app-color-event-blue;">
                                        <img src=<?php echo '"'.$row["PrImage"].'"';?> alt="" width="100%" height="100%">
                                    </div>
                                </div>
                                <div class="bottom-block">
                                    <div class="c-headline-wrapper">
                                        <div class="c-title big-p-app"><?php echo $row["PrTitel"] ?></div>
                                        <div class="c-descr regular-p-app"><?php echo $row["PrBeschr"] ?></div>
                                    </div>
                                    <div class="c-btn-date-container">
                                        <div class="c-btn-container">
                                            <div class="c-enter-btn-container"><a href=<?php echo '"/main_app/project-item.php?id='.$row["PRID"].'"';?> class="c-enter-link small-p-app">enter</a></div>
                                            <form action="/php_scripts/deleteProjectDAO.php" method="POST">
                                                <!-- contains id for cards object -->
                                                <input name="id" type="hidden" value=<?php echo '"'.$row["PRID"].'"';?>>
                                                <div class="c-delete-btn-container"><button name="delete-prj" type="submit" class="delete-btn small-p-app">delete</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <!-- not owner of project cards -->
                        <?php while($row = $all_proj_part_list->fetch_assoc()) { 
                            $prj_result = getProjectById($conn, $row["PRID"]);
                            $project = $prj_result->fetch_assoc();
                        ?>

                            <div class="card-large">
                                <div class="top-block">
                                    <div class="image-container" style="background-color: --app-color-event-red;">
                                        <img src=<?php echo '"'.$project["PrImage"].'"';?> alt="" width="100%" height="100%"> 
                                    </div>
                                </div>
                                <div class="bottom-block">
                                    <div class="c-headline-wrapper">
                                        <div class="c-title big-p-app"><?php echo $project["PrTitel"] ?></div>
                                        <div class="c-descr regular-p-app"><?php echo $project["PrBeschr"] ?></div>
                                    </div>
                                    <div class="c-btn-date-container">
                                        <div class="c-btn-container">
                                            <div class="c-enter-btn-container"><a href=<?php echo '"/main_app/project-item.php?id='.$project["PRID"].'"';?> class="c-enter-link small-p-app">enter</a></div>
                                            <form action="/php_scripts/leaveProjectDAO.php" method="post">
                                                <!-- contains id for cards object -->
                                                <input name="id" type="hidden" value=<?php echo '"'.$project["PRID"].'"';?>>
                                                <div class="c-delete-btn-container"><button name="leave-prj" type="submit" class="delete-btn small-p-app">leave</button></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

                        <!-- add project -->
                        <div class="card-large">
                            <form action="/php_scripts/createProjectDAO.php" method="POST" class="c-add-card-form">
                                <div class="c-add-card-btn-container">
                                    <button name="create_prj" class="c-add-card-btn" type="submit">
                                        <img src="/rsc/icons/Lucke_Projekt_WI_1_Add_Button_Cross.svg" style="width: 30px; height: 30px;" alt="">
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section> 

    <script src="/js/time-loader.js"></script>
    <script src="/js/empty-page-handler.js"></script>

</body>
</html>