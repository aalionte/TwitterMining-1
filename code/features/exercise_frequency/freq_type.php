<?php

$con = mysqli_connect("localhost", "root", "wearethebest", "hma2014");
mysqli_query($con,"DELETE FROM freq_type");

$Exe_type = array("running","cycling","swimming","basketball","volleyball","tennis","football");

for($j = 0; $j < count($Exe_type); $j++){

    $sql = "SELECT screen_name, created_at FROM tweets WHERE tweet_text LIKE '%".$Exe_type[$j]."%' and created_at not like '2014-10-12%' and created_at not like '2014-10-20%'"; 
    $result = mysqli_query($con,$sql); 

    while($array = mysqli_fetch_array($result)){
        $sql = "INSERT INTO freq_type(exercise_type, screen_name, created_at) Values ('".$Exe_type[$j]."','".$array[0]."','".$array[1]."')";
        mysqli_query($con,$sql);
    } 

}
 
mysqli_close($con);

?>