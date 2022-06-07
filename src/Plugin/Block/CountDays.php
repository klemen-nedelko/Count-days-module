<?php

namespace Drupal\count_days\Plugin\Block;

use Drupal\Core\Block\BlockBase;
/**
 * Provides a Drupal Up block
  *
  * @Block(
  *   id = "count_days",
  *   admin_label = @Translation("drupal count days"),
  *   category = @Translation("Our example")
  * )
  */
     class CountDays extends BlockBase
     {
         /**
          * {@inheritdoc}
          */
         public function build()
         {
            \Drupal::service('page_cache_kill_switch')->trigger();
             return[
                 '#markup' => $this->eventCountdown(),
                 '#cache'=>[
                     'max-age' => 0,
                 ],
             ];
            }
            /**
             * disable caching
             */
         public function eventCountdown()
         {
            $current_time = \Drupal::time()->getCurrentTime();
            $dateCurrent = date('d-m-Y H:i:s', $current_time);
            $dateCurrectComapre =date('d-m-Y', $current_time);
            $node = \Drupal::routeMatch()->getParameter('node');
            if ($node instanceof \Drupal\node\NodeInterface) 
            {
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
                }else {
                    return t($numberDays . " days left until event starts");
                }
            }  
            elseif($endTimeStamp < $startTimeStamp){
                     return t("This event already passed");
                }
                else
                {
                    return " ";
                }

         }

        }
    }
?>