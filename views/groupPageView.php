<?php
$context = $_SERVER["CONTEXT_PREFIX"];
$request = $_SERVER["REQUEST_URI"];
$exploded = explode("/", $request);
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=xduric06;port=/var/run/mysql/mysql.sock", 'xduric06', 'j4sipera');
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    die();
}
/*
$userDataQuery = $db->prepare("SELECT users.user_id, users.user_first_name, users.user_surname FROM users WHERE users.user_id = ?");
$userDataQuery->execute([$exploded[3]]);

while ($userData = $userDataQuery->fetch(PDO::FETCH_ASSOC)) {
    $userId = $userData["user_id"];
    $userFirstname = $userData["user_first_name"];
    $userSurname = $userData["user_surname"];
} 
*/

?>
<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Group</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="items-center h-full main-background-colorscheme " style="min-width: 650px; ">
    <div class="flex flex-col w-full h-full header-colorscheme" style="height: 470px;">
        <?php
        require_once "./components/header.php";
        ?>

        <div class="flex items-center justify-center">
            <div id="cover-photo-element-group" class="mt-0 cursor-pointer brightness-filter" style="width: 650px; height: 250px;">
                <img id="cover-photo-group" src="./views/photos/mountain.jpg" class="w-full h-full" style="object-fit: cover;">
            </div>
        </div>

        <div class="flex items-center justify-center" > 
            <div id="change-cover-photo-group" class="hidden z-1" style="margin-top: -320px;">
                <input type="file" id="cover-photo-input-group" class="hidden" accept="image/*">
                <div class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown cover-photo-menu">
                    <a class="block cursor-pointer header-dropdown-element change-cover-photo-group" >
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-cover-photo-group">
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
        <profile-photo id="profile-photo-element-group" class="z-50 cursor-pointer" style="width: 150px; height: 150px; margin-top: -100px;">
                <img id="profile-photo-group" src="./views/photos/cat.jpg" class="w-full h-full rounded-full brightness-filter" style="object-fit: cover;">
            </profile-photo>
        </div>

        <div class="flex items-center justify-center" > 
            <div id="change-profile-photo-group" class="absolute z-50 hidden" style="margin-top: 100px;">
                <input type="file" id="profile-photo-input-group" class="hidden" accept="image/*">
                <div id="" class="p-2 m-2 mt-4 transition-all rounded-lg header-colorscheme w-fit drop-shadow-xl profile-dropdown">
                    <a class="block cursor-pointer header-dropdown-element change-profile-photo-group" >
                        <span class="pl-1">Change photo</span>
                    </a>
                    <a class="block cursor-pointer header-dropdown-element delete-profile-photo-group" >
                        <span class="pl-1">Delete photo</span>
                    </a>
                </div>
            </div>
        </div>

        <h2 class="flex items-center justify-center mt-2 text-3xl font-bold text-colorscheme name">
            Cats
        </h2>

        <ul class="flex flex-row items-center justify-center p-2 mt-4 text-3xl text-center text-colorscheme drop-shadow" >
            <div class="flex" style=" border-top: thin solid;">
                <div class="flex">
                    <a id="show-group-threads" class="flex items-center justify-center text-xl header-element ">
                        Threads
                    </a>
                </div>
                <div class="flex">
                    <a id="show-group-members" class="flex items-center justify-center text-xl header-element">
                        Members
                    </a>
                </div>

                <div class="flex">
                    <a id="show-group-statistics" class="flex items-center justify-center text-xl header-element">
                        Statistics
                    </a>
                </div>

                <div class="flex">
                    <a id="show-group-about" class="flex items-center justify-center text-xl header-element">
                        About
                    </a>
                </div>
            </div>
        </ul>
    </div>
    
    <div class="items-center main-background-colorscheme ">
        <div id="group-threads" class="hidden">
            <ul>
                <li>Thread 1</li>
                <li>Thread 2</li>
                <li>Thread 3</li>
                <li>Thread 4</li>
                <li>Thread 5</li>
                <li>Thread 6</li>
                <li>Thread 7</li>
            </ul>
        </div>

        <div id="group-statistics" class="hidden">
            <ul>
                <li>stat 1</li>
                <li>stat 2</li>
                <li>stat 3</li>
                <li>stat 4</li>
                <li>stat 5</li>
                <li>stat 6</li>
                <li>stat 7</li>
            </ul>
        </div>
       

        <div id="group-about" class="flex items-center justify-center h-full text-colorscheme">
            <div class="flex flex-row">
                <div class="flex flex-col gap-4 p-4 rounded-lg">
                    <div class="flex flex-col gap-2">
                            <h2 class=""> <a class="text-xl font-bold">Bio: </a>  <span class="text-base font-normal">Group for cat lovers</span></h2>
                    </div>
                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">Created by: </a>  <span class="text-base font-normal">John Doe</span></h2>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class=""> <a class="text-xl font-bold">From: </a>  <span class="text-base font-normal">2022-01-01</span></h2>
                    </div>
                </div> 
            </div>
        </div>
        
        <div id="group-members" class="hidden">
            <ul>
                <li>Member 1</li>
                <li>Member 2</li>
            </ul>
        </div>
    </div>

    <script type="text/javascript" src="./scripts/main.js"></script>
