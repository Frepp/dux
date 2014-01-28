<?php

/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CDatabase {
 
  /**
   * Members
   */
  private $options;                   // Options used when creating the PDO object
  private $db   = null;               // The PDO object
  private $stmt = null;               // The latest statement used to execute a query
  private static $numQueries = 0;     // Count all queries made
  private static $queries = array();  // Save all queries for debugging purpose
  private static $params = array();   // Save all parameters for debugging purpose
 
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   *
   * @param array $options containing details for connecting to the database.
   *
   */
  public function __construct($options) {
    $default = array(
      'dsn' => null,
      'username' => null,
      'password' => null,
      'driver_options' => null,
      'fetch_style' => PDO::FETCH_OBJ,
    );
    $this->options = array_merge($default, $options);
 
    try {
      $this->db = new PDO($this->options['dsn'], $this->options['username'], $this->options['password'], $this->options['driver_options']);
    }
    catch(Exception $e) {
      //throw $e; // For debug purpose, shows all connection details
      throw new PDOException('Could not connect to database, hiding connection details.'); // Hide connection details.
    }
 
    $this->db->SetAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $this->options['fetch_style']); 
  }
  
  /**
   * Execute a select-query with arguments and return the resultset.
   * 
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return array with resultset.
   */
  public function ExecuteSelectQueryAndFetchAll($query, $params=array(), $debug=false) {
 
    self::$queries[] = $query; 
    self::$params[]  = $params; 
    self::$numQueries++;
 
    if($debug) {
      echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>";
    }
 
    $this->stmt = $this->db->prepare($query);
    $this->stmt->execute($params);
    return $this->stmt->fetchAll();
  }
  
  /**
   * Get a html representation of all queries made, for debugging and analysing purpose.
   * 
   * @return string with html.
   */
  public function Dump() {
    $html  = '<p><i>You have made ' . self::$numQueries . ' database queries.</i></p><pre>';
    foreach(self::$queries as $key => $val) {
      $params = empty(self::$params[$key]) ? null : htmlentities(print_r(self::$params[$key], 1)) . '<br/></br>';
      $html .= $val . '<br/></br>' . $params;
    }
    return $html . '</pre>';
  }
  
  /**
   * Execute a SQL-query and ignore the resultset.
   *
   * @param string $query the SQL query with ?.
   * @param array $params array which contains the argument to replace ?.
   * @param boolean $debug defaults to false, set to true to print out the sql query before executing it.
   * @return boolean returns TRUE on success or FALSE on failure. 
   */
  public function ExecuteQuery($query, $params = array(), $debug=false) {
 
    self::$queries[] = $query; 
    self::$params[]  = $params; 
    self::$numQueries++;
 
    if($debug) {
      echo "<p>Query = <br/><pre>{$query}</pre></p><p>Num query = " . self::$numQueries . "</p><p><pre>".print_r($params, 1)."</pre></p>";
    }
 
    $this->stmt = $this->db->prepare($query);
    return $this->stmt->execute($params);
  }
  
  /**
   * Return last insert id.
   */
  public function LastInsertId() {
    return $this->db->lastInsertid();
  }
  
  /**
   * Save debug information in session, useful as a flashmemory when redirecting to another page.
   * 
   * @param string $debug enables to save some extra debug information.
   */
  public function SaveDebug($debug=null) {
    if($debug) {
      self::$queries[] = $debug;
      self::$params[] = null;
    }
 
    self::$queries[] = 'Saved debuginformation to session.';
    self::$params[] = null;
 
    $_SESSION['CDatabase']['numQueries'] = self::$numQueries;
    $_SESSION['CDatabase']['queries']    = self::$queries;
    $_SESSION['CDatabase']['params']     = self::$params;
  }
  
  /**
   * Return rows affected of last INSERT, UPDATE, DELETE
   */
  public function RowCount() {
    return is_null($this->stmt) ? $this->stmt : $this->stmt->rowCount();
  }
  
  /**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
public function getQueryString($options, $prepend='?') {
  // parse query string into array
  $query = array();
  parse_str($_SERVER['QUERY_STRING'], $query);

  // Modify the existing query string with new options
  $query = array_merge($query, $options);

  // Return the modified querystring
  return $prepend . http_build_query($query);
}


/**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @return string as a link to this page.
 */
public function getHitsPerPage($hits) {
  $nav = "Träffar per sida: ";
  foreach($hits AS $val) {
    $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
  }  
  return $nav;
}



/**
 * Create navigation among pages.
 *
 * @param integer $hits per page.
 * @param integer $page current page.
 * @param integer $max number of pages. 
 * @param integer $min is the first page number, usually 0 or 1. 
 * @return string as a link to this page.
 */
public function getPageNavigation($hits, $page, $max, $min=1) {  
	$nav  = "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
  	$nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
  }

  $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  return $nav;

}

/**
 * Function to create links for sorting
 *
 * @param string $column the name of the database column to sort by
 * @return string with links to order by column.
 */
public function orderby($column) {
  return "<span class='orderby'><a href='?orderby={$column}&order=asc'>&darr;</i></a><a href='?orderby={$column}&order=desc'>&uarr;</a></span>";
}

/**
 * Function to create SQL query for multiple searches
 *
 * @param string $title string from title searching
 * @param integer $year1 movies newer than
 * @param integer $year1 movies older than
 * @param string $genre string from genre searching
 * @param integer $hits number of hits to display
 * @param integer $page current page
 * @param array $orderby order by what
 * @param array $order asc or desc
 * @return string containing sql query.
 */
 public function searchquery($title, $year1, $year2, $genre, $hits, $page, $orderby, $order) {

 $sql = "select id, 
title as 'Titel', 
year as 'År', 
image as 'Bild', 
genre as 'Genre' 
from VMovie Where 1 ";

if($title) {
  // prepare SQL for search
  $sql .= "and title like '$title'";
}
if($year1) {
  // prepare SQL for search
  $sql .= "and year > '$year1'";
}
if($year2) {
  // prepare SQL for search
  $sql .= "and year < '$year2'";
}
if($genre) {
  // prepare SQL for search
  $sql .= "and genre like '%$genre%'";
}

$sql .= " order by $orderby $order LIMIT $hits OFFSET " . (($page - 1) * $hits) . 
";";
 
return $sql; 
 
 }
 
 
 public function searchquerymax($title, $year1, $year2, $genre) {

 $sql = "select 
title as 'Titel', 
year as 'År', 
image as 'Bild', 
genre as 'Genre' 
from VMovie Where 1 ";

if($title) {
  // prepare SQL for search
  $sql .= "and title like '$title'";
}
if($year1) {
  // prepare SQL for search
  $sql .= "and year > '$year1'";
}
if($year2) {
  // prepare SQL for search
  $sql .= "and year < '$year2'";
}
if($genre) {
  // prepare SQL for search
  $sql .= "and genre like '%$genre%'";
}

$sql .= ";";
 
return $sql; 
 
 }
 

/**
   * Return textual representation of last error, see PDO::errorInfo().
   *
   * @return array with information on the error.
   */
  public function ErrorInfo() {
    return $this->stmt->errorInfo();
  }
  

}
 

