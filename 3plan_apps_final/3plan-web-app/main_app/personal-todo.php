<?php 
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/ToDoDTL.php';
require_once '../php_scripts/UserDTL.php';

$all_todo_lists = getAllToDoByKUID($conn, $_SESSION["kuid"]);
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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/personal-todo.css'>
</head>

<body>

    <section class="content-main-app">
        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html" ?>


        <div class="page-structure">

            <div id="empty-tab" class="empty-tab-container" style="position: absolute; width: 100%; height: 100vh; top: 0%; left: 0%; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                    <div class="h2-app" style="font-weight: bold; text-align: center;">Empty Tab</div>
                    <div class="big-p-app" style="text-align: center; margin-top: 10px;">You dont have any open ToDo lists</div>
            </div>

            <div class="page-content">

                <div class="headline-container">
                    <div class="left-block">
                        <h1 class="app-headline h1-app">Hello and welcome back</h1>
                        <div class="user-name h2-app"><?php echo $user["KUname"]; ?></div>
                        
                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="content-section todo-list">
                    <div class="cs-headline h2-app">Your ToDo List</div>

                    <div class="cards-container">

                        <?php while($row = $all_todo_lists->fetch_assoc()) { ?>

                            <div class="card">
                                    <div class="left-block">
                                        <div class="image-container">
                                            <img src=<?php echo '"'.$row["ToDoImage"].'"';?> alt="" width="100%" height="100%">
                                        </div>
                                    </div>
                                    <div class="right-block">
                                        <div class="c-headline-wrapper">
                                            <div class="c-title big-p-app"><?php echo $row["ToDoTitel"] ?></div>
                                            <div class="c-descr regular-p-app"><?php echo $row["ToDoBeschr"] ?></div>
                                        </div>
                                        
                                        <div class="c-btn-container">
                                            <div class="c-enter-btn-container"><a href=<?php echo '"/main_app/todo-item.php?id='.$row["ToDoID"].'"';?> class="c-enter-link small-p-app">enter</a></div>
                                            <form action="/php_scripts/deleteTodoItemDAO.php" method="POST">
                                                <!-- contains id for cards object -->
                                                <input name="id" type="hidden" value=<?php echo '"'.$row["ToDoID"].'"';?>>
                                                <div class="c-delete-btn-container"><button name="delete-todo" type="submit" class="delete-btn small-p-app">delete</button></div>
                                            </form>
                                        </div>
                                    </div>
                            </div>
                        <?php } ?>

                            <div class="card">
                                <form action="/php_scripts/createTodoItemDAO.php" method="POST" class="c-add-card-form">
                                    <div class="c-add-card-btn-container">
                                        <button name="create-todo" class="c-add-card-btn" type="submit">
                                            <img src="/rsc/icons/Lucke_Projekt_WI_1_Add_Button_Cross.svg" style="width: 30px; height: 30px;" alt="">
                                        </button>
                                    </div>
                                </form>
                            </div>
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