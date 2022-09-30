<?php
require_once "../php_scripts/login-checker.php";

require_once "../php_scripts/db-connect.php";

require_once "../php_scripts/UserDTL.php";
require_once "../php_scripts/EventDTL.php";
require_once "../php_scripts/EventUserDTL.php";
require_once "../php_scripts/ToDoDTL.php";
require_once "../php_scripts/ProjektDTL.php";
require_once "../php_scripts/ProjektUserDTL.php";

$user = $_SESSION["kuname"];

function activeEvents($conn){
    
    $ownerOfEvents = getEventsByOwnerId($conn, $_SESSION["kuid"]);
    $partOfEvents = getEventsByUserId($conn, $_SESSION["kuid"]);

    $amountEvents = $ownerOfEvents->num_rows + $partOfEvents->num_rows;
    return $amountEvents;
}

function countToDos($conn){
    
    $result = getAllToDoByKUID($conn, $_SESSION["kuid"]);
    return $result->num_rows;
}

function activeProjects($conn){
    global $conn;
    $ownerOfProjects = getProjectsByOwnerId($conn, $_SESSION["kuid"]);
    $partOfProjects = getProjectsByUserId($conn, $_SESSION["kuid"]);

    $amountProjects = $ownerOfProjects->num_rows + $partOfProjects->num_rows;
    return $amountProjects;
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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/dashboard.css'>
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
                        <div class="user-name h2-app"><?php echo $user ?></div>
                        
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="stats"> 
                    <div class="h2-app">Stats</div>
                    <div class="cards-container">
                        <div class="card">
                            <div class="left-block h1-app"><?php echo activeEvents($conn); ?></div>
                            <div class="right-block big-p-app">Currently active events you entered
                                <div class="icon-containera"><img src="/rsc/icons/festival_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left-block h1-app"><?php echo countToDos($conn); ?></div>
                            <div class="right-block big-p-app">Currently active todo lists
                                <div class="icon-containera"><img src="/rsc/icons/check_box_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="left-block h1-app"><?php echo activeProjects($conn); ?></div>
                            <div class="right-block big-p-app">Currently active projects
                                <div class="icon-containera"><img src="/rsc/icons/handyman_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-cards">
                    <div class="h2-app">Apps</div>

                    <div class="cards-container">

                        <div class="apps-card">
                            <div class="top-block">
                                <div class="top-block-inner">
                                    <div class="icon-containera"><img src="/rsc/icons/check_box_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                                    <div class="headline h1-app">Personal ToDO List</div>
                                </div>
                            </div>
                            <div class="app-link-container">
                                <a href="/main_app/personal-todo.php" class="app-link">
                                    <div class="btn-text big-p-app">Open App</div>
                                    <div class="btn-arrow"><img src="/rsc/icons/Lucke_Projekt_WI_1_White_Arrow_Right.svg" style="width: 100%; height: 100%;" alt=""></div>
                                </a>
                            </div>
                        </div>

                        <div class="apps-card">
                            <div class="top-block">
                                <div class="top-block-inner">
                                    <div class="icon-containera"><img src="/rsc/icons/festival_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                                    <div class="headline h1-app">Event Planner</div>
                                </div>
                            </div>
                            <div class="app-link-container">
                                <a href="/main_app/events-planner.php" class="app-link">
                                    <div class="btn-text big-p-app">Open App</div>
                                    <div class="btn-arrow"><img src="/rsc/icons/Lucke_Projekt_WI_1_White_Arrow_Right.svg" style="width: 100%; height: 100%;" alt=""></div>
                                </a>
                            </div>
                        </div>
                        <div class="apps-card">
                            <div class="top-block">
                                <div class="top-block-inner">
                                    <div class="icon-containera"><img src="/rsc/icons/handyman_FILL0_wght400_GRAD0_opsz48.svg" style="width: 100%; height: 100%;" alt=""></div>
                                    <div class="headline h1-app">Project Manager</div>
                                </div>
                            </div>
                            <div class="app-link-container">
                                <a href="/main_app/project-manager.php" class="app-link">
                                    <div class="btn-text big-p-app">Open App</div>
                                    <div class="btn-arrow"><img src="/rsc/icons/Lucke_Projekt_WI_1_White_Arrow_Right.svg" style="width: 100%; height: 100%;" alt=""></div>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    
    <script src="/js/time-loader.js"></script>
    
</body>
</html>