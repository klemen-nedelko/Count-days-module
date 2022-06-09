<?php

namespace Drupal\count_days\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\NodeInterface;
use Drupal\Core\Plugin;
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
         protected $countDays;
         protected $node;
         public function __construct(){
            $this->countDays = \Drupal::service('count_days.countDays');
            $this->node = \Drupal::routeMatch()->getParameter('node');
         }

         /**
          * {@inheritdoc}
          */

         public function build()
         {   
             return[
                 '#markup' => $this->countDays->getEventCountdown($this->node) ,
                 '#cache'=>[
                     'max-age' => 0,
                 ],
             ];
            }
    }
?>