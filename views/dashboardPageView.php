<?php
$context = $_SERVER["CONTEXT_PREFIX"];
require "./scripts/services.php";

session_start();
?>

<!DOCTYPE html>
<html class="h-full">

<head>
    <title>Threads demo</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= $context ?>/dist/style.css" rel="stylesheet">
    <!-- stylesheet for animated tab view -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <script src="https://kit.fontawesome.com/56e0bbdeed.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= $context ?>/scripts/darkModeSetter.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body class="h-full">
  <!-- CONTAINER -->
  <div class="flex flex-col h-full main-background-colorscheme text-colorscheme">
    <?php
    require_once "./components/header.php"
    ?>

    <!-- SIDEBAR -->
    <!-- Modified version of: https://www.w3schools.com/w3css/tryit.asp?filename=tryw3css_tabulators_animate -->
    <div class="w3-sidebar w3-bar-block header-colorscheme w3-card pt-14 w-80" style="width:18rem">
      <h3 class="font-bold p-4">Admin Dashboard</h1>
      <button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'Users')">Users</button>
      <button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'Groups')">Groups</button>
    </div>

    <!-- Tab Content  -->
    <div class="px-24 py-4 ml-52">
      <div id="Users" class="w3-container city w3-animate-left" style="display:none">
        <h2 class="font-bold">List of Users</h2>
        <table class="table-auto hover:table-fixed">
            <tr>
                <th>User Fullname</th>
                <th>User Login</th>
            </tr>

            <?php
            $serv = new AccountService();
            $rows = $serv->listAllUsers();

            // TODO: user_id change to user_login after db update
            while ($row = $rows->fetch())
            {
                echo "<tr>";
                echo "<td>" . $row['user_full_name'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "</tr>\n";
            }
            ?>
        </table>
      </div> <!-- Users  -->

      <div id="Groups" class="w3-container city w3-animate-left" style="display:none">
        <h2 class="font-bold">List of Groups</h2>
        <table>
            <tr>
                <th>Group Name</th>
                <th>Group Login</th>
            </tr>

            <?php
            $serv = new AccountService();
            $rows = $serv->listAllGroups();

            // TODO: user_id change to user_login after db update
            while ($row = $rows->fetch())
            {
                echo "<tr>";
                echo "<td>" . $row['group_name'] . "</td>";
                echo "<td>" . $row['group_id'] . "</td>";
                echo "</tr>\n";
            }
            ?>
        </table>
      </div> <!-- Groups  -->
    </div> <!-- Tab Content  -->
  </div> <!-- CONTAINER  -->
  <script type="text/javascript" src="<?= $context ?>/scripts/main.js"></script>
</body>

</html>