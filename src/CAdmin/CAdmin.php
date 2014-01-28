<?php

class CAdmin {


   public function __construct($db) {
   $this->db = $db;}
 

  /**
  * Return textual representation of last error, see PDO::errorInfo().
  *
  * @return array with information on the error.
  */
 public function ErrorInfo() {
    return $this->stmt->errorInfo();
  }	
	
	
public function getmovielist(){	
	
$sql = "SELECT id, title from proj_Movie order by id;";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

$ul = "<ul>";
foreach($res AS $val) {
  $ul .= "<li>{$val->id}: {$val->title} <a href='?movies&edit&id={$val->id}'>Redigera</a> | <a href='?movies&delete&id={$val->id}'>Radera</a></li>";
};

$ul .="</ul>";	

return "$ul";

}

public function getnewslist(){	
	
$sql = "SELECT id, title from proj_News order by id;";
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql);

$ul = "<ul>";
foreach($res AS $val) {
  $ul .= "<li>{$val->id}: {$val->title} <a href='?news&edit&id={$val->id}'>Redigera</a> | <a href='?news&delete&id={$val->id}'>Radera</a></li>";
};

$ul .="</ul>";	

return "$ul";

}

public function restore(){
	
$sql = "
USE frpe13;

SET NAMES 'utf8';

--
-- Drop all tables in the right order.
--
DROP TABLE IF EXISTS proj_Movie2Genre;
DROP TABLE IF EXISTS proj_Genre;
DROP TABLE IF EXISTS oophp_User;
DROP TABLE IF EXISTS proj_Movie;
DROP TABLE IF EXISTS proj_News;


--
-- Create table for my own movie database
--
CREATE TABLE proj_Movie
(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    title VARCHAR(100) NOT NULL,
    director VARCHAR(100),
    length INT DEFAULT NULL, -- Length in minutes
    year INT(4) NOT NULL DEFAULT 1900,
    plot TEXT, -- Short intro to the movie
    image VARCHAR(100) DEFAULT NULL, -- Link to an image
	image2 VARCHAR(100) DEFAULT NULL, -- Link to an image
    trailer VARCHAR(120) DEFAULT NULL,
	price FLOAT(5,2)
) ENGINE INNODB CHARACTER SET utf8;

INSERT INTO proj_Movie (title, director, length, year, plot, image, image2, trailer, price) VALUES
    ('Nyckeln till frihet', 'Frank Darabont', 142, 1994, 'Andy Dufresne is a young and successful banker whose life changes drastically when he is convicted and sentenced to life imprisonment for the murder of his wife and her lover. Set in the 1940\'s, the film shows how Andy, with the help of his friend Red, the prison entrepreneur, turns out to be a most unconventional prisoner.', 'nyckeln.jpg', 'nyckeln2.jpg', '//www.youtube.com/embed/6hB3S9bIaco?rel=0', '79.90'),
	('Gudfadern', 'Francis Ford Coppola', 175, 1972, 'The story begins as \"Don\" Vito Corleone, the head of a New York Mafia \"family\", oversees his daughter\'s wedding with his wife Wendy. His beloved son Michael has just come home from the war, but does not intend to become part of his father\'s business. Through Michael\'s life the nature of the family business becomes clear. The business of the family is just like the head of the family, kind and benevolent to those who give respect, but given to ruthless violence whenever anything stands against the good of the family. Don Vito lives his life in the way of the old country, but times are changing and some don\'t want to follow the old ways and look out for community and \"family\". An up and coming rival of the Corleone family wants to start selling drugs in New York, and needs the Don\'s influence to further his plan. The clash of the Don\'s fading old world values and the new ways will demand a terrible price, especially from Michael, all for the sake of the family.', 'gudfadern.jpg', 'gudfadern2.jpg', '//www.youtube.com/embed/sY1S34973zA?rel=0', '69.90'),
	('Gudfadern del II', 'Francis Ford Coppola', 200, 1974, 'The continuing saga of the Corleone crime family tells the story of a young Vito Corleone growing up in Sicily and in 1910s New York; and follows Michael Corleone in the 1950s as he attempts to expand the family business into Las Vegas, Hollywood and Cuba.', 'gudfadernd2.jpg', 'gudfadernd22.jpg', '//www.youtube.com/embed/qJr92K_hKl0?rel=0', '69.90'),
	('The Dark Knight', 'Christopher Nolan', 152, 2008, 'Batman raises the stakes in his war on crime. With the help of Lieutenant Jim Gordon and District Attorney Harvey Dent, Batman sets out to dismantle the remaining criminal organizations that plague the city streets. The partnership proves to be effective, but they soon find themselves prey to a reign of chaos unleashed by a rising criminal mastermind known to the terrified citizens of Gotham as The Joker.', 'darkknight.jpg', 'darkknight2.jpg', '//www.youtube.com/embed/yQ5U8suTUw0?rel=0', '89.90'),
	('Pulp Fiction', 'Quentin Tarantino', 154, 1994, 'Jules Winnfield and Vincent Vega are two hitmen who are out to retrieve a suitcase stolen from their employer, mob boss Marsellus Wallace. Wallace has also asked Vincent to take his wife Mia out a few days later when Wallace himself will be out of town. Butch Coolidge is an aging boxer who is paid by Wallace to lose his next fight. The lives of these seemingly unrelated people are woven together comprising of a series of funny, bizarre and uncalled-for incidents.', 'pulpfiction.jpg', 'pulpfiction2.jpg', '//www.youtube.com/embed/wZBfmBvvotE?rel=0', '69.90'),
	('Den gode, den onde, den fule', 'Sergio Leone', 161, 1966, 'Blondie (The Good) is a professional gunslinger who is out trying to earn a few dollars. Angel Eyes (The Bad) is a hit man who always commits to a task and sees it through, as long as he is paid to do so. And Tuco (The Ugly) is a wanted outlaw trying to take care of his own hide. Tuco and Blondie share a partnership together making money off Tuco\'s bounty, but when Blondie unties the partnership, Tuco tries to hunt down Blondie. When Blondie and Tuco comes across a horse carriage loaded with dead bodies, they soon learn from the only survivor (Bill Carson) that he and a few other men have buried a stash of gold in a cemetery. Unfortunately Carson dies and Tuco only finds out the name of the cemetery, while Blondie finds out the name on the grave. Now the two must keep each other alive in order to find the gold. Angel Eyes (who had been looking for Bill Carson) discovers that Tuco and Blondie meet with Carson and knows they know the location of the gold. All he needs is for the two to ...', 'dengode.jpg', 'dengode2.jpg', '//www.youtube.com/embed/JdkSuurdbDA?rel=0', '39.90'),
	('Schindler\'s list', 'Steven Spielberg', 154, 1993, 'Oskar Schindler is a vainglorious and greedy German businessman who becomes unlikely humanitarian amid the barbaric Nazi reign when he feels compelled to turn his factory into a refuge for Jews. Based on the true story of Oskar Schindler who managed to save about 1100 Jews from being gassed at the Auschwitz concentration camp. A testament for the good in all of us.', 'schindlers.jpg', 'schindlers2.jpg', '//www.youtube.com/embed/dwfIf1WMhgc?rel=0', '59.90'),
	('12 edsvurna män', 'Sidney Lumet', 96, 1957, 'The defense and the prosecution have rested and the jury is filing into the jury room to decide if a young Spanish-American is guilty or innocent of murdering his father. What begins as an open and shut case of murder soon becomes a mini-drama of each of the jurors\' prejudices and preconceptions about the trial, the accused, and each other. Based on the play, all of the action takes place on the stage of the jury room.', '12edsvurna.jpg', '12edsvurna2.jpg', '//www.youtube.com/embed/A7CBKT0PWFA?rel=0', '29.90'),
	('Sagan om konungens återkomst', 'Peter Jackson', 201, 2003, 'While Frodo & Sam continue to approach Mount Doom to destroy the One Ring, unaware of the path Gollum is leading them, the former Fellowship aid Rohan & Gondor in a great battle in the Pelennor Fields, Minas Tirith and the Black Gates as Sauron wages his last war against Middle-Earth.', 'konungens.jpg', 'konungens2.jpg', '//www.youtube.com/embed/r5X-hFf6Bwo?rel=0', '69.90'),
	('Fight Club', 'David Fincher', 139, 1999, 'A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy. Their concept catches on, with underground \"fight clubs\" forming in every town, until an eccentric gets in the way and ignites an out-of-control spiral toward oblivion.', 'fightclub.jpg', 'fightclub2.jpg', '//www.youtube.com/embed/SUXWAEX2jlg?rel=0', '59.90'),
	('Sagan om ringen: Härskarringen', 'Peter Jackson', 178, 2001, 'An ancient Ring thought lost for centuries has been found, and through a strange twist in fate has been given to a small Hobbit named Frodo. When Gandalf discovers the Ring is in fact the One Ring of the Dark Lord Sauron, Frodo must make an epic quest to the Cracks of Doom in order to destroy it! However he does not go alone. He is joined by Gandalf, Legolas the elf, Gimli the Dwarf, Aragorn, Boromir and his three Hobbit friends Merry, Pippin and Samwise. Through mountains, snow, darkness, forests, rivers and plains, facing evil and danger at every corner the Fellowship of the Ring must go. Their quest to destroy the One Ring is the only hope for the end of the Dark Lords reign!', 'harskarringen.jpg', 'harskarringen2.jpg', '//www.youtube.com/embed/V75dMMIW2B4?rel=0', '59.90' ),
	('Rymdimperiet slår tillbaka', 'Irvin Kershner', 124, 1980, 'Fleeing the evil Galactic Empire, the Rebels abandon their new base in an assault with the Imperial AT-AT walkers on the ice world of Hoth. Princess Leia, Han Solo, Chewbacca and the droid C-3PO escape in the Millennium Falcon, but are later captured by Darth Vader on Bespin. Meanwhile, Luke Skywalker and the droid R2-D2 follows Obi-Wan Kenobi\'s posthumous command, and receives Jedi training from Master Yoda on the swamp world of Dagobah. Will Skywalker manage to rescue his friends from the Dark Lord?', 'rymdimperiet.jpg', 'rymdimperiet2.jpg', '//www.youtube.com/embed/mSH3n_up6LE?rel=0', '49.90'),
	('Inception', 'Cristopher Nolan', 148, 2010, 'Dom Cobb is a skilled thief, the absolute best in the dangerous art of extraction, stealing valuable secrets from deep within the subconscious during the dream state, when the mind is at its most vulnerable. Cobb\'s rare ability has made him a coveted player in this treacherous new world of corporate espionage, but it has also made him an international fugitive and cost him everything he has ever loved. Now Cobb is being offered a chance at redemption. One last job could give him his life back but only if he can accomplish the impossible-inception. Instead of the perfect heist, Cobb and his team of specialists have to pull off the reverse: their task is not to steal an idea but to plant one. If they succeed, it could be the perfect crime. But no amount of careful planning or expertise can prepare the team for the dangerous enemy that seems to predict their every move. An enemy that only Cobb could have seen coming.', 'inception.jpg', 'inception2.jpg', '//www.youtube.com/embed/8hP9D6kZseM?rel=0', '79.90'),
	('Gökboet', 'Milos Forman', 133, 1975, 'McMurphy has a criminal past and has once again gotten himself into trouble with the law. To escape labor duties in prison, McMurphy pleads insanity and is sent to a ward for the mentally unstable. Once here, McMurphy both endures and stands witness to the abuse and degradation of the oppressive Nurse Ratched, who gains superiority and power through the flaws of the other inmates. McMurphy and the other inmates band together to make a rebellious stance against the atrocious Nurse.', 'gokboet.jpg', 'gokboet2.jpg', '//www.youtube.com/embed/2WSyJgydTsA?rel=0', '29.90'),
	('Forrest Gump', 'Robert Zemeckis', 142, 1994, 'Forrest Gump is a simple man with a low I.Q. but good intentions. He is running through childhood with his best and only friend Jenny. His \"mama\" teaches him the ways of life and leaves him to choose his destiny. Forrest joins the army for service in Vietnam, finding new friends called Dan and Bubba, he wins medals, creates a famous shrimp fishing fleet, inspires people to jog, starts a ping-pong craze, create the smiley, write bumper stickers and songs, donating to people and meeting the president several times. However, this is all irrelevant to Forrest who can only think of his childhood sweetheart Jenny Curran. Who has messed up her life. Although in the end all he wants to prove is that anyone can love anyone.', 'forrest.jpg', 'forrest2.jpg', '//www.youtube.com/embed/uPIEn0M8su0?rel=0', '49.90'),
	('Maffiabröder', 'Martin Scorsese', 146, 1990, 'Henry Hill is a small time gangster, who takes part in a robbery with Jimmy Conway and Tommy De Vito, two other gangsters who have set their sights a bit higher. His two partners kill off everyone else involved in the robbery, and slowly start to climb up through the hierarchy of the Mob. Henry, however, is badly affected by his partners success, but will he stoop low enough to bring about the downfall of Jimmy and Tommy?', 'maffia.jpg', 'maffia2.jpg', '//www.youtube.com/embed/qo5jJpHtI1Y?rel=0', '39.90'),
	('Sagan om de två tornen', 'Peter Jackson', 179, 2002, 'Sauron\'s forces increase. His allies grow. The Ringwraiths return in an even more frightening form. Saruman\'s army of Uruk Hai is ready to launch an assault against Aragorn and the people of Rohan. Yet, the Fellowship is broken and Boromir is dead. For the little hope that is left, Frodo and Sam march on into Mordor, unprotected. A number of new allies join with Aragorn, Gimli, Legolas, Pippin and Merry. And they must defend Rohan and attack Isengard. Yet, while all this is going on, Sauron\'s troops mass toward the City of Gondor, for the War of the Ring is about to begin.', 'tornen.jpg', 'tornen2.jpg', '//www.youtube.com/embed/yBNSOdEjtZs?rel=0', '59.90'),
	('Stjärnornas krig', 'George Lucas', 121, 1977, 'Part IV in George Lucas\' epic, Star Wars: A New Hope opens with a Rebel ship being boarded by the tyrannical Darth Vader. The plot then follows the life of a simple farm boy, Luke Skywalker, as he and his newly met allies (Han Solo, Chewbacca, Obi-Wan Kenobi, C-3PO, R2-D2) attempt to rescue a Rebel leader, Princess Leia, from the clutches of the Empire. The conclusion is culminated as the Rebels, including Skywalker and flying ace Wedge Antilles make an attack on the Empire\'s most powerful and ominous weapon, the Death Star.', 'starwars.jpg', 'starwars2.jpg', '//www.youtube.com/embed/1g3_CFmnU7k?rel=0', '39.90'),
	('Matrix', 'Andy & Lana Wachowski',136 , 1999, 'Thomas A. Anderson is a man living two lives. By day he is an average computer programmer and by night a hacker known as Neo. Neo has always questioned his reality, but the truth is far beyond his imagination. Neo finds himself targeted by the police when he is contacted by Morpheus, a legendary computer hacker branded a terrorist by the government. Morpheus awakens Neo to the real world, a ravaged wasteland where most of humanity have been captured by a race of machines that live off of the humans\' body heat and electrochemical energy and who imprison their minds within an artificial reality known as the Matrix. As a rebel against the machines, Neo must return to the Matrix and confront the agents: super-powerful computer programs devoted to snuffing out Neo and the entire human rebellion.', 'matrix.jpg', 'matrix2.jpg', '//www.youtube.com/embed/UM5yepZ21pI?rel=0', '49.90'),
	('De sju samurajerna', 'Akira Kurosawa', 207, 1954, 'A veteran samurai, who has fallen on hard times, answers a village\'s request for protection from bandits. He gathers 6 other samurai to help him, and they teach the townspeople how to defend themselves, and they supply the samurai with three small meals a day. The film culminates in a giant battle when 40 bandits attack the village.', 'samuraj.jpg', 'samuraj2.jpg', '//www.youtube.com/embed/xnRUHtSgJ9o?rel=0', '39.90'),
	('Guds stad', 'Fernando Meirelles & Kátia Lund', 130, 2002, 'Brazil, 1960\'s, City of God. The Tender Trio robs motels and gas trucks. Younger kids watch and learn well...too well. 1970\'s: Li\'l Zé has prospered very well and owns the city. He causes violence and fear as he wipes out rival gangs without mercy. His best friend Bené is the only one to keep him on the good side of sanity. Rocket has watched these two gain power for years, and he wants no part of it. Yet he keeps getting swept up in the madness. All he wants to do is take pictures. 1980\'s: Things are out of control between the last two remaining gangs...will it ever end? Welcome to the City of God.', 'gudsstad.jpg', 'gudsstad2.jpg', '//www.youtube.com/embed/ioUE_5wpg_E?rel=0', '49.90'),
	('Seven', 'David Fincher', 127, 1995, 'A film about two homicide detectives\' desperate hunt for a serial killer who justifies his crimes as absolution for the world\'s ignorance of the Seven Deadly Sins. The movie takes us from the tortured remains of one victim to the next as the sociopathic \"John Doe\" sermonizes to Detectives Sommerset and Mills -- one sin at a time. The sin of Gluttony comes first and the murderer\'s terrible capacity is graphically demonstrated in the dark and subdued tones characteristic of film noir. The seasoned and cultured but jaded Sommerset researches the Seven Deadly Sins in an effort to understand the killer\'s modus operandi while the bright but green and impulsive Detective Mills scoffs at his efforts to get inside the mind of a killer...', 'seven.jpg', 'seven2.jpg', '//www.youtube.com/embed/J4YV2_TcCoE?rel=0', '39.90'),
	('De misstänkta', 'Bryan Singer', 106, 1995, 'Following a truck hijack in New York, five conmen are arrested and brought together for questioning. As none of them is guilty, they plan a revenge operation against the police. The operation goes well, but then the influence of a legendary mastermind criminal called Keyser Söze is felt. It becomes clear that each one of them has wronged Söze at some point and must pay back now. The payback job leaves 27 men dead in a boat explosion, but the real question arises now: Who actually is Keyser Söze?', 'misstankta.jpg', 'misstankta2.jpg', '//www.youtube.com/embed/9MjV4EwR7Mg?rel=0', '29.90'),
	('Harmonica - En hämnare', 'Sergio Leone', 175, 1968, 'Story of a young woman, Mrs. McBain, who moves from New Orleans to frontier Utah, on the very edge of the American West. She arrives to find her new husband and family slaughtered, but by who? The prime suspect, coffee-lover Cheyenne, befriends her and offers to go after the real killer, assassin gang leader Frank, in her honor. He is accompanied by Harmonica on his quest to get even. Get-rich-quick subplots and intricate character histories intertwine with such artistic flair that this could in fact be the movie-to-end-all-movies.', 'harmonica.jpg', 'harmonica2.jpg', '//www.youtube.com/embed/LTcTVeShSV8?rel=0', '49.90'),
	('När lammen tystnar', 'Jonathan Demme', 118, 1991, 'Young FBI agent Clarice Starling is assigned to help find a missing woman to save her from a psychopathic serial killer who skins his victims. Clarice attempts to gain a better insight into the twisted mind of the killer by talking to another psychopath Hannibal Lecter, who used to be a respected psychiatrist. FBI agent Jack Crawford believes that Lecter, who is also a very powerful and clever mind manipulator, has the answers to their questions and can help locate the killer. However, Clarice must first gain Lecter\'s confidence before the inmate will give away any information.', 'lammen.jpg', 'lammen2.jpg', '//www.youtube.com/embed/lQKs169Sl0I?rel=0', '39.90')
    
;


--
-- Add tables for genre
--
CREATE TABLE proj_Genre
(
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name CHAR(20) NOT NULL -- crime, svenskt, college, drama, etc
) ENGINE INNODB CHARACTER SET utf8;

INSERT INTO proj_Genre (name) VALUES  
    ('crime'), ('drama'), ('thriller'), 
  	('action'), ('adventure'), ('western'),
	('biography'), ('history'), ('fantasy'),
	('sci-fi'), ('mystery'), ('romance')
	
;

CREATE TABLE proj_Movie2Genre
(
    idMovie INT NOT NULL,
    idGenre INT NOT NULL,

    FOREIGN KEY (idMovie) REFERENCES proj_Movie (id) on delete cascade,
    FOREIGN KEY (idGenre) REFERENCES proj_Genre (id),

    PRIMARY KEY (idMovie, idGenre)
) ENGINE INNODB;


INSERT INTO proj_Movie2Genre (idMovie, idGenre) VALUES
	(1, 1),(1, 2),
	(2, 1),(2, 2),
	(3, 1),(3, 2),
	(4, 1),(4, 2),(4, 3),(4, 4),
	(5, 1),(5, 2),(5, 3),
	(6, 5),(6, 6),
	(7, 2),(7, 7),(7, 8),
	(8, 2),
	(9, 4),(9, 5),(9, 9),
	(10, 2),
	(11, 4),(11, 5),(11, 9),
	(12, 4),(12, 5),(12, 10),
	(13, 4),(13, 5),(13, 10),(13, 11),(13, 3),
	(14, 2),
	(15, 2),(15, 12),
	(16, 7),(16, 1),(16, 2),(16,3),
	(17, 4),(17, 5),(17, 9),
	(18, 4),(18, 5),(18, 9),(18, 10),
	(19, 4),(19, 5),(19, 10),
	(20, 4),(20, 2),
	(21, 1),(21, 2),
	(22, 1),(22, 11),(22, 3),
	(23, 1),(23, 11),(23, 3), 
	(24, 5),(24, 6),
	(25, 1),(25, 2),(25, 3)  
;

DROP VIEW IF EXISTS VMovie;

CREATE VIEW VMovie
AS
SELECT 
    M.*,
    GROUP_CONCAT(G.name) AS genre
FROM proj_Movie AS M
    LEFT OUTER JOIN proj_Movie2Genre AS M2G
        ON M.id = M2G.idMovie

    LEFT OUTER JOIN proj_Genre AS G
         ON M2G.idGenre = G.id
GROUP BY M.id
;

select * from VMovie;


--
-- Table for user
--
CREATE TABLE oophp_User
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  acronym CHAR(12) UNIQUE NOT NULL,
  name VARCHAR(80),
  password CHAR(32),
  salt INT NOT NULL
) ENGINE INNODB CHARACTER SET utf8;

