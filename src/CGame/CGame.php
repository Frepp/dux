<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CGame {

  /**
   * Properties
   *
   */



  /**
   * Constructor
   *
   */
   public function __construct($round) {
    $this->round=$round;
  }



  /**
   * Restart the game
   *
   */
   public function restart(){
   	   if(isset($_POST['restart'])){
   	   	session_destroy();
   	   	session_start();
   	   	$_SESSION['countrounds'] = 0;
   	   }


}
  /**
   * If 100 win
   *
   */
  public function victory(){
  	  $sum1 = $this->round->getroundsum();
  	  $sum2 = $this->round->getsum();
  if(($sum1 + $sum2) >= 100){
  	$_SESSION['countrounds'] ++;
  	$output = "Du klarade spelet på " . $_SESSION['countrounds'] . " försök. Grattis!";  
  	return $output;
  }

}

}