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
             ];
            }
            /**
             * disable caching
             */
            public function getCacheMaxAge() {
                return 0;
            }
         public function eventCountdown()
         {
            $current_time = \Drupal::time()->getCurrentTime();
            $dateCurrent = date('d-m-Y', $current_time);
            $node = \Drupal::routeMatch()->getParameter('node');
            if ($node instanceof \Drupal\node\NodeInterface) {
              $nid = $node->id();
              $title = $node->title->value;
              $date = $node->field_date->date->format('d-m-Y');
              $startTimeStamp = strtotime($dateCurrent);
              $endTimeStamp = strtotime($date);
                if($endTimeStamp > $startTimeStamp)
                {
                    $timeDiff = abs($endTimeStamp - $startTimeStamp);
                    $numberDays = $timeDiff/86400;  // 86400 seconds in one day
                    // and you might want to convert to integer
                    $numberDays = intval($numberDays);
                    return $numberDays . " days left until event starts";
                }
                elseif ($endTimeStamp == $startTimeStamp) {
                    return "This event is happening today";
                }
                elseif($endTimeStamp < $startTimeStamp){
                return "This event already passed";
            }
            }else{
                return " ";
            }
         }

     }
?>