<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/neo4j-connect.php';
require_once '../php_scripts/neo4jDTL.php';
require_once '../php_scripts/UserDTL.php';

$all_friends = getFriends($client, $_SESSION["kuid"]);

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
    <link rel='stylesheet' type='text/css' media='screen' href='/css/friendlist.css'>

</head>

<body>
    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html" ?>

        <div class="page-structure">
            <div class="page-content">
                <div class="headline-container">
                    <div class="left-block">
                        <h1 class="app-headline h1-app">Current Friend List</h1>
                        <div class="user-name h2-app"><?php echo $_SESSION["kuname"]; ?></div>
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="content-section friendlist">
                    <div class="cs-headline h2-app">Your Friends</div>

                    <div class="cards-container">

                        <?php foreach ($all_friends as $row) {
                            $user_result = getUserById($conn, $row);
                            $user = $user_result->fetch_assoc();
                        ?>

                        <div class="card">
                                <a href="/main_app/user-profile.php?id=<?php echo $user["KUID"]?>" class="fc-container">
                                <div class="user-pic-container">
                                    <img src=<?php echo '"' . $user["KProfileImage"] . '"'; ?> alt="" width="100%"
                                        heigth="100%" style="border-radius:999px">
                                </div>
                                <div class="user-infos">
                                    <div class="username regular-p-app"><?php echo $user["KUname"] ?></div>
                                    <div class="usermail regular-p-app"><?php echo $user["Kmail"] ?></div>
                                </div>
                                <form action="/php_scripts/deleteFriendsDAO.php" method="post">
                                    <input name="id" type="hidden" value=<?php echo '"' . $user["KUID"] . '"'; ?>>
                                    <div class="c-delete-btn-container"><button type="submit"
                                            class="delete-btn small-p-app" name="deleteBtn">delete</button></div>
                                </form>
                            </a>

                        </div>
                        <?php } ?>

                    </div>
                    <div class="form-input-container">
                        <div class="fi-headline h2-app">Add a Friend</div>
                        <form action="/php_scripts/addFriendsDAO.php" method="post">
                            <div class="input-block">
                                <div class="basic-input-container">
                                    <input name="username" type="text" class="basic-input big-p-app" placeholder=" " minlength="1" maxlength="30">
                                    <label for="username" class="basic-input-lable big-p-app">Username</label>
                                    <span class="field_placeholder regular-p-app">Username</span>
                                </div>
                                <div class="c-enter-btn-container"><button class="c-enter-link small-p-app"
                                        name="addBtn">add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <script src="/js/time-loader.js"></script>
</body>

</html>