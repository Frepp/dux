<?php

class CContent {


   public function __construct($db) {
   $this->db = $db;}
   
   
 /**
 * Create a link to the content, based on its type.
 *
 * @param object $content to link to.
 * @return string with url to display content.
 */
function getUrlToContent($content) {
  switch($content->type) {
    case 'page': return "<a href=\"page.php?url={$content->url}\">visa</a>"; break;
    case 'post': return "<a href=\"blog.php?slug={$content->slug}\">visa</a>"; break;
    default: return null; break;
  }
}

function geturltoedit($content){
	return "<a href=\"edit.php?id={$content->id}\">editera</a>";	
	
	
}

function geturltodelete($content){
	return "<a href=\"delete.php?id={$content->id}\">radera</a>";
	
}

  /**
  * Return textual representation of last error, see PDO::errorInfo().
  *
  * @return array with information on the error.
  */
 public function ErrorInfo() {
    return $this->stmt->errorInfo();
  }	
	
	
public function getcontentlist(){	
	
$sql = "SELECT *, (published <= NOW()) AS available
FROM kmom05_content;";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

$ul = "<ul>";
foreach($res AS $val) {
  $ul .= "<li>{$val->type}: {$val->title} ({$this->getUrlToContent($val)} {$this->geturltoedit($val)} {$this->geturltodelete($val)})</li>";
};

$ul .="</ul>";	

return "$ul";

}

public function restore(){
	
$sql = "DROP TABLE IF EXISTS kmom05_content;
CREATE TABLE kmom05_content
(
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  slug CHAR(80) UNIQUE,
  url CHAR(80) UNIQUE,
 
  type CHAR(80),
  title VARCHAR(80),
  data TEXT,
  filter CHAR(80),
 
  published DATETIME,
  created DATETIME,
  updated DATETIME,
  deleted DATETIME
 
) ENGINE INNODB CHARACTER SET utf8;


INSERT INTO kmom05_content (slug, url, type, title, data, filter, published, created) VALUES
  ('hem', 'hem', 'page', 'Hem', \"Detta är min hemsida. Den är skriven i [url=http://en.wikipedia.org/wiki/BBCode]bbcode[/url] vilket innebär att man kan formattera texten till [b]bold[/b] och [i]kursiv stil[/i] samt hantera länkar.\n\nDessutom finns ett filter 'nl2br' som lägger in <br>-element istället för \\n, det är smidigt, man kan skriva texten precis som man tänker sig att den skall visas, med radbrytningar.\", 'bbcode,nl2br', NOW(), NOW()),
  ('om', 'om', 'page', 'Om', \"Detta är en sida om mig och min webbplats. Den är skriven i [Markdown](http://en.wikipedia.org/wiki/Markdown). Markdown innebär att du får bra kontroll över innehållet i din sida, du kan formattera och sätta rubriker, men du behöver inte bry dig om HTML.\n\nRubrik nivå 2\n-------------\n\nDu skriver enkla styrtecken för att formattera texten som **fetstil** och *kursiv*. Det finns ett speciellt sätt att länka, skapa tabeller och så vidare.\n\n###Rubrik nivå 3\n\nNär man skriver i markdown så blir det läsbart även som textfil och det är lite av tanken med markdown.\", 'markdown', NOW(), NOW()),
  ('blogpost-1', NULL, 'post', 'Välkommen till min blogg!', \"Detta är en bloggpost.\n\nNär det finns länkar till andra webbplatser så kommer de länkarna att bli klickbara.\n\nhttp://dbwebb.se är ett exempel på en länk som blir klickbar.\", 'link,nl2br', NOW(), NOW()),
  ('blogpost-2', NULL, 'post', 'Nu har sommaren kommit', \"Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost.\", 'nl2br', NOW(), NOW()),
  ('blogpost-3', NULL, 'post', 'Nu har hösten kommit', \"Detta är en bloggpost som berättar att sommaren har kommit, ett budskap som kräver en bloggpost\", 'nl2br', NOW(), NOW())
;";

$this->db->ExecuteQuery($sql);
	
	
}

public function edit(){
	
// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
$data   = isset($_POST['data'])  ? $_POST['data'] : array();
$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
$filter = isset($_POST['filter']) ? $_POST['filter'] : array();
$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($save) {
  $sql = '
    UPDATE kmom05_content SET
      title   = ?,
      slug    = ?,
      url     = ?,
      data    = ?,
      type    = ?,
      filter  = ?,
      published = ?,
      updated = NOW()
    WHERE 
      id = ?
  ';
  $url = empty($url) ? null : $url;
  $params = array($title, $slug, $url, $data, $type, $filter, $published, $id);
  $res = $this->db->ExecuteQuery($sql, $params);
  if($res) {
    $output = 'Informationen sparades.';
  }
  else {
    $output = 'Informationen sparades EJ.<br><pre>' . print_r($db->ErrorInfo(), 0) . '</pre>';
  }
}


// Select from database
$sql = 'SELECT * FROM kmom05_content WHERE id = ?';
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll med sådant id.');
}

// Sanitize content before using it.
$title  = htmlentities($c->title, null, 'UTF-8');
$slug   = htmlentities($c->slug, null, 'UTF-8');
$url    = htmlentities($c->url, null, 'UTF-8');
$data   = htmlentities($c->data, null, 'UTF-8');
$type   = htmlentities($c->type, null, 'UTF-8');
$filter = htmlentities($c->filter, null, 'UTF-8');
$published = htmlentities($c->published, null, 'UTF-8');
	
return "<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug' value='{$slug}'/></label></p>
  <p><label>Url:<br/><input type='text' name='url' value='{$url}'/></label></p>
  <p><label>Text:<br/><textarea name='data'>{$data}</textarea></label></p>
  <p><label>Type:<br/><input type='text' name='type' value='{$type}'/></label></p>
  <p><label>Filter:<br/><input type='text' name='filter' value='{$filter}'/></label></p>
  <p><label>Publiseringsdatum:<br/><input type='text' name='published' value='{$published}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  <p><a href='view.php'>Visa alla</a></p>
  <output>{$output}</output>
  </fieldset>
</form>";


}

public function delete(){

$id     = (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$delete   = isset($_POST['delete'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

isset($acronym) or die('Check: You must login to edit.');
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($delete) {
  $sql = "
    delete from kmom05_content
    WHERE 
      id = " . $id . "
  ";
   $this->db->ExecuteQuery($sql);
  $output = "Innehållet raderades. ";
}


// Select from database
$sql = "SELECT * FROM kmom05_content WHERE id = " . $id . "";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

if(isset($res[0])) {
  $output2 = null;
}
else {
  $output2 = 'Det finns inget innehåll med sådant id.';
}
return "<form method=post>
  <fieldset>
  <legend>Radera innehåll</legend>
  <p class=buttons><input type='submit' name='delete' value='Radera'/></p>
  <output>{$output}{$output2}</output>
  </fieldset>
</form>";	
}

public function add(){
	
// Get parameters 
$title  = isset($_POST['title']) ? $_POST['title'] : null;
$slug   = isset($_POST['slug'])  ? $_POST['slug']  : null;
$url    = isset($_POST['url'])   ? strip_tags($_POST['url']) : null;
$data   = isset($_POST['data'])  ? $_POST['data'] : array();
$type   = isset($_POST['type'])  ? strip_tags($_POST['type']) : array();
$filter = isset($_POST['filter']) ? $_POST['filter'] : array();
$published = isset($_POST['published'])  ? strip_tags($_POST['published']) : array();
$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


// Check that incoming parameters are valid
isset($acronym) or die('Check: You must login to edit.');


// Check if form was submitted
$output = null;
if($save) {
  $sql = "
    INSERT INTO kmom05_content (slug, url, type, title, data, filter, published, created) VALUES
  (?, ?, ?, ?, ?, ?, ?, NOW());
  ";
  $params = array($slug, $url, $type, $title, $data, $filter, $published);
  $this->db->ExecuteQuery($sql, $params);
}
	
return "<form method=post>
  <fieldset>
  <legend>Lägg till innehåll</legend>
  <p><label>Titel:<br/><input type='text' name='title' required/></label></p>
  <p><label>Slug:<br/><input type='text' name='slug'/></label></p>
  <p><label>Url:<br/><input type='text' name='url'/></label></p>
  <p><label>Text:<br/><textarea name='data'></textarea></label></p>
  <p><label>Type:<br/><input type='text' name='type' required/></label></p>
  <p><label>Filter:<br/><input type='text' name='filter'/></label></p>
  <p><label>Publiseringsdatum:<br/><input type='text' name='published'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
  <p><a href='view2.php'>Visa alla</a></p>
  <output>{$output}</output>
  </fieldset>
</form>";


}


}
