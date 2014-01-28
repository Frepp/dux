<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDice {

  /**
   * Properties
   *
   */
  private $lastRoll = array();



  /**
   * Constructor
   *
   */
  public function __construct() {
    ;
  }



  /**
   * Roll the dice
   *
   */
  public function Roll() {
    $this->lastRoll = array();
    for($i = 0; $i < 1; $i++) {
      $this->lastRoll[] = rand(1, 6);
    }
  }



  /**
   * Get the array that contains the last roll(s).
   *
   */
  public function GetResult() {
    return $this->lastRoll;
  }



  /**
   * Get an image of the result.
   *
   */
  public function GetRollImage() {
    $html = "<ul class='dice'>";
    foreach($this->lastRoll as $val) {
      $html .= "<li class='dice-{$val}'></li>";
    }
    $html .= "</ul>";
    return $html;
  }

}