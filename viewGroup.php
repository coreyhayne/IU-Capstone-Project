<?php
session_start();
$passedId = $_GET['groupId'];

$con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
// Check Connection
if (!$con) {
       die("Connection failed: " . mysqli_connect_error() . "<br>");
}

$var_message= mysqli_real_escape_string($con,trim($_POST['new-message']));

if(isset($_POST['rvt-button'])) {
       $sql2 = "insert into Chat (chatDate,chatTime,chatText) VALUES (CURDATE(),CURTIME(), '$var_message');";
       
       if (mysqli_query($con, $sql2)) {
        $chat_id = mysqli_insert_id($con);

        $sql3 = "insert into Created_Chat (chatId,groupId,userId) VALUES ($chat_id, $passedId, '{$_SESSION['userId']}');";
        mysqli_query($con, $sql3);

      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }      
}


$con->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google-signin-client_id"
        content="726609449658-g6s5m9hit9pjgpg5h7o5s2ov9n6at041.apps.googleusercontent.com">

    <title>UniLife: Group Profile</title>
    <link rel="shortcut icon" type="images/png" href="images/favicon.ico" />
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://assets.uits.iu.edu/css/rivet/1.7.2/rivet.min.css">
    <script src="https://assets.uits.iu.edu/javascript/rivet/1.8.0/rivet.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
<script>
    var passedId = "<?php echo $passedId; ?>";
