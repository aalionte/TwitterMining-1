<?php

$con = mysqli_connect("localhost", "root", "wearethebest", "hma2014");
mysqli_query($con,"DELETE FROM freq_state");

$state_name = array("AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DE", 
"FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", 
"MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", 
"NJ", "NM", "NV", "NY","OH", "OK", "OR", "PA", "RI", "SC", "SD", 
"TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");

for($j = 0; $j < count($state_name); $j++){

    $sql = "SELECT tweets.screen_name, tweets.created_at FROM tweets LEFT JOIN users on tweets.user_id = users.user_id WHERE location LIKE '%".$state_name[$j]."%' and tweets.created_at not like '2014-10-12%' and tweets.created_at not like '2014-10-20%'"; 
    $result = mysqli_query($con,$sql);

    while($array = mysqli_fetch_array($result)){
        $sql = "INSERT INTO freq_state(state_name, screen_name, created_at) Values ('".$state_name[$j]."','".$array[0]."','".$array[1]."')";
        mysqli_query($con,$sql);
    }

}

mysqli_close($con);

?>