</body>
</html>

<style>
    .brightness-filter:hover {
        filter: brightness(0.75); 
    }
</style>

<script>
    showGroupThreads();    

function hideAllElementsGroup() {
    var ThreadsElementGroup = document.getElementById('group-threads');
    var AboutElementGroup = document.getElementById('group-about');
    var StatisticsElementGroup = document.getElementById('group-statistics');
    var MembersElementGroup = document.getElementById('group-members');

    ThreadsElementGroup.classList.add('hidden');
    AboutElementGroup.classList.add('hidden');
    StatisticsElementGroup.classList.add('hidden');
    MembersElementGroup.classList.add("hidden")
}

function showGroupThreads() {
    hideAllElementsGroup();
    var ThreadsElementGroup = document.getElementById('group-threads');
    ThreadsElementGroup.classList.remove('hidden');
}    

function showGroupMembers() {
    hideAllElementsGroup();
    var MembersElementGroup = document.getElementById('group-members');
    MembersElementGroup.classList.remove('hidden');
}    

function showGroupAbout() {
    hideAllElementsGroup();
    var AboutElementGroup = document.getElementById('group-about');
    AboutElementGroup.classList.remove('hidden');
}

function showGroupStatistics() {
    hideAllElementsGroup();
    var StatisticsElementGroup = document.getElementById('group-statistics');
    StatisticsElementGroup.classList.remove('hidden');
}    

const GroupThreadsButton = document.getElementById('show-group-threads');
GroupThreadsButton.addEventListener('click', showGroupThreads);

const GroupAboutButton = document.getElementById('show-group-about');
GroupAboutButton.addEventListener('click', showGroupAbout);

const GroupStatisticsButton = document.getElementById('show-group-statistics');
GroupStatisticsButton.addEventListener('click', showGroupStatistics);

const GroupMembersButton = document.getElementById('show-group-members');
GroupMembersButton.addEventListener('click', showGroupMembers);

showGroupThreads();

document.addEventListener('DOMContentLoaded', function() {
    var profilePhotoElementGroup = document.getElementById('profile-photo-group');
    var coverPhotoElementGroup = document.getElementById('cover-photo-element-group');
    
    
    if (profilePhotoElementGroup) {
        profilePhotoElementGroup.addEventListener('click', function(event) {
            toggleMenuVisibility('change-profile-photo-group', 'change-cover-photo-group');
            event.stopPropagation();
        });
    }
    
    if (coverPhotoElementGroup) {
        coverPhotoElementGroup.addEventListener('click', function(event) {
            toggleMenuVisibility('change-cover-photo-group', 'change-profile-photo-group');
            event.stopPropagation();
        });
    }

    document.addEventListener('click', function() {
        closeMenuGroup('change-profile-photo-group');
        closeMenuGroup('change-cover-photo-group');
    });

    document.querySelector('.change-profile-photo-group').addEventListener('click', function(event) {
        changeProfilePhotoGroup();
        event.stopPropagation(); 
    });

    document.querySelector('.delete-profile-photo-group').addEventListener('click', function(event) {
        deleteProfilePhotoGroup();
        event.stopPropagation(); 
    });

    document.querySelector('.change-cover-photo-group').addEventListener('click', function(event) {
        changeCoverPhotoGroup();
        event.stopPropagation(); 
    });

    document.querySelector('.delete-cover-photo-group').addEventListener('click', function(event) {
        deleteCoverPhotoGroup();
        event.stopPropagation(); 
    });
});

function toggleMenuVisibility(showMenuId, hideMenuId) {
    var menuToShow = document.getElementById(showMenuId);
    var menuToHide = document.getElementById(hideMenuId);
    if (menuToShow) menuToShow.classList.toggle('hidden');
    if (menuToHide && !menuToHide.classList.contains('hidden')) {
        menuToHide.classList.add('hidden');
    }
}

function closeMenu(menuId) {
    var menuToClose = document.getElementById(menuId);
    if (menuToClose && !menuToClose.classList.contains('hidden')) {
        menuToClose.classList.add('hidden');
    }
}

function changeProfilePhotoGroup() {
    var fileInput = document.getElementById('profile-photo-input-group');
    fileInput.click();

    fileInput.onchange = function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var profilePhotoGroup = document.getElementById('profile-photo-group');
            profilePhotoGroup.src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    };
}

function deleteProfilePhotoGroup() {
    var profilePhotoGroup = document.getElementById('profile-photo-group');
    profilePhotoGroup.src = ''; 
}

function changeCoverPhotoGroup() {
    var fileInput = document.getElementById('cover-photo-input-group');
    fileInput.click();

    fileInput.onchange = function(event) {
        var file = event.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            var coverPhotoGroup = document.getElementById('cover-photo-group');
            coverPhotoGroup.src = e.target.result;
        };
        
        reader.readAsDataURL(file);
    };
}

function deleteCoverPhotoGroup() {
    var coverPhotoGroup = document.getElementById('cover-photo-group');
    coverPhotoGroup.src = '';
}
</script>