</script>
    <script src='js/team20.js'></script>
    <!-- TOP NAV BAR -->
    <!-- ======================================================================================================================== -->

    <header class="rvt-header" role="banner">
        <a class="rvt-skip-link" href="#main-content">Skip to content</a>
        <!-- Trident -->
        <div class="rvt-header__trident">
            <svg class="rvt-header__trident-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41 48"
                aria-hidden="true">
                <title id="iu-logo">Indiana University Logo</title>
                <rect width="41" height="48" fill="#900" />
                <polygon
                    points="24.59 12.64 24.59 14.98 26.34 14.98 26.34 27.78 22.84 27.78 22.84 10.9 24.59 10.9 24.59 8.57 16.41 8.57 16.41 10.9 18.16 10.9 18.16 27.78 14.66 27.78 14.66 14.98 16.41 14.98 16.41 12.64 8.22 12.64 8.22 14.98 9.97 14.98 9.97 30.03 12.77 33.02 18.16 33.02 18.16 36.52 16.41 36.52 16.41 39.43 24.59 39.43 24.59 36.52 22.84 36.52 22.84 33.02 28 33.02 31.01 30.03 31.01 14.98 32.78 14.98 32.78 12.64 24.59 12.64"
                    fill="#fff" />
            </svg>
        </div>
        <!-- App title -->
        <span class="rvt-header__title">
            <a href="home.php">UniLife</a>
        </span>
        <!-- Wrapper for header interactive elements -->
        <div class="rvt-header__controls">
            <!-- Main inline nav element -->
            <nav class="rvt-header__main-nav" role="navigation">
                <ul>
                    <li><a href="home.php"> <i class="fa fa-home"></i></a></li>
                    <li>
                    <span class="rvt-badge rvt-badge--info rvt-m-left-xxs">
                        <?php 
                            $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                            // Check connection
                            if (mysqli_connect_errno())
                                {echo "Failed to connect to MySQL: " . mysqli_connect_errno() . "<br>";}

                                $notiNumber = mysqli_query($con, "SELECT notificationId from Notification where userId = '{$_SESSION['userId']}' and interacted is NULL");
                                if (mysqli_num_rows($notiNumber) > 0) {
                                    echo mysqli_num_rows($notiNumber);
                                } else {
                                    echo '0';
                                }
                                
                            ?>
                        </span>
                        <div class="rvt-dropdown">
                            <button type="button" class="rvt-dropdown__toggle" data-dropdown-toggle="dropdown-2" aria-haspopup="true" aria-expanded="false">
                                <span class="rvt-dropdown__toggle-text"><i class="fa fa-bell"></i></span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path fill="currentColor" d="M8,12.46a2,2,0,0,1-1.52-.7L1.24,5.65a1,1,0,1,1,1.52-1.3L8,10.46l5.24-6.11a1,1,0,0,1,1.52,1.3L9.52,11.76A2,2,0,0,1,8,12.46Z"/>
                                </svg>
                            </button>
                            <div class="rvt-dropdown__menu" id="dropdown-2" role="menu" aria-hidden="true">
                                <ul>
                                <?php
                                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                    // Check connection
                                    if (mysqli_connect_errno())
                                        {echo "Failed to connect to MySQL: " . mysqli_connect_errno() . "<br>";}
    
                                        $notis = "SELECT n.notificationId, n.notificationType, n.details, n.groupId, e.eventDate, e.location, e.startTime, e.endTime, g.groupName
                                        from Notification as n join Event as e on e.Id=n.eventId join Groups as g on g.groupId=n.groupId Where n.userId = '{$_SESSION['userId']}' and interacted is NULL
                                        UNION
                                        Select n.notificationId, n.notificationType, n.details, n.groupId, crr.reservationDate, b.name, crr.startTime, crr.endTime, g.groupName
                                        from Notification as n join Collab_Room_Reservation as crr on crr.Id=n.reservationId
                                        join Collab_Room as c on c.roomId=crr.roomId join Collab_Building as b on b.buildingId=c.buildingId
                                        join Groups as g on g.groupId=n.groupId Where n.userId = '{$_SESSION['userId']}' and interacted is NULL ORDER BY notificationId DESC;";
    
                                    $result = mysqli_query($con, $notis);
    
                                    $notiIdArray = array();
                                    $notiTypeArray = array();
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                                $notiId = $row['notificationId'];
                                                $notiType = $row['notificationType'];
                                                array_push($notiIdArray,$notiId);
                                                array_push($notiTypeArray,$notiType);
                                        } for ($i = 0; $i < sizeof($notiIdArray); $i++) {
                                            echo '<button type="button" class="rvt-button rvt-button--plain" data-modal-trigger="'.$notiIdArray[$i].'">'.$notiTypeArray[$i].'</button>';
                                        }
                                        echo '</ul></div></div></li></ul></nav>';
    
                                        for ($i = 0; $i < sizeof($notiIdArray); $i++) {
                                            echo'<div class="rvt-modal" id="'.$notiIdArray[$i].'" role="dialog" aria-labelledby="modal-example-title" aria-hidden="true" tabindex=-1>
                                            <div class="rvt-modal__inner">
                                            <header class="rvt-modal__header">
                                            <h1 class="rvt-modal__title" id="modal-example-title">Notification Details</h1>
                                            </header>
                                            <div class="rvt-modal__body">';
    
                                            $notification = 'SELECT n.notificationId, n.notificationType, n.details, DATE_FORMAT(e.eventDate, "%M %d, %Y") as eventDate, e.location, TIME_FORMAT(e.startTime, "%r") as startTime, TIME_FORMAT(e.endTime, "%r") as endTime, g.groupName
                                            from Notification as n
                                            join Event as e on e.Id=n.eventId
                                            join Groups as g on g.groupId=n.groupId
                                            Where n.notificationId = '.$notiIdArray[$i].'
                                            UNION
                                            SELECT n.notificationId, n.notificationType, n.details, DATE_FORMAT(crr.reservationDate, "%M %d, %Y") as reservationDate, b.name, TIME_FORMAT(crr.startTime, "%r") as startTime, TIME_FORMAT(crr.endTime, "%r") as endTime, g.groupName
                                            from Notification as n
                                            join Collab_Room_Reservation as crr on crr.Id=n.reservationId
                                            join Collab_Room as c on c.roomId=crr.roomId
                                            join Collab_Building as b on b.buildingId=c.buildingId
                                            join Groups as g on g.groupId=n.groupId
                                            Where n.notificationId = '.$notiIdArray[$i].'
                                            ORDER BY notificationId DESC;';
        
                                            $result= $con->query($notification);
                                            $value = mysqli_fetch_object($result);
    
                                            $type = $value->notificationType;
                                            $startTime = $value->startTime;
                                            $endTime = $value->endTime;
                                            $details = $value->details;
                                            $groupName = $value->groupName;
                                            $eventDate = $value->eventDate;
                                            $eventLocation = $value->location;
                                            $collabDate = $value->reservationDate;
                                            $collabLocation = $value->name;
    
                                            echo "<p>Group: ".$groupName."</p>";
                                            echo "<p>Location: ".$eventLocation."".$collabLocation."</p>";
                                            echo "<p>Date: ".$eventDate."".$collabDate."</p>";
                                            echo "<p>Start Time: ".$startTime."</p>";
                                            echo "<p>End Time: ".$endTime."</p>";
                                            echo "<p>Details: ".$details."</p>";
    
                                            echo'<form method="POST"></div>
                                                <div class="rvt-modal__controls">
                                                <button class="rvt-button" name="submit" value="'.$notiIdArray[$i].'">Accept</button>
                                                <button class="rvt-button rvt-button--secondary" name="dismiss" value="'.$notiIdArray[$i].'">Dismiss</button>
                                                </div>
                                                <button type="button" class="rvt-button rvt-modal__close" data-modal-close="'.$notiIdArray[$i].'">
                                                <span class="rvt-sr-only">Close</span>
                                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                                    <path fill="currentColor" d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z"/>
                                                </svg>
                                                </button>
                                                </div>
                                                </div></form>';
                                            if ($_POST['submit'] == $notiIdArray[$i]) {
                                                $updateAccept = "UPDATE Notification SET interacted = 'accepted' WHERE notificationId = $notiIdArray[$i]";
                                                mysqli_query($con, $updateAccept);
                                            }
                                            if ($_POST['dismiss'] == $notiIdArray[$i]) {
                                                $updateDismiss = "UPDATE Notification SET interacted = 'declined' WHERE notificationId = $notiIdArray[$i]";
                                                mysqli_query($con, $updateDismiss);
                                            }
                                        }
    
                                    } else {
                                        echo "<li>no notifications</li>";
                                        echo '</ul></div></div></li></ul></nav>';
                                    }       
                            ?>
            <!-- ID menu w/ dropdown -->
            <div class="rvt-header-id">
                <div class="rvt-dropdown">
                    <button type="button"
                        class="rvt-header-id__profile rvt-header-id__profile--has-dropdown rvt-dropdown__toggle"
                        data-dropdown-toggle="id-dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="rvt-header-id__avatar" aria-hidden="true">
                        <?php
                                $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                // Check Connection
                                if (!$con) {
                                    die("Connection failed: " . mysqli_connect_error() . "<br>");
                                }
                                $get_fname = "Select LEFT(fname,1) AS get_fname from User WHERE email='{$_SESSION['email']}'";
                                $get_lname = "Select LEFT(lname,1) AS get_lname from User WHERE email='{$_SESSION['email']}'";
                                $result1= $con->query($get_fname);
                                $value1 = mysqli_fetch_object($result1);
                                $get_fname = $value1->get_fname;
                            
                                $result2= $con->query($get_lname);
                                $value2 = mysqli_fetch_object($result2);
                                $get_lname = $value2->get_lname;
                                echo $get_fname;
                                echo $get_lname;
                                $con->close();
                            ?>
                        </span>
                        <span class="rvt-header-id__user">

			 <?php
                                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                    // Check Connection
                                    if (!$con) {
                                        die("Connection failed: " . mysqli_connect_error() . "<br>");
                                    }
		                    $fname = "Select fname FROM User WHERE email='{$_SESSION['email']}'";
				    $result= $con->query($fname);
				    $value= mysqli_fetch_object($result);
				    $fname=$value->fname;
				    echo $fname;
				    $con->close();
			?>
	

			</span>
                        <svg aria-hidden="true" class="rvt-m-left-xs" xmlns="http://www.w3.org/2000/svg" width="16"
                            height="16" viewBox="0 0 16 16">
                            <path fill="currentColor"
                                d="M8,12.46a2,2,0,0,1-1.52-.7L1.24,5.65a1,1,0,1,1,1.52-1.3L8,10.46l5.24-6.11a1,1,0,0,1,1.52,1.3L9.52,11.76A2,2,0,0,1,8,12.46Z" />
                        </svg>
                    </button>
                    <div class="rvt-dropdown__menu rvt-header-id__menu" id="id-dropdown" aria-hidden="true">
                    <a href="viewUser.php">My Profile</a>
                        <div role="group" aria-label="User actions">
                            <a href="logout.php">Log out</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Drawer close button - shows on small screens -->
            <button type="button" class="rvt-drawer-button" aria-haspopup="true" aria-expanded="false"
                data-drawer-toggle="mobile-drawer-3">
                <span class="sr-only">Toggle menu</span>
                <svg aria-hidden="true" class="rvt-drawer-button-open" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16">
                    <g fill="currentColor">
                        <path d="M15,3H1A1,1,0,0,1,1,1H15a1,1,0,0,1,0,2Z" />
                        <path d="M15,9H1A1,1,0,0,1,1,7H15a1,1,0,0,1,0,2Z" />
                        <path d="M15,15H1a1,1,0,0,1,0-2H15a1,1,0,0,1,0,2Z" />
                    </g>
                </svg>
                <svg aria-hidden="true" class="rvt-drawer-button-close" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 16 16">
                    <path fill="currentColor"
                        d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z" />
                </svg>
            </button>
        </div>
        <!--
        Drawer - small screens only
        NOTE: If we are going to give people the option to use the drawer
        on desktop as well, a combo of duplicating markup and showing/hiding
        is probably the best way to handle that kind of flexibility.
        We'll just need to be clear about it in the documentation.
    -->
        <div class="rvt-drawer" aria-hidden="true" id="mobile-drawer-3">
            <!-- Drawer nav -->
            <nav class="rvt-drawer__nav" role="navigation">
                <ul>
                    <li>
                        <div class="rvt-header-id__profile rvt-header-id__profile--drawer">
                            <span class="rvt-header-id__avatar" aria-hidden="true">JC</span>
                            <span class="rvt-header-id__user">James</span>
                            <a href="logout.php" class="rvt-header-id__log-out" onclick="signOut()">Log out</a>
                        </div>
                    </li>
                    <!-- <li>
                        <a href="#">Nav one</a>
                    </li> -->
                    <li>
                        <a href='#'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                aria-hidden="true">
                                <path fill="currentColor"
                                    d="M14.57,12.06,13,9.7V6A5,5,0,0,0,3,6V9.7L1.43,12.06a1.25,1.25,0,0,0,1,1.94H6a2,2,0,0,0,4,0h3.53a1.25,1.25,0,0,0,1-1.94ZM8,12H3.87L5,10.3V6a3,3,0,0,1,6,0v4.3L12.13,12Z" />
                            </svg>
                            <span class='text'>Notifications</span></a>
                    </li>
                    <li class="has-children">
                        <button type="button" data-subnav-toggle="subnav-simple-1" aria-haspopup="true"
                            aria-expanded="false"><i class="fa fa-th-large"></i><span class="text"> My
                                Groups</span></button>

                        <div id="subnav-simple-1" role="menu" aria-hidden="true">
                            <ul>
                                <?php
                            $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                            // Check Connection
                            if (!$con) {
                                die("Connection failed: " . mysqli_connect_error() . "<br>");
                            }

                            $groups = mysqli_query($con,"SELECT g.groupId, g.groupName from Groups as g
                            Left Join User_Joined_Group as usg on usg.groupId=g.groupId
                            Where usg.userId = '{$_SESSION['userId']}';");

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($groups)) {
                                        $groupId = $row['groupId'];
                                        $group = $row['groupName'];
                                        echo "<li><a href='viewGroup.php'>$group</a></li>";
                                }
                            } else {
                                echo "<li><a href='#'>Not in a Group</a></li>";
                            }
                            ?>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="calendar.php">
                            <i class="fa fa-table"></i>
                            <span class='text'>Calendar<span>
                        </a>
                    </li>
                    <li>
                        <a href="room-book.php">
                            <i class="fa fa-clock-o"></i>
                            <span class='text'>Book Collaboration Room</span>
                        </a>
                    </li>
                    <li>
                        <a href="explore.php">
                            <i class="fa fa-search"></i>
                            <span class='text'>Explore</span>
                        </a>
                    </li>
                </ul>
                <button type="button" class="rvt-drawer__bottom-close">Close nav</button>
            </nav>
        </div>
    </header>
 <!-- LEFT VERTICAL NAV BAR -->
    <!-- ======================================================================================================================== -->
    <div class='all-body-container'>
    <!-- adding flexbox -->
    <div class="rvt-flex rvt-wrap">
        <!-- setting responsive breakpoints -->
        <div class='rvt-hide-lg-down rvt-m-right-sm'>
            <nav class="rvt-menu rvt-menu--vertical">
                <ul class="rvt-menu__list">
                    <li class="rvt-menu__item">
                        <div class="rvt-dropdown">
                            <button type="button" class="rvt-dropdown__toggle" data-dropdown-toggle="dropdown-1">
                                <i class="fa fa-th-large"></i><span> My Groups</span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <title>Dropdown icon</title>
                                    <path fill="currentColor"
                                        d="M8,12.46a2,2,0,0,1-1.52-.7L1.24,5.65a1,1,0,1,1,1.52-1.3L8,10.46l5.24-6.11a1,1,0,0,1,1.52,1.3L9.52,11.76A2,2,0,0,1,8,12.46Z" />
                                </svg>
                            </button>
                            <script type="text/javascript"> 

                            function buttonClicked(groupId, userId){
                                $.ajax({
                                    type: "POST",
                                    url: "updateFavoritedGroup.php",
                                    data: { groupId: groupId, userId: userId }
                                }).done(function( groupId ) {
                                    console.log(groupId);
                                    $("#group"+groupId).toggleClass('fa-heart-o');
                                    $("#group"+groupId).toggleClass('fa-heart');
                                });
                            }
                            </script>
                            
    
                            <div class="rvt-dropdown__menu" id="dropdown-1" role="menu" aria-hidden="true">
                            <ul>
                                <?php
                                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                    // Check Connection
                                    if (!$con) {
                                        die("Connection failed: " . mysqli_connect_error() . "<br>");
                                    }
                                    $groups = mysqli_query($con,"SELECT g.groupId, g.groupName, CASE WHEN ufg.id IS NULL THEN 'fa-heart-o' WHEN ufg.id IS NOT NULL THEN 'fa-heart' END as favorited
                                     from Groups as g                                     
                                     Left Join User_Joined_Group as usg on usg.groupId=g.groupId                                     
                                     Left Join User_Favorited_Group as ufg on g.groupId =ufg.groupId and ufg.UserId = usg.UserId 
                                     where usg.UserId = '{$_SESSION['userId']}';");

                                    $add = "INSERT INTO User_Favorited_Group (groupId, userId) VALUES ($id_list[$i],'{$_SESSION['userId']}')";
                                    //mysqli_query($con,$add);
                                    $remove = "DELETE from User_Favorited_Group Where userId='{$_SESSION['userId']}'";
                                    //mysqli_query($con,$remove);

                                    if (mysqli_num_rows($groups) > 0) {
                                        while ($row = mysqli_fetch_assoc($groups)) {
                                            $groupId = $row['groupId'];
                                            $group = $row['groupName'];
                                            $favoritedClass = $row['favorited'];
                                            
                                            echo '<div class="rvt-container">
                                                    <div class="rvt-grid">
                                                        <div class="rvt-grid__item-9-md-up">
                                                            <button class="rvt-button" onclick="ContentPage(this)" rvt-button--plain" value="'.$groupId.'">'.$group.'</button>
                                                        </div>
                                                        <div class="rvt-grid__item-3-md-up">
                                                            <div class="rvt-button-full" onclick="buttonClicked('.$groupId.', '.$_SESSION['userId'].')">
                                                                <div class="rvt-button-plain rvt-button-full rvt-button--small">
                                                                    <i class="fa '.$favoritedClass.'" id=group'.$groupId.'></i>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }
                                    } else {
                                        echo "<li>Not in a Group</li>";
                                    }
                                ?> 
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="rvt-menu__item">
                        <a href="calendar.php">
                            <i class="fa fa-table"></i>
                            <span>Calendar<span>
                        </a>
                    </li>
                    <li class="rvt-menu__item">
                        <a href="room-book.php">
                            <i class="fa fa-clock-o"></i>
                            <span>Book Collaboration Room</span>
                        </a>
                    </li>
                    <li class="rvt-menu__item">
                        <div class="rvt-dropdown">
                            <button type="button" class="rvt-dropdown__toggle" data-dropdown-toggle="explore-dropdown">
                                <i class="fa fa-search"></i><span> Explore</span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <title>Dropdown icon</title>
                                    <path fill="currentColor"
                                        d="M8,12.46a2,2,0,0,1-1.52-.7L1.24,5.65a1,1,0,1,1,1.52-1.3L8,10.46l5.24-6.11a1,1,0,0,1,1.52,1.3L9.52,11.76A2,2,0,0,1,8,12.46Z" />
                                </svg>
                            </button>
                            <div class="rvt-dropdown__menu" id="explore-dropdown" role="menu" aria-hidden="true">
                                <ul>
                                <li><a href='exploreUser.php'>Users</a></li>
                                <li><a href='exploreGroup.php'>Groups</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- MIDDLE BODY -->
        <!-- ======================================================================================================================== -->
        <div class="rvt-middle-body rvt-grow-1 rvt-m-right-sm">
        <form method="POST" action="#" onsubmit="return ContentPage2(passedId);">
                    <div class="group-data">
                    <div class="rvt-flex rvt-wrap">
                        <div class="rvt-display-flex rvt-wrap rvt-width-md">
                        <div class="rvt-box__avatar update-photo">
                        <?php
                        $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        // Check Connection
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error() . "<br>");
                        }
                        $get_fname = "SELECT LEFT(groupName,1) AS get_fname from Groups WHERE groupId='$passedId'";
                        // $get_lname = "SELECT LEFT(lname,1) AS get_lname from User WHERE userId='$ids[$i]'";
                        $result1= $con->query($get_fname);
                                    $value1 = mysqli_fetch_object($result1);
                                    $get_fname = $value1->get_fname;
				
                    echo '<div class="abbr-div"><b class="abbr">'.$get_fname.'</b></div>';
				   ?>

                    </div>
                        <div class="rvt-width-md group-name">
                        <?php
                        $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        // Check Connection
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error() . "<br>");
                        }

                        $sql = "SELECT groupName FROM Groups WHERE groupId='$passedId'";
                        $result= $con->query($sql);
                                $value = mysqli_fetch_object($result);
                                $gn = $value->groupName;
                                echo '<b>'.$gn.'</b>';
                                // echo $passedId;
                                // group event 
                                $query = mysqli_query($con,"SELECT * FROM Group_Managers WHERE userId='{$_SESSION['userId']}' AND groupId = '$passedId';");
                                if (mysqli_num_rows($query) > 0) {
                                    while($row = mysqli_fetch_assoc($query)){
                                        echo '<br><br><button type="button" class="rvt-button" data-modal-trigger="group event">Create Group Event</button>';
                                    }
                                }

                        ?>
                        </div>

                        </div>
                        <div class="rvt-grow-1 rvt-width-xxl rvt-m-top-lg rvt-m-right-sm rvt-wrap group-bio">
                       
                        <span>Group Bio:
                                <?php
                            $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                                    // Check Connection
                                                    if (!$con) {
                                                            die("Connection failed: " . mysqli_connect_error() . "<br>");
                                                    }
                            $sql = "SELECT biography FROM Groups WHERE groupId='$passedId'";
                            $result= $con->query($sql);
                                                    $value = mysqli_fetch_object($result);
                                                    $biography = $value->biography;
                                                    echo '<b>'.$biography.'</b>';
                        ?>
                        </span>

                            <div class="rvt-width-xxl rvt-m-top-lg">
                            <span>Group Tags:
                                <?php
                                $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                // Check Connection
                                if (!$con) {
                                    die("Connection failed: " . mysqli_connect_error() . "<br>");
                                }
                                $sql = "SELECT interest FROM Interest AS i JOIN Group_Interest AS gi ON gi.interestId=i.interestId JOIN Groups AS g ON gi.groupId=g.groupId WHERE g.groupId='$passedId';";
                                if ($result = $con->query($sql)) {
                                    while($row = $result->fetch_array(MYSQLI_BOTH)) {
                                        echo "<span class='rvt-badge rvt-badge--warning-secondary'>";
                                        echo $row['interest'];
                                        echo "</span>";
                                        // echo "<br>";
                                    }
                                }
                                ?>
                                </span>
                            </div>
                            <div class="rvt-width-md rvt-m-top-lg">
                                <span>Group Type:
                                <?php
                                $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                // Check Connection
                                if (!$con) {
                                    die("Connection failed: " . mysqli_connect_error() . "<br>");
                                }
                                $sql = "SELECT groupType from Groups where groupId='$passedId';";
                                $result= $con->query($sql);
                                $value = mysqli_fetch_object($result);
                                $groupType = $value->groupType;
                                echo '<b>'.$groupType.'</b>';
                                $con->close();
                                ?>
                            </span>
                            </div>
                        <div class="rvt-flex rvt-m-top-lg save-button">
                            <?php
                            $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                            // Check Connection
                            if (!$con) {
                                die("Connection failed: " . mysqli_connect_error() . "<br>");
                            }
                            
                            $query = mysqli_query($con,"SELECT * FROM Group_Managers WHERE userId='{$_SESSION['userId']}' AND groupId = '$passedId';");
                            if (mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)){
                                    echo '<input type="submit" name="submit" class="rvt-button" value="Edit">';
                                }   
                            }
                            $con->close();

                            ?>
                        </div>
                        </div>
                        </div>
                    </div>
                </form>


	<div class="rvt-box rvt-box--card">
        	<div class="rvt-box__body">
                	<div class="rvt-container">
                        	<div class="rvt-grid">
					<div class='rvt-grid__item-12-md-up'>
					<span class="rvt-badge rvt-badge--success-secondary"> Pinned Message: 
                    <?php
                        $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        // Check Connection
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error() . "<br>");
                        }
                        $pinchat="";
                        $sql = mysqli_query($con, "SELECT pinnedChat FROM Groups WHERE groupId='$passedId'");
                        if(mysqli_num_rows($sql)>0){
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $pinchat = $row['pinnedChat'];
                                if(is_null($pinchat)){
                                    echo 'There is no current announcement.';
                                } else {
                                    echo $pinchat;
                                } 
                            }
                        }
                    ?>
                    </span>
					</div>
				</div>
				
				<?php
                                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                            // Check Connection
                                            if (!$con) {
                                                 die("Connection failed: " . mysqli_connect_error() . "<br>");
                                            }
                                    $sql = "select concat(u.fname,' ',u.lname) AS fullName,c.chatId, DATE_FORMAT(c.chatDate, '%M %d, %Y') as chatDate, TIME_FORMAT(c.chatTime, '%r') as chatTime,c.chatText,cc.userId,cc.groupId from Chat AS c JOIN Created_Chat AS cc ON c.chatId=cc.chatId JOIN User AS u on u.userId= cc.userId WHERE groupId='$passedId' ORDER BY chatDate,chatTime;";
                                    if ($result = $con->query($sql)) {
                                        while($row = $result->fetch_array(MYSQLI_BOTH)) {
                                            echo "<div class='rvt-grid'><div class='rvt-grid__item-12-md-up'><p style='text-align:center; font-size:small;'>";
                                            echo $row['chatDate'];
                                            echo " @ ";
                                            echo $row['chatTime'];
                                            echo "</p></div></div>"; 
                                            echo "<div class='rvt-grid'><div class='rvt-grid__item-12-md-up'><p>";
                                            echo $row['fullName'];
                                            echo "</p></div></div>";
					                        echo "<div class='rvt-grid'><div class='rvt-grid__item-12-md-up rvt-grid' ><p style='margin-top:-15px; background-color: #6fbced; padding:5px; border-radius:5px; margin-left:10px;;'>";
                                            echo $row['chatText'];
                                            echo "</p></div></div>";
                                        }
                                    }
                                    $con->close();
                                ?>

				<form method="POST">
				<div class='rvt-grid'>
					<div class='rvt-grid__item-11-md-up'>
						<input type='text' name='new-message' placeholder='Type Your Message Here'>
					</div>
					<div class='rvt-grid__item-1-md-up'>
						<button class='rvt-button' onclick='window.location.reload(true);'>Send</button>
					</div>
				</div>
				</form>
				<form method="GET">
                                        <?php 
                                
                                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                        // Check Connection
                                            if (!$con) {
                                                die("Connection failed: " . mysqli_connect_error() . "<br>");
                                            }
                                    
                                    $var_message= mysqli_real_escape_string($con,trim($_POST['new-message']));
                                    
                                    if(!empty($var_message)) {
                                        $sql2 = "insert into Chat (chatDate,chatTime,chatText) VALUES (CURDATE(),CURTIME(), '$var_message');";
                                        mysqli_query($con,$sql2);
                                        $sql3 = "insert into Created_Chat (chatId,groupId,userId) VALUES ((Select chatId FROM Chat WHERE chatText='$var_message'),'$passedId','{$_SESSION['userId']}');";  
                                        mysqli_query($con,$sql3);
                                    }
                                    
                                    
                                    $con->close();
                                    ?>
                                    </form>
		    	</div>
		</div>
	</div>