INSERT INTO oophp_User (acronym, name, salt) VALUES 
  ('doe', 'John/Jane Doe', unix_timestamp()),
  ('admin', 'Administrator', unix_timestamp())
;

UPDATE oophp_User SET password = md5(concat('doe', salt)) WHERE acronym = 'doe';
UPDATE oophp_User SET password = md5(concat('admin', salt)) WHERE acronym = 'admin';

--
-- Table for news
--

CREATE TABLE proj_News
(
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(80) UNIQUE NOT NULL,
  content text,
  category VARCHAR(25)
) ENGINE INNODB CHARACTER SET utf8;

insert into proj_News(title, content, category) values
('Nu kör vi!', 'Äntligen är hemsida, avtal, personal och sist men inte minst filmer på plats. Detta betyder att vi kan slå upp portarna och köra igång på allvar. Till sist vill vi uppmana alla att hålla utkik här på hemsidan efter några riktigt läckre öppningserbjudanden.', 'nyheter'),
('Hyr 3 betala för 2!', 'För att fira att vi äntligen har kommit igång så drar vi nu igång det första öppningserbjudandet. Du får välja och vraka i vårt stora utbud och betalar endast för 2 när du väljer 3, så passa på att ladda upp ordentligt i kylan inför helgen!', 'erbjudanden'),
('Hjälp oss att välja film!', 'Vi jobbar kontinuerligt med att utöka vårt filmbestånd och vill nu ha din hjälp. Vilka filmer vill du se? Kontakta oss på info@rentalmovies.se med dina önskemål!', 'nyheter'),
('50% på valfri film', 'Vi har utökat med ytterligare filmer och detta vill vi fira genom ett supererbjudande. Just nu får du 50% rabatt på valfri film, erbjudandet gäller veckan ut så skynda att fynda!', 'erbjudanden'),
('Filmexperten rekommenderar', 'Vi har kallat in filmexperten Aron Devede som nu har satt ihop en superlista på de bästa filmerna. Självklart hittar du de här på rentalmovies.se<ol><li>Inception, ett mästerverk som måste ses!</li><li>Schindler’s list, hemsk berättelse som är mycket sevärd!</li><li>Forrest Gump, Du förstår varför när du sett den</li></ol>', 'nyheter'),
('Tävla och vinn!', 'Just nu kan du här på hemsidan tävla och vinna valfri film helt gratis. Tävlingsregler och övrig information hittar du <a href=\"tavling.php\">här!</a>
Vi önskar alla ett stort Lycka till!
', 'erbjudanden'),
('Bli vår 1000:e kund och vinn!', 'Vi närmar oss nu vår 1000:e kund och detta ska naturligtvis firas. Blir du den lycklige 1000:e kunden så vinner du gratis film i ett helt år. En film i veckan får du, helt gratis, och du får välja i hela vårt superbreda sortiment.', 'erbjudanden')

;";

$this->db->ExecuteQuery($sql);
	
	
}

