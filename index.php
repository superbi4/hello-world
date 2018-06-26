<!-- Letztes Update: 26. Juni 2018 08:56 -->

<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$msg = '';
//Don't run this unless we're handling a form submission
if (array_key_exists('email', $_POST)) {
    date_default_timezone_set('Etc/UTC');
    require '/usr/share/php/PHPMailer/src/Exception.php';
    require '/usr/share/php/PHPMailer/src/PHPMailer.php';
    require '/usr/share/php/PHPMailer/src/SMTP.php';
    //Create a new PHPMailer instance
    $mail = new PHPMailer;
    //Tell PHPMailer to use SMTP
    //Faster and safer than using mail()
    $mail->isSMTP();
    $mail->Host = 'mail.gmx.net';
    $mail->Port = 587;
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'user@example.com';                 // SMTP username
    $mail->Password = 'secret';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->CharSet = 'UTF-8';				  // Codierung erzwingen, um Umlaute korrekt anzuzeigen
    //Use a fixed address in your own domain as the from address
    //**DO NOT** use the submitter's address here as it will be forgery
    //and will cause your messages to fail SPF checks
    $mail->setFrom('vimailer@gmx.net');
    //Send the message to yourself, or whoever should receive contact for submissions
    $mail->addReplyTo('viciousintentions@gmail.com');
    $mail->addBCC('viciousintentions@gmail.com');
    //Put the submitter's address in a reply-to header
    //This will fail if the address provided is invalid,
    //in which case we should ignore the whole request
    if ($mail->addAddress($_POST['email'])) {
        $mail->Subject = 'Anmeldung Busfahrt SPH-Bandcontest // 13.10. Hamburg';
        //Keep it simple - don't use HTML
        $mail->isHTML(false);
        //Build a simple message body
        $mail->Body = <<<EOT
Hallo {$_POST['name']},

danke für deine Anmeldung zu unserem Konzert am 13.10. in Hamburg!
Du möchtest für {$_POST['anzahl']} Person/en Plätze dafür reservieren.

Wichtig: Um die Anmeldung abzuschließen, sende uns einfach eine leere E-Mail an die bereits eingestellte Antwort-Adresse. So können wir sicher sein, dass du auch wirklich die- oder derjenige bist, dem die angegebene E-Mail-Adresse gehört.

Mit besten Grüßen,
VICIOUS INTENTIONS


Solltest du diese Anmeldung nicht vorgenommen haben, kannst du diese Nachricht ignorieren.
EOT;
        //Send the message, check for errors
        if (!$mail->send()) {
            //The reason for failing to send will be in $mail->ErrorInfo
            //but you shouldn't display errors to users - process the error, log it on your server.
            $msg = $mail->ErrorInfo;
        } else {
            $msg = 'Anmeldung erhalten! Bitte prüfe dein E-Mail-Postfach, um sie abzuschließen.';
        }
    } else {
        $msg = 'Fehler: Die angegebene E-Mail-Adresse ist ungültig.';
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
  <link rel="stylesheet" type="text/css" href="w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="icon" href="/hello-world/images/favicon.ico" type="image/x-icon">
  <title>Vicious Intentions</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="Keywords" content="Band,Metal,Germany,Rostock">
  <meta name="Description" content="Melodic Death Metal Band aus Rostock">
  <style>
    html,body {line-height: 1.8;}

/* Overlay für das Hauptmenü */
    .overlay {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: rgb(0,0,0);
      background-color: rgba(0,0,0, 0.9);
      overflow-x: hidden;
      transition: 0.5s;
    }
    .overlay-content {
      position: relative;
      top: 15%;
      width: 100%;
      text-align: center;
      margin-top: 30px;
    }
    .overlay a {
      padding: 8px;
      text-decoration: none;
      font-size: 36px;
      color: #818181;
      display: block;
      transition: 0.3s;
    }
    .overlay a:hover, .overlay a:focus {
      color: #f1f1f1;
    }
    .overlay .closebtn {
      position: absolute;
      top: 15px;
      right: 40px;
      font-size: 40px;
    }

/* Greyscale-Effekt für Bilder */
    .greyimg {filter:grayscale(75%)}
    .greyimg:hover {filter:grayscale(25%)}

/* Text-Link-Design dunkel */
    .textlink_d a:link, .textlink_d a:visited {
      text-decoration: none;
      color: #a7a7a7;
    }
    .textlink_d a:hover {color: #f1f1f1;}
    .textlink_d a:active {
      text-decoration: none;
      color: #a7a7a7;
    }
/* Text-Link-Design hell */
    .textlink_h a:link, .textlink_h a:visited {
      text-decoration: none;
      color: #818181;
    }
    .textlink_h a:hover {color: #b3b3b3;}
    .textlink_h a:active {
      text-decoration: none;
      color: #818181;
    }

/* Breaking-Points */
    @media screen and (max-height: 450px) {
      .overlay a {font-size: 20px}
      .overlay .closebtn {
       font-size: 40px;
       top: 15px;
       right: 35px;
      }
    }
    @media screen and (max-width:450px) {
      #logo {width: 70%;}
      #social_fb_g,#social_fb_k,#social_yt_g,#social_yt_k,#social_bc_g,#social_bc_k {display: none!important}
      #navbar_g {display: none!important}
      #navbar_k {display: block!important}
      .mobile {display:block;width:100%!important}
    }
    @media screen and (min-width:451px) {
      #logo {width: 50%;}
      #social_fb_g,#social_fb_k,#social_yt_g,#social_yt_k,#social_bc_g,#social_bc_k {display: none!important}
      #navbar_g {display: none!important}
      #navbar_k {display: block!important}
      .mobile {display:block;width:100%!important}
    }
    @media screen and (max-width:680px) {
      #epcover {width: 100%!important}
    }
    @media screen and (min-width:681px) {
      #epcover {width: 50%!important}
    }
    @media screen and (min-width:801px) {
      #logo {width: 50%;}
      #social_fb_g,#social_fb_k,#social_yt_g,#social_yt_k,#social_bc_g,#social_bc_k {display: inline-block!important}
      #navbar_g {display: block!important}
      #navbar_k {display: none!important}
      .mobile {display:block;width:100%!important}
      #epcover {width: 50%!important}
    }
    @media screen and (min-width:950px) {
      .mobile {display:table-cell;width:49.9999%!important}
      #epcover {width: 50%!important}
    }

/* Zoom-Effekt für Bilder */
    .Image-zoom-effect {
      -webkit-transform:scale(1) rotate(.02deg) translateZ(0);
      transform:scale(1) rotate(.02deg) translateZ(0);
      -webkit-transition:-webkit-transform 1s ease-out;
      transition:-webkit-transform 1s ease-out;
      transition:transform 1s ease-out;
      transition:transform 1s ease-out,-webkit-transform 1s ease-out
    }
    .Image-zoom-effect:hover {
      -webkit-transform:scale(1.025) rotate(.02deg) translateZ(0);
      transform:scale(1.025) rotate(.02deg) translateZ(0);
      -webkit-transition:-webkit-transform .5s ease-in;
      transition:-webkit-transform .5s ease-in;
      transition:transform .5s ease-in;
      transition:transform .5s ease-in,-webkit-transform .5s ease-in
    }

/* Container für eingebettete Videos */
    .responsvid {
      position: relative;
      padding-bottom: 56.25%; /* Default for 1600x900 videos 16:9 ratio*/
      padding-top: 0px;
      height: 0;
      overflow: hidden;
    }
    .responsvid iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }
  </style>
</head>
<body>
<!-- Hero-Image -->
  <div class="w3-container" style="padding:0;" id="band">
    <img src="/hello-world/images/header_mixed.jpg" style="width: 100%;" id="header-img">
  </div>
<!-- Navbar -->
  <div class="w3-top">
    <div id="navbar_g" class="w3-bar w3-large">
      <a id="social_fb_g" href="https://www.facebook.com/ViciousIntentionsDE/" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-facebook-square fa-fw fa-lg"></i></a><a id="social_yt_g" href="https://www.youtube.com/channel/UCnhQoXXch3Da9G-2xcbDi4g" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-youtube fa-fw fa-lg"></i></a><a id="social_bc_g" href="https://viciousintentions.bandcamp.com/releases" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-bandcamp fa-fw fa-lg"></i></a><a id="menusymbol_g" href="javascript:void(0)" onclick="openNav()" class="w3-button w3-large w3-text-white w3-right"><i class="fa fa-bars fa-lg"></i></a>
    </div>
    <div id="navbar_k" class="w3-bar w3-large">
      <a id="social_fb_k" href="https://www.facebook.com/ViciousIntentionsDE/" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-facebook-square fa-fw fa-lg"></i></a><a id="social_yt_k" href="https://www.youtube.com/channel/UCnhQoXXch3Da9G-2xcbDi4g" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-youtube fa-fw fa-lg"></i></a><a id="social_bc_k" href="https://viciousintentions.bandcamp.com/releases" target="_blank" class="w3-button w3-large w3-text-white w3-left"><i class="fa fa-bandcamp fa-fw fa-lg"></i></a><a id="menusymbol_k" href="javascript:void(0)" onclick="openNav()" class="w3-button w3-large w3-text-white w3-right"><i class="fa fa-bars fa-lg"></i></a>
    </div>
  </div>
  <div id="myNav" class="overlay">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="overlay-content">
      <a href="#band" onclick="closeNav()">Band</a>
      <a href="#upcoming" onclick="closeNav()">Upcoming</a>
      <a href="#live" onclick="closeNav()">Live</a>
      <a href="#ep" onclick="closeNav()">EP</a>
    </div>
  </div>
<!-- Container (BAND) -->
  <div class="w3-container w3-padding-64 w3-center" id="geschichte">
    <img class="w3-animate-opacity" id="logo" src="/hello-world/images/VI_Lang.png">
    <p class="w3-center w3-large"><em>Melo-Death-Metal aus Rostock</em></p>
    <p class="w3-content w3-large">Seit 2018 sind wir <em>Vicious Intentions</em> &ndash; mit einer Geschichte, die zehn Jahre zurückreicht. SEPHIROTH und N3CRO waren schon damals dabei: Das Projekt kennen manche noch als <em>Vicious Intensity</em>. Unsere Songs haben dort ihren Ursprung. Aber wie die Band wandelten auch sie sich nach und nach. Musiker kamen und gingen &ndash; Schlagzeuger, Gitarristen, Sänger. Mit HRAFNIR, FELTED und IRA entstand 2017 schließlich eine Formation, die einen neuen Namen verdiente &ndash; einen, der zugleich an die Anfänge erinnert. Am 27.&nbsp;März 2018 haben wir erstmals die Bühne betreten. Stay tuned!</p>
  </div>
  <div class="w3-row">
    <div class="w3-container w3-col l1 m2 s3 w3-center w3-padding"></div>
    <div class="w3-container w3-col l2 m4 s6 w3-center w3-padding w3-margin-bottom">
      <ul class="w3-ul w3-center">
       <li class="w3-wide">HRAFNIR</li>
       <li class="w3-text-grey w3-small">(rhythm git)</li>
       <li><img class="w3-circle greyimg" src="/hello-world/images/hrafnir_k_r.jpg" style="width:100%"></li>
      </ul>
    </div>
    <div class="w3-container w3-col l2 m4 s6 w3-center w3-padding w3-margin-bottom">
      <ul class="w3-ul w3-center">
       <li class="w3-wide">SEPHIROTH</li>
       <li class="w3-text-grey w3-small">(lead git/voc)</li>
       <li><img class="w3-circle greyimg" src="/hello-world/images/sephiroth_k_r.jpg" style="width:100%"></li>
      </ul>
    </div>
    <div class="w3-container w3-col l2 m4 s6 w3-center w3-padding w3-margin-bottom">
      <ul class="w3-ul w3-center">
       <li class="w3-wide">FELTED</li>
       <li class="w3-text-grey w3-small">(voc/keys)</li>
       <li><img class="w3-circle greyimg" src="/hello-world/images/felted_k_r.jpg" style="width:100%"></li>
      </ul>
    </div>
    <div class="w3-container w3-col l2 m4 s6 w3-center w3-padding w3-margin-bottom">
      <ul class="w3-ul w3-center">
       <li class="w3-wide">N3CRO</li>
       <li class="w3-text-grey w3-small">(bass/voc)</li>
       <li><img class="w3-circle greyimg" src="/hello-world/images/n3cro_k_r.jpg" style="width:100%"></li>
      </ul>
    </div>
    <div class="w3-container w3-col l2 m4 s6 w3-center w3-padding w3-margin-bottom">
      <ul class="w3-ul w3-center">
       <li class="w3-wide">IRA</li>
       <li class="w3-text-grey w3-small">(drums)</li>
       <li><img class="w3-circle greyimg" src="/hello-world/images/ira_k_r.jpg" style="width:100%"></li>
      </ul>
    </div>
    <div class="w3-container w3-col l1 m2 s3 w3-center w3-padding"></div>
  </div>
<!-- Container (MUSIC) -->
  <div class="w3-container w3-section w3-padding-32" style="padding:0;">
    <div class="w3-cell-row">
  <!-- Container (UPCOMING) -->
      <div class="w3-cell w3-center w3-grey w3-padding-32 mobile" style="width:49.9999%" id="upcoming">
        <h1 class="w3-margin-bottom">UPCOMING</h1>
        <div class="w3-container w3-card w3-center" style="padding:0;width:80%;margin:auto;">
          <img src="/hello-world/images/2018-10-13_Regional-Finale.jpg" style="width:100%">
	  <div class="w3-container w3-white">
	    <h2>Indra Musikclub, Hamburg</h2>
	    <p class="w3-text-grey">Samstag, 13.10.2018<br>19:00 Uhr</p>
          </div>
	  <div id="newsinfos01" class="w3-container w3-white w3-hide">
	    <p class="textlink_h">Im Oktober sind wir beim Regional-Finale des <a href="https://www.sph-bandcontest.de/info" target="_blank">SPH-Bandcontests</a> in Hamburg dabei. Ort des Spektakels wird einer der traditionsreichen Clubs in der Großen Freiheit sein: der <a href="http://indraclub64.de" target="_blank">Indra Club 64</a>. Euch erwartet handgemacht Musik &ndash; von Pop, Metal bis Indy-Rock. Noch stehen nicht alle Teilnehmer fest, aber sicher ist: Es wird ein bunter Abend.</p>
	    <p class="textlink_h">Da der Weg nach Hamburg weit ist, hier die gute Nachricht: Wir sind dabei, einen Bus zu organisieren. Der bringt euch von Rostock zum Konzert und anschließend wieder zurück. Mehr Infos dazu findet ihr unter "Tickets".</p>
            <p>Wir sehen uns in Hamburg!</p>
          </div>
	  <div class="w3-container w3-white">
            <button id="morebtn" class="w3-button w3-border w3-dark-grey w3-margin-top w3-margin-bottom w3-margin-right" onclick="anzeigetoggleundchangebtn('newsinfos01','morebtn')"><i class="fa fa-caret-down"></i>  Infos</button>
	    <button class="w3-button w3-border w3-dark-grey w3-margin-top w3-margin-bottom" onclick="document.getElementById('tickets').style.display='block'">Tickets</button>
          </div>
        </div>
      </div>
  <!-- Container (LIVE) -->
      <div class="w3-cell w3-center w3-black w3-padding-32 mobile" style="width:49.9999%" id="live">
        <h1 class="w3-margin-bottom">LIVE</h1>
        <div class="w3-container w3-card w3-center w3-margin-bottom" style="padding:0;width:80%;margin:auto;">
          <div class="responsvid"><iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/V07aLCc9gr4?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
	  <div class="w3-container w3-black"><p class="w3-text-orange w3-large" style="text-align:left;margin:0;padding:0">Siren Singer</p><p class="w3-text-white w3-tiny" style="text-align:left;margin:0;padding:0;padding-bottom:5px">Alte Zuckerfabrik Rostock, 27. März 2018.</p></div>
        </div>
        <div class="w3-container w3-card w3-center w3-margin-top" style="padding:0;width:80%;margin:auto;">
          <div class="responsvid"><iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/LpnD2aPqhAU?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
	  <div class="w3-container w3-black"><p class="w3-text-orange w3-large" style="text-align:right;margin:0;padding:0">Lovesick in Hatred</p><p class="w3-text-white w3-tiny" style="text-align:right;margin:0;padding:0;padding-bottom:5px">Alte Zuckerfabrik Rostock, 27. März 2018.</p></div>
          <p class="textlink_d" style="margin-top:50px;margin-bottom:50px;">Feuertaufe: Am 27. März standen wir erstmals auf der Bühne &ndash; zusammen mit <a href="https://www.facebook.com/modicumofhope/" target="_blank">Modicum of Hope</a>, <a href="https://www.facebook.com/RadagostBand" target="_blank">Radagost</a> und <a href="https://www.facebook.com/negraschus" target="_blank">Maik Negraschus</a>. Danke für den geilen Abend!</p><p style="margin-bottom:20px;"><button id="morevids_btn" class="w3-button w3-border w3-padding-small" onclick="anzeigeundhidebtn('morevids','morevids_btn')">Mehr Videos</button></p>
        </div>
        <div class="w3-container w3-card w3-center w3-margin-bottom morevids w3-animate-opacity w3-hide" style="padding:0;width:80%;margin:auto;">
          <div class="responsvid"><iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/Um56wapTaak?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
	  <div class="w3-container w3-black"><p class="w3-text-orange w3-large" style="text-align:left;margin:0;padding:0">Point of No Return</p><p class="w3-text-white w3-tiny" style="text-align:left;margin:0;padding:0;padding-bottom:5px">Alte Zuckerfabrik Rostock, 27. März 2018.</p></div>
        </div>
        <div class="w3-container w3-card w3-center w3-margin-top morevids w3-animate-opacity w3-hide" style="padding:0;width:80%;margin:auto;">
          <div class="responsvid"><iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/3z-GNGt_snU?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>
	  <div class="w3-container w3-black"><p class="w3-text-orange w3-large" style="text-align:right;margin:0;padding:0">Blood of Innocence</p><p class="w3-text-white w3-tiny" style="text-align:right;margin:0;padding:0;padding-bottom:5px">Alte Zuckerfabrik Rostock, 27. März 2018.</p></div>
        </div>
      </div>
    </div>
  </div>
<!--Container (EP)-->
  <div class="w3-container w3-content textlink_h" style="margin-bottom:64px;margin-top:-16px" id="ep">
    <h1 class="w3-center">EP: <em>CONCEALED STRIKE</em></h1>
    <p class="w3-xlarge w3-text-red w3-center">work in progress <i class="fa fa-gavel"></i></p>
    <p class="w3-large w3-wide"><img id="epcover" class="Image-zoom-effect" src="/hello-world/images/coverk.jpg" style="width:33%;float:left;margin-right:20px;margin-bottom:20px;">1. Point Of No Return<br>2. About Our Fate<br>3. Blood Of Innocence<br>4. Siren Singer<br></p><p class="w3-large">Wir arbeiten derzeit an der EP <em>Concealed Strike</em> &ndash; unserer ersten handfesten Veröffentlichung. Drei Songs aus dem LIVE-Repertoire werden darauf zu hören sein, zusammen mit der Ballade <em>About Our Fate</em>. Allesamt stammen sie noch aus der <a href="#geschichte">Vorzeit der Band</a>: Seitdem hat sich ihr Gesicht jedoch deutlich verändert. Neu arrangiert und eingespielt bekommen sie einen neuen Sound.</p>
  </div>
<!-- Footer -->
  <div class="w3-container w3-margin-top w3-padding-32 w3-dark-grey">
    <div class="w3-row">
      <div class="w3-third w3-padding">
        <h3 class="w3-center">Kontakt</h3>
	<form method="post" style="width:80%;margin:auto">
	  <input class="w3-input w3-dark-grey" type="text" name="conname" id="conname" placeholder="Name" required></input>
	  <input class="w3-input w3-dark-grey" type="email" name="conemail" id="conemail" placeholder="E-Mail" required></input>
	  <textarea style="width:100%;height:45px;resize:vertical;" class="w3-input w3-dark-grey" wrap="hard" name="connachricht" id="connachricht" placeholder="Nachricht" required></textarea>
	<div class="w3-bar">
	    <input class="w3-button w3-bar-item w3-border w3-dark-grey w3-margin-top w3-margin-bottom" type="submit" name="consubmit" value="Absenden" disabled></input>
	</div>
	</form>
      </div>
      <div class="w3-third w3-padding w3-center">
        <h3>Social</h3>
	<div class="w3-container textlink_d">
	  <p style="margin-top:8px;"><a href="https://www.facebook.com/ViciousIntentionsDE/" target="_blank">Besuch&nbsp;uns&nbsp;auf<br><i class="fa fa-facebook-square"></i>&nbsp;Facebook</a><br><a href="https://www.youtube.com/channel/UCnhQoXXch3Da9G-2xcbDi4g" target="_blank">Schau&nbsp;uns&nbsp;auf<br><i class="fa fa-youtube"></i>&nbsp;YouTube</a><br><a href="https://viciousintentions.bandcamp.com/releases" target="_blank">Hör&nbsp;uns&nbsp;auf<br><i class="fa fa-bandcamp"></i>&nbsp;Bandcamp</a></p>
	</div>
      </div>
      <div class="w3-third w3-padding w3-center">
        <h3>Referenz</h3>
	<div class="w3-container textlink_d">
	  <p style="margin-top:8px;"><a href="">Datenschutz</a><br><a href="">Impressum</a></p>
        </div>
      </div>
    </div>
  </div>
  <div class="w3-container w3-center" style="color:#fff;background-color:#444444;">
    <a href="#" class="w3-button w3-large w3-circle" style="margin-top:16px;"><i class="fa fa-angle-up fa-lg"></i></a>
    <p style="color:#a7a7a7">&copy; Vicious Intentions 2018</p>
  </div>
<!-- Modal (Tickets SPH Hamburg) -->
  <div id="tickets" class="w3-modal w3-animate-opacity" style="background-color:rgba(0,0,0,0.8)">
    <div class="w3-modal-content">
      <div class="w3-container w3-padding-32" style="width:80%;margin:auto;">
        <span onclick="document.getElementById('tickets').style.display='none'" class="w3-button w3-display-topright w3-large">&times;</span>
        <h1 class="w3-center">Tickets</h1>
	<p class="w3-center w3-text-grey">Indra Musikclub,&nbsp;Hamburg. Samstag,&nbsp;13.10.2018. 19:00&nbsp;Uhr.</p>
        <p class="w3-large" style="margin-top:80px;">Wir bieten euch die Möglichkeit, per Reisebus nach Hamburg und anschließend wieder zurück nach Rostock zu fahren. Das spart die Übernachtung und ist für alle eine entspannte Art, zum Konzert zu kommen.</p>
	<p class="w3-large">Sobald uns 15&nbsp;Anmeldungen erreicht haben, wird der Bus bestellt: Euch kostet die Busfahrt (inklusive des Konzert-Tickets) <span class="w3-text-red">maximal 50&nbsp;€.</span> Wenn mehr als die nötigen 15&nbsp;Anmeldungen eingehen, wird es natürlich noch günstiger.</p>
	<p class="w3-large" style="margin-bottom:40px;">Seid ihr dabei? Dann füllt einfach das Anmeldeformular aus. Wir halten euch dann auf dem Laufenden.</p>
        <form class="w3-container" method="post">
          <h3>Anmeldung</h3>
	  <input class="w3-input" type="text" name="name" id="name" placeholder="Name" required>
	  <input class="w3-input" type="email" name="email" id="email" placeholder="E-Mail" required>
	  <input class="w3-input" type="number" name="anzahl" id="anzahl" placeholder="Anzahl der Personen" min="1" required>
	  <input class="w3-input" type="text" name="notes" id="notes" placeholder="Anmerkungen (optional)">
	  <div class="w3-bar">
	    <input class="w3-button w3-bar-item w3-border w3-dark-grey w3-margin-top w3-margin-bottom" type="submit" name="submit" value="Absenden" disabled>
	  </div>
	  <hr>
	  <p class="w3-tiny">Datenschutzhinweis: Die hier erhobenen personengebundenen Daten nutzen wir ausschließlich dafür, mit euch Kontakt aufzunehmen. Sie werden nicht an Dritte weitergegeben und nach dem zweckmäßigen Gebrauch wieder gelöscht.</p>
	  <hr>
	</form>
        <p class="w3-large textlink_h">Solltet ihr keinen Bus brauchen, könnt ihr die Tickets natürlich auch direkt auf der Website vom <a href="https://www.sph-bandcontest.de/tickets" target="_blank">SPH-Bandcontest</a> bestellen. Gebt dort im Feld "Bandname" dann bitte "Vicious Intentions" an, um uns zu unterstützen.</p>
	<p class="w3-large" style="margin-bottom:80px;">Vielen Dank!</p>
	<span onclick="document.getElementById('tickets').style.display='none'" class="w3-button w3-display-bottommiddle w3-large">&times;</span>
      </div>
    </div>
  </div>
<!-- Modal (Bestätigung Kontaktformular Tickets SPH Hamburg) -->
  <?php if (!empty($msg)) {
        echo "<div id='ticketsconfirm' class='w3-modal w3-animate-opacity' style='background-color:rgba(0,0,0,0.8);display:block;'>";
        echo "<div class='w3-modal-content'>";
        echo "<div class='w3-container w3-padding-32' style='width:80%;margin:auto;'>";
        echo "<p class='w3-large w3-center' style='margin-top:80px;margin-bottom:80px;'>$msg</p>";
        echo "<span onclick='closeticketsconfirm()' class='w3-button w3-display-bottommiddle w3-large'>&times;</span>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
     }
  ?>

<script>
// horizontale Menüleiste auf und unter dem Hero-Image unterschiedlich anzeigen
window.onscroll = function() {changenavbar()};
function changenavbar() {
    var navg = document.getElementById("navbar_g");
    var menusyidk = document.getElementById("menusymbol_k");
    var menusyidg = document.getElementById("menusymbol_g");
    var socialfbk = document.getElementById("social_fb_k");
    var socialfbg = document.getElementById("social_fb_g");
    var socialytk = document.getElementById("social_yt_k");
    var socialytg = document.getElementById("social_yt_g");
    var socialbck = document.getElementById("social_bc_k");
    var socialbcg = document.getElementById("social_bc_g");
    var header = document.getElementById("header-img");
    var headergr = header.height;
    if (document.documentElement.scrollTop > headergr || document.body.scrollTop > headergr) {
        navg.className = "w3-bar w3-large w3-white w3-opacity";
        menusyidk.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-right";
        menusyidg.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-right";
        socialfbk.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
        socialfbg.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
        socialytk.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
        socialytg.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
        socialbck.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
	socialbcg.className = "w3-button w3-large w3-text-black w3-white w3-opacity w3-left";
    } else {
        navg.className = "w3-bar w3-large";
        menusyidk.className = "w3-button w3-large w3-text-white w3-right";
        menusyidg.className = "w3-button w3-large w3-text-white w3-right";
        socialfbk.className = "w3-button w3-large w3-text-white w3-left";
        socialfbg.className = "w3-button w3-large w3-text-white w3-left";
        socialytk.className = "w3-button w3-large w3-text-white w3-left";
        socialytg.className = "w3-button w3-large w3-text-white w3-left";
	socialbck.className = "w3-button w3-large w3-text-white w3-left";
	socialbcg.className = "w3-button w3-large w3-text-white w3-left";
    }
}
// Hauptmenü (Overlay) anzeigen und schließen
function openNav() {
    document.getElementById("myNav").style.width = "100%";
}
function closeNav() {
    document.getElementById("myNav").style.width = "0%";
}
// Container verbergen und anzeigen
function anzeigetoggle(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
// Container verbergen und anzeigen + Button je nach Zustand verändern (News in UPCOMING)
function anzeigetoggleundchangebtn(id,btn) {
    var y = document.getElementById(btn);
    var z = document.getElementById(id);
    if (z.className.indexOf("w3-show") == -1) {
        z.className += " w3-show";
        y.innerHTML = "<i class='fa fa-caret-up'></i>  Infos";
    } else {
        z.className = z.className.replace(" w3-show", "");
        y.innerHTML = "<i class='fa fa-caret-down'></i>  Infos";
    }
}
// Container anzeigen + Button verbergen (MEHR VIDEOS-Button in LIVE)
function anzeigeundhidebtn(cl,btn) {
    var y = document.getElementById(btn);
    var z = document.getElementsByClassName(cl);
    for (i = 0; i < z.length; i++) {
       z[i].className += " w3-show";
    }
    y.className += " w3-hide";
}
// Modal der Ticketbestätigung schließen
function closeticketsconfirm() {
    var x = document.getElementById("ticketsconfirm");
    x.style.display = "none";
}
</script>
</body>
</html>
