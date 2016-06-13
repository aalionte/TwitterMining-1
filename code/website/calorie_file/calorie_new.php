<html>
<head>
<title>Time Extraction Test</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>

<?php

$con = mysqli_connect("localhost", "root", "wearethebest", "hma2014");
mysqli_query($con,"DELETE FROM calorie_new");

$Exe_type = array("ran","rode","swam","basketball","football");

function number($str){
    return preg_replace ('/\D/s', '', $str);
}

function extractnum($string){

    //calculate mins
    if(strpos("$string"," mins ")){   
        $pos_min = strpos("$string"," mins ");
        $str_min = substr($string, $pos_min-2, 2); 
        $num_min = number ($str_min);
        $num_min_int = (int)$num_min;
    }
    else $num_min_int = 0;

    //caculate hours
    if(strpos("$string"," hour")){
        $pos_hr = strpos("$string"," hour");
        $str_hr = substr($string, $pos_hr-1, 1);
        $num_hr = number($str_hr);
        $num_hr_int = (int)$num_hr;
    }
    else $num_hr_int = 0;
    
    // judge if hours exsist
    if ($num_hr_int != 0){
        $num_hr_min = $num_hr_int*60;
    }else{$num_hr_min = 0;}


    $num_min_sum = $num_min_int + $num_hr_min;
    (double)$num_hr_sum = (double)$num_min_int / (double)60 + (double)$num_hr_int;

    return $num_hr_sum;
}


for($j = 0; $j < count($Exe_type); $j++){
    
    $sql = "SELECT tweet_text, created_at FROM tweets_new WHERE tweet_text LIKE '%".$Exe_type[$j]." % mins %' AND tweet_text NOT LIKE '%ran out%' AND tweet_text NOT LIKE '%".$Exe_type[$j]." %[,.]% mins %'";
 
    $result = mysqli_query($con,$sql); 
    
    echo "Keyword: ".$Exe_type[$j]."+mins"."<br>";
    echo "<hr >";
    
    while($array = mysqli_fetch_array($result)){
        echo "<br>";
        echo "Tweet: ".$array[0];
        echo "<br>";
        
        $num = extractnum($array[0]);
        echo "Extracted hour: ".$num."<br>";
        

        if($Exe_type[$j] == "ran"){
            if($num > 0 && $num < 3 ){
                $sql = "INSERT INTO calorie_new(exercise_type, exercise_time, created_at) Values ('".$Exe_type[$j]."','".$num."','".$array[1]."')";
                echo"The hour value is qualified"."<br>";
            } 
            else {echo "The hour value is out of scope"."<br>";
            }
        }

        if($Exe_type[$j] == "rode"){
            if($num > 0 && $num < 3.5 ){
                $sql = "INSERT INTO calorie_new(exercise_type, exercise_time, created_at) Values ('".$Exe_type[$j]."','".$num."','".$array[1]."')";
                echo"The hour value is qualified"."<br>";
            }
            else {echo "The hour value is out of scope"."<br>";
            }
        }

        if($Exe_type[$j] == "swam"){
            if($num > 0 && $num < 4 ){
                $sql = "INSERT INTO calorie_new(exercise_type, exercise_time, created_at) Values ('".$Exe_type[$j]."','".$num."','".$array[1]."')";
                echo"The hour value is qualified"."<br>";
            }
            else {echo "The hour value is out of scope"."<br>";
            }
        }

        if($Exe_type[$j] == "basketball"){
            if($num > 0 && $num < 6 ){
                $sql = "INSERT INTO calorie_new(exercise_type, exercise_time, created_at) Values ('".$Exe_type[$j]."','".$num."','".$array[1]."')";
                echo"The hour value is qualified"."<br>";
            }
            else {echo "The hour value is out of scope"."<br>";
            }
        }

        if($Exe_type[$j] == "football"){
            if($num > 0 && $num < 6 ){
                $sql = "INSERT INTO calorie_new(exercise_type, exercise_time, created_at) Values ('".$Exe_type[$j]."','".$num."','".$array[1]."')";
                echo"The hour value is qualified"."<br>";
            }
            else {echo "The hour value is out of scope"."<br>";
            }
        }
        
        mysqli_query($con,$sql);
        
    }
}

mysqli_close($con);

?>

</body>
</html>