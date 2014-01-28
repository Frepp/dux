<?php

class CPage{
	
public function __construct($ct, $db) {
  $this->ct=$ct;
  $this->db=$db;
  $this->url = isset($_GET['url']) ? $_GET['url'] : null;    
  $this->acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null; 
  $sql = "
SELECT *
FROM kmom05_content
WHERE
  type = 'page' AND
  url = ? AND
  published <= NOW();
";

$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($this->url));
$this->res = $res[0];

}	
		
public function pagetitle(){
	$title  = htmlentities($this->res->title, null, 'UTF-8');
	return $title;
	
	
}


public function pagecontent(){	
	$data   = $this->ct->doFilter(htmlentities($this->res->data, null, 'UTF-8'), $this->res->filter);
	$editLink = $this->acronym ? "<a href='edit.php?id={$this->res->id}'>Uppdatera sidan</a>" : null;

$content = "<article>
<header>
<h1>{$this->pagetitle()}</h1>
</header>
 
{$data}
 
<footer>
{$editLink}
</footer
</article>";

return $content;




}

	
}

