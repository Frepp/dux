<?php 
/**
 * This is a Dux pagecontroller.
 *
 */
// Include the essential config-file which also creates the $dux variable with its defaults.
include(__DIR__.'/config.php'); 
 
 
// Do it and store it all in variables in the Dux container.
$dux['title'] = "Om mig";
 
$dux['main'] = <<<EOD
  
  <figure class="left">
  	<img src="img/fredrik.png" alt="Bild på Fredrik">
  	<figcaption>
  		<p>Här är jag!</p>
  	</figcaption>
  </figure>
  <div id="content">
  <h1>Om mig</h1>
  <p>Jag heter Fredrik Peterson och är nu inne på den andra kursen av fyra i kurspaketet: Databaser, HTML, CSS, JavaScript och PHP. Under den första kursen vars resultat ni kan se <a href=”http://www.student.bth.se/~frpe13/htmlphp/kmom06/me.php”>här</a> lärde jag mig väldigt mycket och har nu kommit en liten bit på vägen mot att kunna det här med webbprogrammering. Innan jag började att läsa de här kurserna har jag enbart nosat på det här med programmering men hittills har det gott helt okej och det är väldigt roligt att lära sig så mycket nytt.</p>
  
<p>Vem är då jag? Jo den orienteringsintresserade östgöten som flyttat till Norge för att jobba med att hjälpa norrmännen att hitta de låga priserna. Vad jag hittills kan rapportera från det arbetet så måste jag tyvärr medge att inte ens norrmännen tror att de låga priserna befinner sig nära golvet, som sägen säger. För att återvända till mina intressen så är mitt stora intresse som redan nämnt orientering. Nu förtiden kan jag väl tyvärr inte påstå att någon elitsatsning längre bedrivs men intresset är fortfarande på topp och roligt är det i vilket fall. Dock är jag inte enbart intresserad av att leta kontroller utan är också rent allmänt väldigt sportintresserad och spelar till exempel gärna fotboll och åker längdskidor. Utöver dessa fysiska intressen är jag också väldigt teknikintresserad, både vad gäller roliga prylar och datorer i allmänhet.</p>
<p>Genom att läsa den här kursen hoppas jag på att få byggare vidare på den grund av PHP-kunnande som jag fick genom att läsa den första kursen. Vad detta kunnande så småningom ska resultera i låter jag vara osagt men något litet projekt får jag väl se till att ta itu med för att få användning av de kommande kunskaperna.
 </p>
  </div>
EOD;
 

 
 
// Finally, leave it all to the rendering phase of Dux.
include(DUX_THEME_PATH);