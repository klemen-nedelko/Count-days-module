<?php
namespace Drupal\count_days\Services;

use Drupal\node\NodeInterface;

class EventCountdown
{
  public function getEventCountdown($node){
    $current_time = \Drupal::time()->getCurrentTime();
    $dateCurrent = date('d-m-Y H:i:s', $current_time);
    $dateCurrectComapre = date('d-m-Y', $current_time);
    if ($node instanceof NodeInterface) {
      $nid = $node->id();
      $title = $node->title->value;
      $date = $node->field_date->date->format('d-m-Y H:i:s');
      $startTimeStamp = strtotime($dateCurrent);
      $endTimeStamp = strtotime($date);
      $dateDay = 86400;
      $dateHours = 3600;
      $timeDiffDay = abs($endTimeStamp - $startTimeStamp);
      $numberHours = $timeDiffDay / $dateHours;
      $numberHours = intval($numberHours);
      $dayOne = $node->field_date->date->format('d-m-Y');
    
        if($endTimeStamp > $startTimeStamp)
        {
            $timeDiff = abs($endTimeStamp - $startTimeStamp);
            $numberDays = $timeDiff / $dateDay;
            $numberDays = intval($numberDays);
            if(($numberHours < $dateHours) && ($numberDays == 0)){
                if ($dayOne == $dateCurrectComapre) {
                    return t("This event is happening today");
                }else{
                    return t("This event is happening next day");
                }
            }
            else {
                return t($numberDays . " days left until event starts");
            }
        }  
        elseif($endTimeStamp < $startTimeStamp){
             return t("This event already passed");
        }
        else{
            return " ";
        }

    }
  }
}
