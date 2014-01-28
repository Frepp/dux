<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CRound {

  /**
   * Properties
   *
   */



  /**
   * Constructor
   *
   */
  public function __construct($dice) {
    $this->dice=$dice;
  }



  /**
   * Sum Rolls
   *
   */
public function sum(){
	$res = $this->dice->GetResult();
	$_SESSION['round'][] = $res[0];
	if($res[0] == 1){
	unset($_SESSION['round']);
	$_SESSION['countrounds'] ++;
	}
}

public function getsum(){
	if(isset($_SESSION['round'])){
	$sum = array_sum($_SESSION['round']);
	return $sum;
}

}

  /**
   * Save
   *
   */
   public function save(){
		$_SESSION['sum'][] = $this->getsum();
		unset($_SESSION['round']);
		$_SESSION['countrounds'] ++;

   }
public function getroundsum(){
	if(isset($_SESSION['sum'])){
	$sumsum = array_sum($_SESSION['sum']);
	return $sumsum;
}

}


}