public function editmovie(){
	
// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$director   = isset($_POST['director'])  ? strip_tags($_POST['director'])  : null;
$length    = isset($_POST['length'])   ? strip_tags($_POST['length']) : null;
$year    = isset($_POST['year'])   ? strip_tags($_POST['year']) : null;
$plot    = isset($_POST['plot'])   ? strip_tags($_POST['plot']) : null;
$image    = isset($_POST['image'])   ? strip_tags($_POST['image']) : null;
$image2    = isset($_POST['image2'])   ? strip_tags($_POST['image2']) : null;
$trailer    = isset($_POST['trailer'])   ? strip_tags($_POST['trailer']) : null;
$price    = isset($_POST['price'])   ? strip_tags($_POST['price']) : null;
$save   = isset($_POST['save'])  ? true : false;



// Check that incoming parameters are valid
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($save) {
  $sql = '
    UPDATE proj_Movie SET
      title   = ?,
      director    = ?,
      length     = ?,
      year    = ?,
      plot    = ?,
      image  = ?,
      image2 = ?,
      trailer = ?,
	  price = ?
    WHERE 
      id = ?
  ';
  $params = array($title, $director, $length, $year, $plot, $image, $image2, $trailer, $price, $id);
  $res = $this->db->ExecuteQuery($sql, $params);
  if($res) {
    $output = 'Informationen sparades.';
  }
  else {
    $output = 'Informationen sparades EJ.<br><pre>' . print_r($db->ErrorInfo(), 0) . '</pre>';
  }
}


// Select from database
$sql = 'SELECT * FROM proj_Movie WHERE id = ?';
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll med sådant id.');
}

