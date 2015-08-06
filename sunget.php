<?php  
header('Content-type: application/json; charset=utf-8');

/**  get_timezone_offset START
this function is from http://php.net/manual/zh/function.timezone-offset-get.php
*/
function get_timezone_offset($remote_tz, $origin_tz = null) {
    if($origin_tz === null) {
        if(!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime("now", $origin_dtz);
    $remote_dt = new DateTime("now", $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}
//get_timezone_offset END
$severOffset = get_timezone_offset('UTC')/3600;
$lng=$_GET["lng"];
$lat=$_GET["lat"];
$localOffset=$_GET["localOffset"];
$offsetDifference=$severOffset-$localOffset;
$localTimeStamp=time()-$offsetDifference*3600; //这是客户端的时间戳 Timestamp of the client
$sunRiseStamp=date_sunrise($localTimeStamp,SUNFUNCS_RET_TIMESTAMP,$lat,$lng,90+50/60,$localOffset);
$sunSetStamp=date_sunset($localTimeStamp,SUNFUNCS_RET_TIMESTAMP,$lat,$lng,90+50/60,$localOffset);
$sunRise=date_sunrise($localTimeStamp,SUNFUNCS_RET_STRING,$lat,$lng,90+50/60,$localOffset);
$sunSet=date_sunset($localTimeStamp,SUNFUNCS_RET_STRING,$lat,$lng,90+50/60,$localOffset);

if($sunRise!="" and $sunSet!="") { //非极昼极夜 Not polar day or polar night
  if($sunSetStamp<$sunRiseStamp){//黑夜在一整天之内 The whole night is in a day
    $divideDay=($sunSetStamp+86400-$sunRiseStamp)/12;
    $divideNight=($sunRiseStamp-$sunSetStamp)/4;
    
    if(($localTimeStamp()>=$sunRiseStamp) || ($localTimeStamp<=$sunSetStamp))
	    $period="day";
    else
    	$period="nighttime";
    
    if(($localTimeStamp>=$sunRiseStamp && $localTimeStamp<$sunRiseStamp+5*$divideDay) || $localTimeStamp<$sunSetStamp-7*$divideDay){
		  	  $period_exact_chinese="上午";
          $period_exact_western="morning";
          }
	  	  elseif(($localTimeStamp>=$sunRiseStamp+5*$divideDay && $localTimeStamp<=$sunRiseStamp+7*$divideDay) || ($localTimeStamp>=$sunSetStamp-7*$divideDay && $localTimeStamp<=$sunSetStamp-5*$divideDay)){
	  		  $period_exact_chinese="中午";
          $period_exact_western="noon";
        }
        elseif(($localTimeStamp>$sunSetStamp-5*$divideDay && $localTimeStamp<=$sunSetStamp) || $localTimeStamp>$sunRiseStamp+7*$divideDay){
	  		  $period_exact_chinese="下午";
          $period_exact_western="afternoon";
        }
        elseif($localTimeStamp>$sunSetStamp && $localTimeStamp<=$sunSetStamp+2*$divideNight)
	  		  $period_exact_chinese="晚上";
        elseif($localTimeStamp>$sunSetStamp+2*$divideNight && $localTimeStamp<$sunRiseStamp)
          $period_exact_chinese="凌晨";
          
    if($localTimeStamp>$sunSetStamp && $localTimeStamp<=$sunSetStamp+$divideNight)
	  		  $period_exact_western="evening";
        elseif($localTimeStamp>$sunSetStamp+$divideNight && $localTimeStamp<$sunRiseStamp)
          $period_exact_western="night";
  }
  else{//白天在一整天之内 The whole daytime is in a day
    $divideDay=($sunSetStamp-$sunRiseStamp)/12;
    $divideNight=($sunRiseStamp+86400-$sunSetStamp)/4;
    
    if(($localTimeStamp<$sunRiseStamp) || ($localTimeStamp>$sunSetStamp))
	    $period="nighttime";
    else
    	$period="day";
    
    if($localTimeStamp>=$sunRiseStamp && $localTimeStamp<$sunRiseStamp+5*$divideDay){
		  	  $period_exact_chinese="上午";
          $period_exact_western="morning";
        }
	  	  elseif($localTimeStamp>=$sunRiseStamp+5*$divideDay && $localTimeStamp<=$sunRiseStamp+7*$divideDay){
	  		  $period_exact_chinese="中午";
          $period_exact_western="noon";
        }
        elseif($localTimeStamp>$sunRiseStamp+7*$divideDay && $localTimeStamp<=$sunSetStamp){
	  		  $period_exact_chinese="下午";
          $period_exact_western="afternoon";
        }
        elseif(($localTimeStamp>$sunSetStamp && $localTimeStamp<=$sunSetStamp+2*$divideNight) || $localTimeStamp<=$sunRiseStamp-2*$divideNight)
	  		  $period_exact_chinese="晚上";
        elseif(($localTimeStamp>$sunRiseStamp-2*$divideNight && $localTimeStamp<$sunRiseStamp) || $localTimeStamp>$sunSetStamp+2*$divideNight)
          $period_exact_chinese="凌晨";
          
    if(($localTimeStamp>$sunSetStamp && $localTimeStamp<=$sunSetStamp+$divideNight) || $localTimeStamp<=$sunRiseStamp-3*$divideNight)
	  		$period_exact_western="evening";
      elseif(($localTimeStamp>$sunRiseStamp-3*$divideNight && $localTimeStamp<$sunRiseStamp) || $localTimeStamp>$sunSetStamp+$divideNight)
        $period_exact_western="night";
  }
  echo '{"sunrise":"'.$sunRise.'","sunset":"'.$sunSet.'","period":"'.$period.'","period_exact_chinese":"'. $period_exact_chinese.'","period_exact_western":"'.$period_exact_western.'"}';}
else{ //极昼极夜 polar day or polar night
  $dateNum=idate("z",$localTimeStamp);
  if(idate("L",$localTimeStamp)==0){//平年 non-leap year
    if($dateNum>=51 && $dateNum<234){//春分日到秋分日 vernal equinox to autumnal equinox
      if($lat>0){//北纬 N
        $period="day";
        $period_exact_chinese="白天";
        $period_exact_western="day";
      }
      else{//南纬 S
        $period="nighttime";
        $period_exact_chinese="黑夜";
        $period_exact_western="nighttime";
        }
    }
    else{//秋分日到春分日 autumnal equinox to vernal equinox
      if($lat>0){//北纬 N
        $period="nighttime";
        $period_exact_chinese="黑夜";
        $period_exact_western="nighttime";
        
      }
      else{//南纬 S
        $period="day";
        $period_exact_chinese="白天";
        $period_exact_western="day";
        }
    }
  }
  else{ //闰年 leap year
    if($dateNum>=52 && $dateNum<235){//春分日到秋分日 vernal equinox to autumnal equinox
      if($lat>0){//北纬 N
        $period="day";
        $period_exact_chinese="白天";
        $period_exact_western="day";
      }
      else{//南纬 S
        $period="nighttime";
        $period_exact_chinese="黑夜";
        $period_exact_western="nighttime";
        }
    }
    else{//秋分日到春分日 autumnal equinox to vernal equinox
      if($lat>0){//北纬 N
        $period="nighttime";
        $period_exact_chinese="黑夜";
        $period_exact_western="nightime";
        
      }
      else{//南纬 S
        $period="day";
        $period_exact_chinese="白天";
        $period_exact_western="day";
        }
    }
  }
  echo '{"sunrise":"null","sunset""null","period"'.$period.'","period_exact_chinese":"'. $period_exact_chinese.'","period_exact_western":"'.$period_exact_western.'"}';}
?>