</div>
              
           <!-- RIGHT BODY -->
            <!-- ======================================================================================================================== -->
            <div class="rvt-hide-lg-down rvt-right-body rvt-m-right-sm">
                <div class="rvt-wrap rvt-box__body">
                    <div class="rvt-container">
                        <div class="rvt-grid">
                        <div class='pending-users'>
                        <header class="rvt-modal__header">
                        <h1 class="rvt-ts-sm rvt-modal__title" id="modal-example-title">Join Requests</h1>
                        </header>
                                <?php

                                // $query = mysql_query($con,"SELECT groupId FROM Group_Managers WHERE userId=1");
                                // if(mysql_num_rows($query)>=1)
                                //   {
                                   
                                                
                                $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                // Check Connection
                                if (!$con) {
                                    die("Connection failed: " . mysqli_connect_error() . "<br>");
                                }
                                $query = mysqli_query($con,"SELECT * FROM Group_Managers WHERE userId='{$_SESSION['userId']}' AND groupId = '$passedId';");
                                if (mysqli_num_rows($query) > 0) {
                                    while($row = mysqli_fetch_assoc($query)){
                                        

                                // $query = mysql_query($con,"SELECT groupId FROM Group_Managers WHERE userId='{$_SESSION['userId']}'");
                                // if (mysqli_num_rows($query) > 0) {
                                $pendingUsers = "SELECT u.userId, CONCAT(u.fname, ' ', u.lname) as name
                                                from User as u
                                                left join Pending_User as pu on pu.userId=u.userId
                                                where pu.groupId = '$passedId' and pu.pendingType = 'requested';";
                                $id_list = array();
                                $name_list = array();
                                $result = mysqli_query($con, $pendingUsers);  
                                
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $userId = $row['userId'];
                                        // $_SESSION['id']= $userId;
                                        // echo 'this is session variable'.$_SESSION['id'];
                                        $name = $row['name'];
                                        // echo "<p>$name</p>";
                                        array_push($id_list,$userId);
                                        array_push($name_list,$name);

                                    }
                                    for($i = 0; $i < sizeof($id_list);$i++){
                                        echo '<button type="button" class="rvt-button rvt-m-top-sm" data-modal-trigger='.$id_list[$i].'>'.$name_list[$i].'</button>
                                            <div class="rvt-modal" id='.$id_list[$i].' role="dialog" aria-labelledby="modal-example-title" aria-hidden="true"
                                            tabindex=-1>
                                            <div class="rvt-modal__inner">
                                            <header class="rvt-modal__header">
                                            <h1 class="rvt-modal__title" id="modal-example-title">User Information</h1>
                                            </header>
                                            <div class="rvt-modal__body">
                                                <p>Name:';
                                             
                                        $sql = "SELECT concat(fname,' ',lname) AS fullName FROM User WHERE userId='$id_list[$i]' LIMIT 1;";
                                        $result= $con->query($sql);
                                        $value = mysqli_fetch_object($result);
                                        $fullName = $value->fullName;
                                        echo "<b>";
                                        echo $fullName;
                                        echo "</b>";
                                        // $con->close();              
                                        echo '</p>
                                        <p>Biography:';
                                                                    
                                    
                                        // foreach ($id_list as $id) {
                                            // print $id;
                                            $sql = "SELECT biography FROM User WHERE userId='$id_list[$i]'";
                                            $result= $con->query($sql);
                                            $value = mysqli_fetch_object($result);
                                            $biography = $value->biography;
                                            echo "<b>";
                                            echo $biography;
                                            echo "</b>";
                                            // $con->close();
                                        // }
                                                                                
                                        echo'</p>
                                        <p>Interests:';                  
                                        $sql = "SELECT interest FROM Interest AS i JOIN User_Interest AS ui ON ui.interestId=i.interestId 
                                                JOIN User AS u ON ui.userId=u.userId WHERE u.userId='$id_list[$i]';";
                                                    
                                        if ($result = $con->query($sql)) {
                                            while($row = $result->fetch_array(MYSQLI_BOTH)) {
                                                echo "<span class='rvt-badge rvt-badge--info-secondary'>";
                                                echo $row['interest'];
                                                echo "</span>";
                                                // echo "";
                                            }
                                        }
                                        // $con->close();
                                                                
                                                    
                                        echo '</p>
                                        <p>School Year:';
                                        $sql = "SELECT class FROM User WHERE userId='$id_list[$i]';";
                                        $result= $con->query($sql);
                                        $value = mysqli_fetch_object($result);
                                        $class = $value->class;
                                        // echo "<div class='user-row'><p><span style='color:#990000;'>Title:</span>&emsp;";
                                        echo "<b>";
                                        echo $class;
                                        echo "</b>";
                                        // echo "</p></div>";
                                                                
                                    echo'</p>';

                                    if($_POST[$id_list[$i]] == 'Accept'){
                                        // echo $id_list[$i];
                                        $add = "INSERT INTO User_Joined_Group (groupId, userId) VALUES ('$passedId',(Select userId from User where userId='$id_list[$i]'))";
                                        mysqli_query($con,$add);
                                        $remove = "DELETE from Pending_User Where userId='$id_list[$i]';";
                                        mysqli_query($con,$remove);
                                    }
                                    if($_POST[$id_list[$i]] =='Decline'){
                                        $remove = "DELETE from Pending_User Where userId='$id_list[$i]'";
                                        mysqli_query($con,$remove);
                                                                            
                                    }
                                    echo '</div>';
                                    echo '
                                    <div class="rvt-modal__controls">
                                    <form method="POST">
                                    <input type="submit" class="rvt-button" name='.$id_list[$i].' value="Accept">
                                    <input type="submit" class="rvt-button" name='.$id_list[$i].' value="Decline">';                             
                                    echo ' </form></div>
                                    <button type="button" class="rvt-button rvt-modal__close" data-modal-close='.$id_list[$i].'>
                                    <span class="rvt-sr-only">Close</span>
                                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                    d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z" />
                                    </svg>
                                    </button>
                                    </div>
                                    </div>';
                                }
                            } else {
                            echo '<p>No pending join requests.</p>';
                        }
                    }
                }
                else{
                    echo "<p>This menu is for Group Manager only.</p>";
                }
                    // }
                        mysqli_close($con); 
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
	<div class="rvt-hide-lg-down rvt-right-body rvt-m-right-sm" style="background-color:#EBEBEB; height:50px;">
                <div class= "rvt-wrap rvt-box__body">
                    <div class="rvt-container">