// Sanitize content before using it.
$title  = htmlentities($c->title, null, 'UTF-8');
$director   = htmlentities($c->director, null, 'UTF-8');
$length    = htmlentities($c->length, null, 'UTF-8');
$year   = htmlentities($c->year, null, 'UTF-8');
$plot   = htmlentities($c->plot, null, 'UTF-8');
$image = htmlentities($c->image, null, 'UTF-8');
$image2 = htmlentities($c->image2, null, 'UTF-8');
$trailer = htmlentities($c->trailer, null, 'UTF-8');
$price = htmlentities($c->price, null, 'UTF-8');
	
return "<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Regissör:<br/><input type='text' name='director' value='{$director}'/></label></p>
  <p><label>Längd:<br/><input type='number' name='length' value='{$length}'/></label></p>
  <p><label>År:<br/><input type='number' name='year' value='{$year}'/></label></p>
  <p><label>Synopsis:<br/><textarea name='plot'>{$plot}</textarea></label></p>
  <p><label>Bild:<br/><input type='text' name='image' value='{$image}'/></label></p>
  <p><label>Bild:<br/><input type='text' name='image2' value='{$image2}'/></label></p>
  <p><label>Trailer:<br/><input type='text' name='trailer' value='{$trailer}'/></label></p>
  <p><label>Pris:<br/><input type='text' name='price' value='{$price}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  </fieldset>
