<?php

include_once('../../database/db_config.php');
$con=mysqli_connect($db_host,$db_user,$db_password,$db_name);//connect to the database

mysqli_query($con, "delete from lb_area");

$state_name = array("AK", "AL", "AR", "AZ", "CA", "CO", "CT", "DE", 
"FL", "GA", "HI", "IA", "ID", "IL", "IN", "KS", "KY", "LA", "MA", 
"MD", "ME", "MI", "MN", "MO", "MS", "MT", "NC", "ND", "NE", "NH", 
"NJ", "NM", "NV", "NY","OH", "OK", "OR", "PA", "RI", "SC", "SD", 
"TN", "TX", "UT", "VA", "VT", "WA", "WI", "WV", "WY");
/******The section aims at select useful information from tweet_text and insert them into the new table *******/
for($i=0; $i<count($state_name); $i++){
    
$sql = "SELECT COUNT(*) as num, tweets.screen_name, tweets.profile_image_url FROM tweets LEFT JOIN users on tweets.user_id = users.user_id WHERE location LIKE '%".$state_name[$i]."%' GROUP BY screen_name ORDER BY num DESC LIMIT 15";//

    $result= mysqli_query($con,$sql);

    echo "<br>".$state_name[$i]."<br>";
    $m = 0;
    while($array = mysqli_fetch_array($result)){
        $num = $array[0];
        $name =$array[1];
        $url = $array[2];

        echo $name."   ".$num."<br>";

        mysqli_query($con,"INSERT INTO lb_area (state_name, screen_name, tweet_num, profile_image_url) VALUES ('".$state_name[$i]."','".$name."',".$num.",'".$url."')");
        $m++;
    }
    //if a certain state has less than 15 tweet texts, set its rest texts as zero
    if($m<15){
        for($n=0;$n<(15-$m);$n++) mysqli_query($con,"INSERT INTO lb_area (state_name, screen_name, tweet_num, profile_image_url) VALUES ('".$state_name[$i]."','no data',0,'no data')");
    }
}

@mysqli_close($result);
@mysqli_close($con);

?>