</div></div></div>

<div class="rvt-hide-lg-down rvt-right-body rvt-m-right-sm" style="height:400px;">
     <div class= "rvt-wrap rvt-box__body">
          <div class="rvt-container">
          <h1 class="rvt-ts-sm rvt-modal__title" id="modal-example-title">Groups to Join</h1>
          <br>
                <?php
                    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                    // Check Connection
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error() . "<br>");
                    }

		    $var_group = "SELECT g.groupId AS groupId, g.biography AS biography, g.groupName AS groupName,g.groupType AS groupType, COUNT(*) AS total from Groups AS g
                        JOIN Group_Interest AS gi ON gi.groupId=g.groupId WHERE gi.interestId IN (
                        Select interestId FROM User_Interest WHERE userId='{$_SESSION['userId']}'
                        ) AND groupName NOT IN (
                        SELECT groupName FROM Groups AS g JOIN User_Joined_Group AS ujg ON ujg.groupId=g.groupId WHERE userId='{$_SESSION['userId']}'
                        ) AND groupName NOT IN (
                        SELECT DISTINCT groupName FROM Groups AS g JOIN Pending_User AS pu ON pu.groupId=g.groupId WHERE userId='{$_SESSION['userId']}'
                        )
                        GROUP BY groupName
                        ORDER BY COUNT(*) DESC
                        LIMIT 5;";
		            
                    $names = array();
                    $ids = array();
                    $types = array();
                    $bios = array();

                    $result = mysqli_query($con, $var_group);
                    while($row = mysqli_fetch_assoc($result)) {
                        array_push($names,$row['groupName']);
                        array_push($ids,$row['groupId']);
                        array_push($types, $row['groupType']);
                        array_push($bios, $row['biography']);
                                    
                    }
                    if ($result = $con->query($var_group)) {
                        for ($i=0; $i < sizeOf($names); $i++) {
                            echo "<div class='rvt-grid'><div class='rvt-grid__item-10-md-up'>";
                            echo "<p style='font-size:12px; margin-left:-35px;'>";
                            echo $names[$i];
                            echo "<br>";
                            echo $types[$i];
                            echo "</p></div>";
                            echo "<div class='rvt-grid__item-2-md-up'>";
                        
                            echo "<button type='button' class='rvt-button' data-modal-trigger=".$names[$i].">+</button>";
                            echo "<div class='rvt-modal' id=".$names[$i]." role='dialog' aria-labelledby='model-example-title' aria-hidden='true' tabindex=-1>";
                            echo " <div class='rvt-modal__inner'><header class='rvt-modal__header'>";
                            echo "<h1 class=rvt_modal__title' id='modal-example-title'>Group Information</h1>";										
                            echo "</header> <div class='rvt-modal__body'> <p>Name:<b>";
                            echo $names[$i];
                            echo "</b></p><p>Biography:<b>";
                            echo $bios[$i];
                            echo "</b></p><p>Interests:";
                            $sql = "SELECT interest FROM Interest AS i JOIN Group_Interest AS gi ON gi.interestId=i.interestId JOIN Groups AS g ON gi.groupId=g.groupId WHERE g.groupId='$ids[$i]';";

                            if ($result2 = $con->query($sql)) {
                                while($row = $result2->fetch_array(MYSQLI_BOTH)) {
                                    echo "<b>";
                                    echo $row['interest'].',';
                                    echo "</b>";	
                                    }
                            }
                                    echo '</p>';

                            if($_POST[$ids[$i]] == 'Request To Join'){
                                $request = "INSERT into Pending_User (pendingType, groupId, userId) Values ('requested','$ids[$i]',{$_SESSION['userId']});";
                                mysqli_query($con,$request);
                            }
                                echo '</div>';
                                echo '
                                <div class="rvt-modal__controls">
                                <form method="POST">
                                <input type="submit" class="rvt-button" name='.$ids[$i].' value="Request To Join">';                           
                                echo ' </form></div>
                                <button type="button" class="rvt-button rvt-modal__close" data-modal-close='.$names[$i].'>
                                <span class="rvt-sr-only">Close</span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                                <path fill="currentColor"
                                d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z" />
                                </svg>
                                </button>
                                </div>
                                </div>';
                                echo'</div>';
                            echo "</div>";
                        }
                    }
                    $con->close();
                ?>
        <a href="exploreGroup.php"><button class="rvt-button rvt-button--secondary" style="margin-left:35px;" >See More</button></a> 