</form>";


}

public function editnew(){
	
// Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$content   = isset($_POST['content'])  ? strip_tags($_POST['content'])  : null;
$category    = isset($_POST['category'])   ? strip_tags($_POST['category']) : null;
$save   = isset($_POST['save'])  ? true : false;



// Check that incoming parameters are valid
is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($save) {
  $sql = '
    UPDATE proj_News SET
      title   = ?,
      content    = ?,
      category     = ?
    WHERE 
      id = ?
  ';
  $params = array($title, $content, $category, $id);
  $res = $this->db->ExecuteQuery($sql, $params);
  if($res) {
    $output = 'Informationen sparades.';
  }
  else {
    $output = 'Informationen sparades EJ.<br><pre>' . print_r($sql) . '</pre>';
  }
}


// Select from database
$sql = 'SELECT * FROM proj_News WHERE id = ?';
$res = $this->db->ExecuteSelectQueryAndFetchAll($sql, array($id));

if(isset($res[0])) {
  $c = $res[0];
}
else {
  die('Misslyckades: det finns inget innehåll med sådant id.');
}

// Sanitize content before using it.
$title  = htmlentities($c->title, null, 'UTF-8');
$content   = htmlentities($c->content, null, 'UTF-8');
$category    = htmlentities($c->category, null, 'UTF-8');
	
return "<form method=post>
  <fieldset>
  <legend>Uppdatera innehåll</legend>
  <input type='hidden' name='id' value='{$id}'/>
  <p><label>Titel:<br/><input type='text' name='title' value='{$title}'/></label></p>
  <p><label>Text:<br/><textarea name='content'>{$content}</textarea></label></p>
  <p><label>Kategori:<br/><input type='text' name='category' value='{$category}'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/> <input type='reset' value='Återställ'/></p>
  </fieldset>
</form>";


}

