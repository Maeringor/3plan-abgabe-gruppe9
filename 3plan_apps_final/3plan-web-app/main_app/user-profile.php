<?php
require_once "../php_scripts/login-checker.php";
require_once "../php_scripts/db-connect.php";
require_once "../php_scripts/UserDTL.php";
require_once "../php_scripts/UserAdressDTL.php";

$userID = $_GET["id"];

$user = getUserById($conn, $userID)->fetch_assoc();
$userAddress = getUserAdressByUserID($conn, $userID)->fetch_assoc();

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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/user-profile.css'>

</head>
<body>
    
    <section class="content-main-app">

        <!--app nav bar-->
       <!-- <?php require_once "../html_structures/app-nav.html"?> -->

       <div class="page-structure">
        <div class="page-content">

            <div class="headline-container">
                <div class="left-block">
                    <h1 class="app-headline h1-app">Profile</h1>
                    <div class="user-name h2-app"><?php echo $user["KUname"]?></div>
                    
                </div>
                <div class="right-block">
                    <h1 class="today h1-app">Today</h1>
                    <div class="time-date h2-app">13:02 13.08.2022</div> 
                </div>
            </div>

            <div class="content-section profile-infos">
                <div class="headline-container">
                    <div class="cs-headline h2-app">Information</div>
                    <div class="cs-headline h2-app">Profile Picture</div>
                 </div>

                <div class="pi-top-block">
                    <div class="pi-left-block">
                        <form action="" class="uname-form" method="POST">
                            <div class="basic-input-container">
                                <label for="username" class="special-input-lable big-p-app">Username</label>
                                <input name="username" type="text" class="basic-input big-p-app" value="<?php echo $user["KUname"]?>" readonly>
                            </div>
                        </form>
                        <div class="basic-input-container">
                            <label for="email" class="special-input-lable big-p-app">Email</label>
                            <input name="email" type="email" class="basic-input big-p-app" value="<?php echo $user["Kmail"]?>" readonly>
                        </div>
                    </div>

                    <div class="pi-right-block">
                        <div class="profile-pic-container">
                            <img name="profilePicDisplay" id="profilePicDisplay" src="<?php echo $user["KProfileImage"] ?>" alt="" width="200px" height="200px" style="overflow: hidden; border-radius: 999px; cursor: pointer; background-color: lightblue">
                        </div>
                    </div>

                </div>

                <div class="pi-mid-block">
                    <div class="pi-left-block">
                        <form action="" class="fullname-form" method="POST">
                            <div class="basic-input-container">
                                <label for="fullname" class="special-input-lable big-p-app">Full Name</label>
                                <input name="fullname" type="text" class="basic-input big-p-app" value="<?php echo $user["KName"]?>" readonly>
                            </div>
                        </form>
                        <form action="" class="street-form" method="POST">
                            <div class="basic-input-container">
                                <label for="street" class="special-input-lable big-p-app">Street, Number</label>
                                <input name="street" type="text" class="basic-input big-p-app" value="<?php echo $userAddress["KuStrasseNr"]?>" readonly>
                            </div>
                        </form>
                    </div>

                    <div class="pi-right-block">
                        <form action="" class="address-form" method="POST">
                            <div class="basic-input-container">
                                <label for="address" class="special-input-lable big-p-app">Address</label>
                                <input name="address" type="text" class="basic-input big-p-app" value="<?php echo $userAddress["KuPLZOrt"]?>" readonly>
                            </div>
                        </form>
                        <form action="" class="country-form" method="POST">
                            <div class="basic-input-container">
                                <label for="country" class="special-input-lable big-p-app">Country</label>
                                <input name="country" type="text" class="basic-input big-p-app" value="<?php echo $userAddress["KuLand"]?>" readonly>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
       </div>

    </section>

    <script src="/js/time-loader.js"></script>
    <script src="/js/change-image.js"></script>

</body>
</html>