<?php
    //$add = "INSERT INTO User_Favorited_Group (groupId, userId) VALUES ($id_list[$i],'{$_SESSION['userId']}')";
    //mysqli_query($con,$add);
    //$remove = "DELETE from User_Favorited_Group Where userId='{$_SESSION['userId']}'";
    //mysqli_query($con,$remove);
    $con = mysqli_connect("db.sice.indiana.edu","i494f20_team20","my+sql=i494f20_team20", "i494f20_team20");
                                    // Check Connection
                                    if (!$con) {
                                        die("Connection failed: " . mysqli_connect_error() . "<br>");
                                        echo 'Failed';
                                    }
    $groupId = $_REQUEST['groupId'];
    $userId = $_REQUEST['userId'];

    $groups = mysqli_query($con,"SELECT * from User_Favorited_Group WHERE userId=$userId and groupId=$groupId");
    
    if(mysqli_num_rows($groups) == 0){
        $add = "INSERT INTO User_Favorited_Group (groupId, userId) VALUES ($groupId, $userId)";
        mysqli_query($con,$add);
    }else{
        $remove = "DELETE from User_Favorited_Group Where userId=$userId and groupId=$groupId";
        mysqli_query($con,$remove);
    }
    echo "$groupId";
?>
