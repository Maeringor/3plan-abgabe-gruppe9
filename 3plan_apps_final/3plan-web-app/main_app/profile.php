<?php
require_once "../php_scripts/login-checker.php";
require_once "../php_scripts/UserAdressDTL.php";
require_once "../php_scripts/db-connect.php";

$result = getUserAdressByUserID($conn, $_SESSION["kuid"]);
$userAdress = $result->fetch_assoc();

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

    <link rel='stylesheet' type='text/css' media='screen' href='/css/profile.css'>

</head>

<body>

    <section class="content-main-app">

        <!--app nav bar-->
        <?php require_once "../html_structures/app-nav.html" ?>

        <div class="page-structure">
            <div class="page-content">

                <div class="headline-container">
                    <div class="left-block">
                        <h1 class="app-headline h1-app">Your Profile</h1>
                        <div class="user-name h2-app"><?php echo $_SESSION["kuname"]; ?></div>

                    </div>
                    <div class="right-block">
                        <h1 class="today h1-app">Today</h1>
                        <div class="time-date h2-app">13:02 13.08.2022</div>
                    </div>
                </div>

                <div class="content-section profile-infos">
                    <div class="cs-headline h2-app">Your Information</div>

                    <div class="pi-top-block">
                        <div class="pi-left-block">
                            <form action="../php_scripts/UserChangeDAO.php" class="uname-form" method="POST">
                                <div class="basic-input-container">
                                    <label for="username" class="special-input-lable big-p-app">Username</label>
                                    <input name="username" type="text" class="basic-input big-p-app" minlength="1" maxlength="30"
                                        value="<?php echo $_SESSION["kuname"]; ?>">
                                </div>
                                <div class="c-enter-btn-container"><button id="changeUsernameBTN"
                                        name="changeUsernameBTN" class="c-enter-link small-p-app">change</button></div>
                            </form>
                            <div class="basic-input-container">
                                <label for="email" class="special-input-lable big-p-app">Email</label>
                                <input name="email" type="email" class="basic-input big-p-app"
                                    value="<?php echo $_SESSION["kmail"]; ?>" readonly>
                            </div>
                        </div>

                        <div class="pi-right-block">
                            <div class="profile-pic-container">
                                <img name="profilePicDisplay" id="profilePicDisplay" src=<?php echo '"'.$_SESSION["kprofileimage"].'"'; ?> alt="" onclick="openImageFileExplorer()" width="200px" height="200px" style="overflow: hidden; border-radius: 999px; cursor: pointer;">
                            </div>
                            <!-- user can add img -->
                            <form action="/php_scripts/processImageUpload.php?key=user" method="POST" enctype="multipart/form-data">
                                <input name="profilePic" id="profilePic" type="file" accept=".jpeg,.png,.svg,.jpg" onchange="displayImage(this)" class="profile-image-container" style="display: none;">
                                <button id="saveImg" name="saveImg" type="submit" style="display: none;" class="small-p-app">submit</button>
                            </form>
                        </div>

                    </div>

                    <div class="pi-mid-block">
                        <div class="pi-left-block">
                            <form action="../php_scripts/UserChangeDAO.php" class="fullname-form" method="POST">
                                <div class="basic-input-container">
                                    <label for="fullname" class="special-input-lable big-p-app">Full Name</label>
                                    <input name="fullname" type="text" class="basic-input big-p-app" minlength="1" maxlength="40"
                                        value="<?php echo $_SESSION["kname"]; ?>">
                                </div>
                                <div class="c-enter-btn-container"><button id="changeNameBTN" name="changeNameBTN"
                                        class="c-enter-link small-p-app">change</button></div>
                            </form>
                            <form action="../php_scripts/UserChangeDAO.php" class="street-form" method="POST">
                                <div class="basic-input-container">
                                    <label for="street" class="special-input-lable big-p-app">Street, Number</label>
                                    <input name="street" type="text" class="basic-input big-p-app" maxlength="50"
                                        value="<?php echo $userAdress["KuStrasseNr"]; ?>">
                                </div>
                                <div class="c-enter-btn-container"><button id="changeStreetBTN" name="changeStreetBTN"
                                        class="c-enter-link small-p-app">change</button></div>
                            </form>
                        </div>

                        <div class="pi-right-block">
                            <form action="../php_scripts/UserChangeDAO.php" class="address-form" method="POST">
                                <div class="basic-input-container">
                                    <label for="address" class="special-input-lable big-p-app">Address</label>
                                    <input name="address" type="text" class="basic-input big-p-app" maxlength="50"
                                        value="<?php echo $userAdress["KuPLZOrt"]; ?>">
                                </div>
                                <div class="c-enter-btn-container"><button id="changeAddressBTN" name="changeAddressBTN"
                                        class="c-enter-link small-p-app">change</button></div>
                            </form>
                            <form action="../php_scripts/UserChangeDAO.php" class="country-form" method="POST">
                                <div class="basic-input-container">
                                    <label for="country" class="special-input-lable big-p-app">Country</label>
                                    <input name="country" type="text" class="basic-input big-p-app" maxlength="30"
                                        value="<?php echo $userAdress["KuLand"]; ?>">
                                </div>
                                <div class="c-enter-btn-container"><button id="changeCountryBTN" name="changeCountryBTN"
                                        class="c-enter-link small-p-app">change</button></div>
                            </form>
                        </div>
                    </div>

                    <div class="pi-bottom-block">
                        <form action="/php_scripts/UserDeleteDAO.php" method="POST">
                            <div class="c-delete-btn-container">
                                <button id="deleteUserBTN" name="deleteUserBTN" type="submit" class="delete-btn small-p-app">delete</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <script src="/js/time-loader.js"></script>
    <script src="/js/change-image.js"></script>

</body>

</html>