</div>		
	  </div>
     </div>
 </div>	
</div>
 </div>

 <div class="rvt-modal" id="group event" role="dialog" aria-labelledby="modal-example-title"
        aria-hidden="true" tabindex=-1>
        <div class="rvt-modal__inner">
            <header class="rvt-modal__header">
                <h1 class="rvt-modal__title" id="group event">Create a Group Event</h1>
            </header>
            <div class="rvt-modal__body">
                <form method="POST">
                    <p class="p-form"> Location <textarea class="form-input" name="form-location" cols="20" rows="4"
                            maxlength="100" required></textarea></p>
                    <p class="p-form"> Date <input type="date" class="form-input" name="form-date" required></p>
                    <p class="p-form"> Start Time <input type="time" class="form-input" name="form-startTime" required>
                    </p>
                    <p class="p-form"> End Time <input type="time" class="form-input" name="form-endTime" required> </p>
                    <p class="p-form"> Details <textarea name="form-details" class="form-input" cols="40" rows="10"
                            maxlength="200" required></textarea></p>

                    <p class="p-form">Event Type<select class="form-input" name="form-type">
                        <option value="Recreational" <?php if ($_POST['form-time'] == "Recreational") { echo ' selected="selected"'; } ?>>Recreational</option>
                        <option value="Social" <?php if ($_POST['form-time'] == "Social") { echo ' selected="selected"'; } ?>>Social</option>
                        <option value="Networking" <?php if ($_POST['form-time'] == "Networking") { echo ' selected="selected"'; } ?>>Networking</option>
                        <option value="Career" <?php if ($_POST['form-time'] == "Career") { echo ' selected="selected"'; } ?>>Career</option>
                        <option value="Volunteer" <?php if ($_POST['form-time'] == "Volunteer") { echo ' selected="selected"'; } ?>>Volunteer</option>
                        <option value="Workshop" <?php if ($_POST['form-time'] == "Workshop") { echo ' selected="selected"'; } ?>>Workshop</option>
                        <option value="Class" <?php if ($_POST['form-time'] == "Class") { echo ' selected="selected"'; } ?>>Class</option>
                        <option value="Other" <?php if ($_POST['form-time'] == "Other") { echo ' selected="selected"'; } ?>>Other</option>
                    </select></p>


                    <?php
                        $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                        // Check Connection
                        if (!$con) {
                            die("Connection failed: " . mysqli_connect_error() . "<br>");
                        }

                        $groupMembersSQL = "SELECT u.userId from User as u
                                                left join User_Joined_Group as usg on usg.userId=u.userId
                                                where usg.groupId = 1";
                        $members = array();

                        $groupMembers = mysqli_query($con, $groupMembersSQL);

                        while ($row = mysqli_fetch_assoc($groupMembers)){
                            $members[] = $row['userId'];
                        }
                        if ($_POST['submit']=='create event') {
                            $date = mysqli_real_escape_string($con, $_POST['form-date']);
                            $startTime = mysqli_real_escape_string($con, $_POST['form-startTime']);
                            $endTime = mysqli_real_escape_string($con, $_POST['form-endTime']);
                            $location = mysqli_real_escape_string($con, $_POST['form-location']);
                            $details = mysqli_real_escape_string($con, $_POST['form-details']);
                            $type = $_POST['form-type'];                 
                            // $groupId = mysqli_real_escape_string($con, $_POST['form-group']);

                            $eventSQL = "INSERT INTO Event (eventDate, location, startTime, endTime, eventType, details, groupId)
                                    VALUES ('$date', '$location', '$startTime','$endTime', '$type', '$details', 1);";

                            if (mysqli_query($con, $eventSQL)) {
                                $last_id = mysqli_insert_id($con);

                                for($i=0; $i < count($members); $i++) {
                                    $noti = "INSERT INTO Notification (notificationType, details, interacted, eventId, reservationId, groupId, userId)
                                            Values ('$type', '$details', NULL, $last_id, NULL, 1, $members[$i]);";
        
                                    mysqli_query($con, $noti);
                                }

                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }    
                        }
                        mysqli_close($con);
                    ?>
                                        </div>
                                        <div class="rvt-modal__controls">
                                            <button class="rvt-button" name="submit" value="create event">Create
                                                Event</button>
                                            <button type="button" class="rvt-button rvt-button--secondary"
                                                data-modal-close="group event">Cancel</button>
                                        </div>
                                        <button type="button" class="rvt-button rvt-modal__close"
                                            data-modal-close="group event">
                                            <span class="rvt-sr-only">Close</span>
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" viewBox="0 0 16 16">
                                                <path fill="currentColor"
                                                    d="M9.41,8l5.29-5.29a1,1,0,0,0-1.41-1.41L8,6.59,2.71,1.29A1,1,0,0,0,1.29,2.71L6.59,8,1.29,13.29a1,1,0,1,0,1.41,1.41L8,9.41l5.29,5.29a1,1,0,0,0,1.41-1.41Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>



    <script src="https://assets.uits.iu.edu/javascript/rivet/1.7.2/rivet.min.js">

        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
    <script>
        function signOut() {
            gapi.auth2.getAuthInstance().signOut().then(function () {
                console.log('user signed out');    
            window.setTimeout(function() {
                window.location.href =
                "https://cgi.luddy.indiana.edu/~jcarlsso/capstone-team/logout.php";
            }, 100);
            })
        }
        Modal.close('rvt-modal', function() {
            Modal.focusTrigger('rvt-modal');
        });
    </script>
                                    <script>
                                function ContentPage(elem)    {
                                        window.location.href = "viewGroup.php?groupId="+elem.value;
                                    }
                                </script>
                                                                    <script>
                                function ContentPage2(elem)    {
                                        window.location.href = "updateGroup.php?groupId="+elem;
                                        return false;
                                    }
                                </script>


</body>
</html>
