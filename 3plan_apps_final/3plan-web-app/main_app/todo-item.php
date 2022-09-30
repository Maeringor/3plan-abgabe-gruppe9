<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/ToDoDTL.php";
require_once '../php_scripts/globale-functions.php';

if (isset($_GET["id"])) {
    $todo_result = getTodoByToDoIDAndUserID($conn, $_GET["id"], $_SESSION["kuid"]);
    if ($todo_result->num_rows === 1) {
        $todo = $todo_result->fetch_assoc();
    }
} else {
    redirectTo("personal-todo.php");
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
     
     <link rel='stylesheet' type='text/css' media='screen' href='/css/todo-item.css'>
 
</head>
<body>

    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html"?>

        <div class="page-structure">
            <div class="page-content">
            
                <div class="ti-top-block">
                    <div class="profile-pic-container">
                        <img name="profilePicDisplay" id="profilePicDisplay" src=<?php echo '"'.$todo["ToDoImage"].'"'; ?> alt="" onclick="openImageFileExplorer()" width="200px" height="200px" style="overflow: hidden; border-radius: 999px; cursor: pointer;">
                    </div>
                    <!-- user can add img -->
                    <form action="/php_scripts/processImageUpload.php?key=todo&id=<?php echo $todo['ToDoID']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="add-img-container">
                            <input name="profilePic" id="profilePic" type="file" accept=".jpeg,.png,.svg,.jpg" onchange="displayImage(this)" class="profile-image-container" style="display: none;">
                            <button id="saveImg" name="saveImg" type="submit" style="display: none;" class="small-p-app">submit</button>    
                        </div>
                    </form>

                    <form action="/php_scripts/updateTodoItemDAO.php?id=<?php echo $todo['ToDoID']; ?>" method="POST" class="ti-headline-form">
                        <div class="ti-title-container">
                            <input name="td-item-title" minlength="1" maxlength="30" type="text" value=<?php echo '"'.$todo["ToDoTitel"].'"'; ?> class="ti-headline-input h2-app">
                        </div>
                        <div class="ti-descr-container">
                            <textarea name="td-item-text" minlength="1" maxlength="80" id="descr" name="descr" class="ti-descr regular-p-app" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"' style="text-align: center;"><?php echo $todo["ToDoBeschr"] ?></textarea>
                        </div>

                        <!-- save and delte btn -->
                        <div class="ti-save-delete-container">
                            <div class="c-save-btn-container">
                                <button name="save-td-item" type="submit" class="save-btn small-p-app">save</button>
                            </div>
                            <form action="/php_scripts/deleteToDoItemDAO.php" method="POST">
                                <input name="id" type="hidden" value=<?php echo '"'.$todo["ToDoID"].'"';?>>
                                <div class="c-delete-btn-container">
                                    <button onclick="sendForm('delete')" name="delete-todo" type="button" class="delete-btn small-p-app">delete</button>
                                </div>
                            </form>
                        </div>
                        
                    </form>

                    <form id="delete" action="/php_scripts/deleteToDoItemDAO.php" method="POST">
                        <input name="id" type="hidden" value=<?php echo '"'.$todo["ToDoID"].'"';?>>
                        <input name="delete-todo" type="hidden" value=<?php echo '"'.$todo["ToDoID"].'"';?>>
                    </form>

                </div>


                <div id="todo-item-list" class="main-todo-section" onchange="loadCheckBoxLogic()">

                        <?php 
                            $file = file_get_contents("..".$todo["JsonLink"]);
                            $json = json_decode($file);
                        ?>

                        <!-- todo cards -->
                        <?php 
                        if (isset($json)) {
                        
                            foreach ($json as $data) { ?>
                                <div class="todo-item">
                                    <input name="item-checked" class="td-check" type="checkbox" <?php if ($data->checked === 1) { echo "checked"; }?>>
                                    <input name="item-text" class="td-input" type="text" class="regular-p-app" value=<?php echo '"'.$data->text.'"';?>>
                                    <button name="delete-item" class="td-delete-btn" onclick="deleteItemEvent(this)">X</button>
                                </div>
                        <?php 
                            } 
                        }?>
                
                </div>

                <div class="add-todo-container">
                    <input id="add-new-todo-input" type="text" placeholder="Add task title..." class="regular-p-app">
                    <div class="c-enter-btn-container"><button class="c-enter-link small-p-app" onclick="addToDo()">add</button></div>
                </div>

                <!-- onlick event to save all todos in json -->
                <div class="save-btn-wrapper">
                    <div class="c-save-btn-container">
                        <button onclick="sendJSON('/php_scripts/todoDAO.php?id=<?php echo $todo['ToDoID']; ?>')" class="save-btn small-p-app">save</button>
                    </div>
                </div>

            </div>
        </div>

    </section>
    
    <script src="/js/change-image.js"></script>
    <script src="/js/json-sender.js"></script>

    <script>
        function loadCheckBoxLogic() {
            const todoCheckBoxes = document.getElementsByName('item-checked');

            // click event for checkbox
            for (let index = 0; index < todoCheckBoxes.length; index++) {
                
                todoCheckBoxes[index].addEventListener("click", function() {
                    const textInputTodo = document.getElementsByName('item-text');
                    if (todoCheckBoxes[index].checked) {
                        textInputTodo[index].style.textDecoration="line-through";
                        return;
                    }
                    textInputTodo[index].style.textDecoration="";
                    
                });            
            }
        }
        loadCheckBoxLogic();

        function ckeckIfCheckBoxChecked() {
            const todoCheckBoxes = document.getElementsByName('item-checked');

            for (let index = 0; index < todoCheckBoxes.length; index++) {
                const textInputTodo = document.getElementsByName('item-text');
                if (todoCheckBoxes[index].checked) {
                    textInputTodo[index].style.textDecoration="line-through";
                }        
            }
        }

        window.addEventListener('load', (event) =>{
            ckeckIfCheckBoxChecked();
        });

        function deleteItemEvent(deleteBtn) {
            deleteBtn.parentElement.remove();
        }

        function addToDo() {
            const itemList = document.getElementById('todo-item-list');
            const newTodoInput = document.getElementById('add-new-todo-input');
            itemList.innerHTML += `<div class="todo-item">
                            <input name="item-checked" class="td-check" type="checkbox">
                            <input name="item-text" class="td-input" type="text" class="regular-p-app" value="${newTodoInput.value}">
                            <button name="delete-item" class="td-delete-btn" onclick="deleteItemEvent(this)">X</button>
                        </div>`;
            newTodoInput.value="";
            loadCheckBoxLogic();
        }

        function sendForm(name) {
            document.getElementById(name).submit();
        }
    </script>

    <script src="/js/change-image.js"></script>

</body>
</html>