public function deletemovie(){

$id     = (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$delete   = (isset($_GET['delete']))  ? true : false;

is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($delete) {
  $sql = "
    delete from proj_Movie
    WHERE 
      id = " . $id . "
  ";
   $this->db->ExecuteQuery($sql);
  return $output = "Innehållet med id " . $id . " raderades. ";
}
}

public function deletenew(){

$id     = (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$delete   = (isset($_GET['delete']))  ? true : false;

is_numeric($id) or die('Check: Id must be numeric.');


// Check if form was submitted
$output = null;
if($delete) {
  $sql = "
    delete from proj_News
    WHERE 
      id = " . $id . "
  ";
   $this->db->ExecuteQuery($sql);
  return $output = "Innehållet med id " . $id . " raderades. ";
}
}


public function addmovie(){
	
// Get parameters 
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$director   = isset($_POST['director'])  ? strip_tags($_POST['director'])  : null;
$length    = isset($_POST['length'])   ? strip_tags($_POST['length']) : null;
$year    = isset($_POST['year'])   ? strip_tags($_POST['year']) : null;
$plot    = isset($_POST['plot'])   ? strip_tags($_POST['plot']) : null;
$image    = isset($_POST['image'])   ? strip_tags($_POST['image']) : null;
$image2    = isset($_POST['image2'])   ? strip_tags($_POST['image2']) : null;
$trailer    = isset($_POST['trailer'])   ? strip_tags($_POST['trailer']) : null;
$price    = isset($_POST['price'])   ? strip_tags($_POST['price']) : null;
$save   = isset($_POST['save'])  ? true : false;




// Check if form was submitted
$output = null;
if($save) {
  $sql = "
    INSERT INTO proj_Movie (title, director, length, year, plot, image, image2, trailer, price) VALUES
  (?, ?, ?, ?, ?, ?, ?, ?, ?);
  ";
  $params = array($title, $director, $length, $year, $plot, $image, $image2, $trailer, $price);
  $this->db->ExecuteQuery($sql, $params);
}
	
return "<form method=post>
  <fieldset>
  <legend>Lägg till innehåll</legend>
  <p><label>Titel:<br/><input type='text' required name='title'/></label></p>
  <p><label>Regissör:<br/><input type='text' name='director'/></label></p>
  <p><label>Längd:<br/><input type='number' placeholder='125' name='length'/></label></p>
  <p><label>År:<br/><input type='number' placeholder='1987' name='year'/></label></p>
  <p><label>Synopsis:<br/><textarea name='plot'></textarea></label></p>
  <p><label>Bild:<br/><input type='text' placeholder='finbild.jpg' name='image'/></label></p>
  <p><label>Bild:<br/><input type='text' placeholder='finbild2.jpg' name='image2'/></label></p>
  <p><label>Trailer:<br/><input type='text' placeholder='//www.youtube.com/embed/J4YV2_TcCoE?rel=0' name='trailer'/></label></p>
  <p><label>Pris:<br/><input type='text' placeholder='59.90' name='price'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
  <output>{$output}</output>
  </fieldset>
</form>";


}

public function addnew(){
	
// Get parameters 
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$content   = isset($_POST['content'])  ? strip_tags($_POST['content'])  : null;
$category    = isset($_POST['category'])   ? strip_tags($_POST['category']) : null;
$save   = isset($_POST['save'])  ? true : false;




// Check if form was submitted
$output = null;
if($save) {
  $sql = "
    INSERT INTO proj_News (title, content, category) VALUES
  (?, ?, ?);
  ";
  $params = array($title, $content, $category);
  $this->db->ExecuteQuery($sql, $params);
}
	
return "<form method=post>
  <fieldset>
  <legend>Lägg till innehåll</legend>
  <p><label>Titel:<br/><input type='text' required name='title'/></label></p>
  <p><label>Text:<br/><textarea name='content'></textarea></label></p>
  <p><label>Kategori:<br/><input type='text' placeholder='nyheter/erbjudande' name='category'/></label></p>
  <p class=buttons><input type='submit' name='save' value='Spara'/></p>
  <output>{$output}</output>
  </fieldset>
</form>";


}


}
