<?php
require_once '../php_scripts/login-checker.php';
require_once '../php_scripts/db-connect.php';
require_once '../php_scripts/ToDoDTL.php';
require_once '../php_scripts/UserDTL.php';
require_once '../php_scripts/ProjektDTL.php';
require_once '../php_scripts/globale-functions.php';

if (isset($_GET["key"]) && isset($_POST["saveImg"]) && isset($_FILES["profilePic"])) {
    
    // globale settings
    $time_id = time();
    $extension = pathinfo($_FILES["profilePic"]["name"], PATHINFO_EXTENSION);
    $new_file_name = $time_id."_".$_SESSION["kuid"].".".$extension;

    // on profile page
    if ($_GET["key"] === "user") {
        $target_path = "../blob/profile_images/".$new_file_name;
        $target_path_db = "/blob/profile_images/".$new_file_name;

        $user_result = getUserById($conn, $_SESSION["kuid"]);
        $user = $user_result->fetch_assoc();
        
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_path)) {

            if (strcmp($user["KProfileImage"], "/blob/profile_images/default_profile_image.png") !== 0) {
                unlink("..".$user["KProfileImage"]);
            }

            updateImage($conn, $_SESSION["kuid"], $target_path_db);
            $_SESSION["kprofileimage"] = $target_path_db;

            redirectTo("../main_app/profile.php");
        }

    } 
    // on project page
    elseif ($_GET["key"] === "proj" && isset($_GET["id"])) {
        $target_path = "../blob/project_images/".$new_file_name;
        $target_path_db = "/blob/project_images/".$new_file_name;

        $prj_result = getProjectByIdAndOwnerId($conn, $_GET["id"], $_SESSION["kuid"]);
        $project = $prj_result->fetch_assoc();

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_path)) {

            if (strcmp($project["PrImage"], "/blob/project_images/default_project_image.png") !== 0) {
                unlink("..".$project["PrImage"]);
            }

            updateProjectImage($conn, $_SESSION["kuid"], $_GET["id"], $target_path_db);

            $prj_id = $project["PRID"];
            redirectTo("../main_app/project-item.php?id=$prj_id");
        }

    } 
    // on todo page
    elseif ($_GET["key"] === "todo" && isset($_GET["id"])) {
        $target_path = "../blob/todo_images/".$new_file_name;
        $target_path_db = "/blob/todo_images/".$new_file_name;

        $todo_result = getTodoByToDoIDAndUserID($conn, $_GET["id"], $_SESSION["kuid"]);
        $todo = $todo_result->fetch_assoc();
        
        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $target_path)) {

            if (strcmp($todo["ToDoImage"], "/blob/todo_images/default_todo_image.png") !== 0) {
                unlink("..".$todo["ToDoImage"]);
            }

            updateToDoImage($conn, $_SESSION["kuid"], $_GET["id"], $target_path_db);

            $td_id = $todo["ToDoID"];
            redirectTo("../main_app/todo-item.php?id=$td_id");
        }
    } 
    // error
    else {
        redirectTo("../main_app/dashboard.php");
    }

} else {
    redirectTo("../main_app/dashboard.php");
}