<?php

class CBlog{
	
public function __construct($ct, $db) {
  $this->ct=$ct;
  $this->db=$db;
  $this->slug = isset($_GET['slug']) ? $_GET['slug'] : null;
  }


public function blog(){	  
$slugSql = $this->slug ? 'slug = ?' : '1';
$sql = "
SELECT *
FROM kmom05_content
WHERE
  type = 'post' AND
  $slugSql AND
  published <= NOW()
ORDER BY updated DESC
;
";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($this->slug));

if(isset($res[0])) {
  foreach($res as $val) {
    $title  = htmlentities($val->title, null, 'UTF-8');
    $data   = $this->ct->doFilter(htmlentities($val->data, null, 'UTF-8'), $val->filter);
 
    $content = "<section>
  <article>
  <header>
  <h1><a href='blog.php?slug={$val->slug}'>{$title}</a></h1>
  </header>
 
  {$data}
 
  <footer>
  </footer
  </article>
</section>";
  }
}
else if($slug) {
  $content = "Det fanns inte en sådan bloggpost.";
}
else {
  $content = "Det fanns inga bloggposter.";
}


return $content;

}

	
}

