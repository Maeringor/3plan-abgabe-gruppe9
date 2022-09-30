<?php
require_once '../php_scripts/login-checker.php';
require_once "../php_scripts/db-connect.php";
require_once '../php_scripts/neo4j-connect.php';
require_once "../php_scripts/ProjektDTL.php";
require_once "../php_scripts/UserDTL.php";
require_once "../php_scripts/RoleDTL.php";
require_once "../php_scripts/RolePrjUserDTL.php";
require_once "../php_scripts/ProjektUserDTL.php";
require_once "../php_scripts/combinationAlgorithm.php";
require_once '../php_scripts/globale-functions.php';

if (isset($_GET["id"])) {
    $project_result = getProjectById($conn, $_GET["id"]);
    if ($project_result->num_rows === 1) {
        $project = $project_result->fetch_assoc();
    }
} else {
    redirectTo("project-manager.php");
}

function isUserOwner($prj_id, $uid) {
    return $prj_id === $uid;
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

    <link rel='stylesheet' type='text/css' media='screen' href="/css/project-item.css">

</head>
<body>
    
    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html"?>

        <div class="page-structure">
            <div class="page-content">

                <div class="pm-top-block">
                    <div class="profile-pic-container">
                        <img name="profilePicDisplay" id="profilePicDisplay" src=<?php echo '"'.$project["PrImage"].'"'; ?> alt="" onclick="openImageFileExplorer()" width="200px" height="200px" style="overflow: hidden; border-radius: 999px; cursor: pointer;">
                    </div>
                    <!-- user can add img -->
                    <?php if (isUserOwner($project["KUID"], $_SESSION["kuid"])) { ?>
                        <form action="/php_scripts/processImageUpload.php?key=proj&id=<?php echo $project['PRID']; ?>" method="post" enctype="multipart/form-data">
                            <div class="add-img-container">
                                <input name="profilePic" id="profilePic" type="file" accept=".jpeg,.png,.svg,.jpg" onchange="displayImage(this)" class="profile-image-container" style="display: none;">
                                <button id="saveImg" name="saveImg" type="submit" style="display: none;" class="small-p-app">submit</button>    
                            </div>
                        </form>
                    <?php } ?>
                    
                    <form action="/php_scripts/updateProjectItemDAO.php?id=<?php echo $project["PRID"] ?>" method="POST" class="pm-headline-form">
                        <div class="pm-title-container">
                            <input name="prj-item-title" minlength="1" maxlength="30" type="text" value=<?php echo '"'.$project["PrTitel"].'"'; ?> class="pm-headline-input h2-app">
                        </div>
                        <div class="pm-descr-container">
                            <textarea name="prj-item-text" minlength="1" maxlength="80" id="descr" class="pm-descr regular-p-app" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'><?php echo $project["PrBeschr"] ?></textarea>
                        </div>

                        <!-- save and delte btn -->
                        <?php if (isUserOwner($project["KUID"], $_SESSION["kuid"])) { ?>
                            <div class="pm-save-delete-container">
                            
                                <div class="c-save-btn-container">
                                    <button name="save-prj-item" type="submit" class="save-btn small-p-app">save</button>
                                </div>
                            
                                <form>
                                    <div class="c-delete-btn-container">
                                        <button onclick="sendForm('delete')" type="button" class="delete-btn small-p-app">delete</button>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                        
                    </form>

                    <form id="delete" action="/php_scripts/deleteProjectDAO.php" method="POST">
                        <input name="id" type="hidden" value=<?php echo '"'.$project["PRID"].'"';?>>
                        <input name="delete-prj" type="hidden" value=<?php echo '"'.$project["PRID"].'"';?>>
                    </form>

                    <div class="friend-add-symbole">
                        <div class="fl-sym" onclick="toggleVisibilty()"><img src="/rsc/icons/Lucke_Projekt_WI_1_add_friend.svg" alt=""></div>
                        <div class="friend-add-list" style="display: none;">
                            <?php 
                                $part_result = getUserByProjectId($conn, $project["PRID"]);
                                $part_array = fetchUids($part_result);

                                $final_friend_list = fetchNotAddedFriends($client, $conn, $part_array, $project["KUID"]);

                                function fetchUids($part_assoc) {
                                    $array = [];
                                    while ($item = $part_assoc->fetch_assoc()) {
                                        array_push($array, $item["KUID"]);
                                    }
                                    return $array;
                                }
                            ?>
                            
                            <div class="fl-headline regular-p-app">Add friend</div>
                            <?php foreach ($final_friend_list as $friend => $friend_value) { ?>
                                <div class="friend-item">
                                    <div class="friend-name regular-p-app"><?php echo $friend_value ?></div>
                                    <div class="c-save-btn-container"><button onclick="sendData('prjID=<?php echo $project['PRID']; ?>&uid=<?php echo $friend ?>', '/php_scripts/addUserToProjectDAO.php')" class="save-btn">add</button></div>
                                </div>
                                <div class="fl-uline"></div>
                            <?php } ?>
            
                        </div>
                    </div>

                </div>


                <div class="user-role-table">

                    <?php
                        // fetch table from role-project-user
                        $ur_result = getUserRolesByProjectId($conn, $project["PRID"]);
                    ?>

                    <?php while ($row = $ur_result->fetch_assoc()) { 
                        $user_result = getUserById($conn, $row["KUID"]);
                        $user = $user_result->fetch_assoc();

                        $role_result = getRoleById($conn, $row["ROLEID"]);
                        $role = $role_result->fetch_assoc();

                        $link_get_addition = "prj=".$project["PRID"]."&usr=".$user["KUID"]."&rol=".$role["ROLEID"];
                    ?>
                        <div class="user-role-item big-p-app">
                            <div class="l-block"><?php echo $user["KUname"]; ?></div>
                            <div class="r-block"><?php echo $role["RBeschr"]; ?></div>
                            <div class="delete-ur-item-container">
                                <!-- link with get parameters of role user and project -->
                                <a href="/php_scripts/delete-URP-DAO.php?<?php echo $link_get_addition ?>" class="delete-ur-btn small-p-app">delete</a>
                            </div>
                        </div>
                    <?php } ?>

                </div>

                <form action="/php_scripts/addRoleUserCombinationDAO.php?id=<?php echo $project["PRID"]; ?>" method="post" class="add-ur-form">
                    <div class="add-ur-container">
                        <select name="user" id="user" class="select-user big-p-app">
                            <?php 
                                $owner_id = $project["KUID"];
                                $owner_result = getUserById($conn, $owner_id);
                                $owner = $owner_result->fetch_assoc();
                            ?>
                            <option value=<?php echo '"'.$owner["KUID"].'"'; ?> class="regular-p-app"><?php echo $owner["KUname"]; ?></option>
                            
                            <?php 
                                $user_in_prj_result = getUserByProjectId($conn, $project["PRID"]);
                                while ($user_in_prj = $user_in_prj_result->fetch_assoc()) {
                                    $user_result = getUserById($conn, $user_in_prj["KUID"]);
                                    $user = $user_result->fetch_assoc();
                            ?>
                            <option value=<?php echo '"'.$user_in_prj["KUID"].'"'; ?> class="regular-p-app"><?php echo $user["KUname"]; ?></option>
                            <?php } ?>
                        </select>
                        <select name="roles" id="roles" class="select-roles big-p-app">
                            <?php
                                $role_result = getRoles($conn); 
                                while ($role = $role_result->fetch_assoc()) {   
                            ?>
                            <option value=<?php echo '"'.$role["ROLEID"].'"'; ?> class="regular-p-app"><?php echo $role["RBeschr"]; ?></option>
                            <?php } ?>

                        </select>
                    </div>

                    <div class="c-save-btn-container">
                        <button name="add-role-user-submit" type="submit" class="save-btn small-p-app">add role</button>
                    </div>

                </form>

            </div>
        </div>

    </section>

    <script>
        function toggleVisibilty() {
            var x = document.querySelector('.friend-add-list');
            x.style.display=x.style.display==="none" ? "block" : "none";
        }

        function sendForm(name) {
            document.getElementById(name).submit();
        }
    </script>
    <script src="/js/change-image.js"></script>
    <script src="/js/data-transfer.js"></script>

</body>
</html>