<html>

	<head>
		<title>Mathe</title>
		<meta charset="UTF-8"> 
		<link rel="stylesheet" href="css/style.css">
		
		<link rel="apple-touch-icon" sizes="57x57" href="icon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="icon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="icon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="icon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="icon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="icon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="icon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="icon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="icon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="icon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="icon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="icon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="icon/favicon-16x16.png">
		<link rel="manifest" href="icon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		
		<meta property="og:image" content="img/mathelogo.png" />

	</head>
	
	<?php
		
		//$base = explode('index',$_SERVER['REQUEST_URI']);
		//$base = 'http://'.$_SERVER['HTTP_HOST'].$base[0];
		//$uri = $_SERVER['PHP_SELF'];
		
		include("translations/gr.php");
		
		$file = file('items/cases.csv');
		foreach ($file as $line)				$data[] = str_getcsv($line);
		for ($q = 0; $q < count($data); $q++) 	$data[$q] = explode(";", $data[$q][0]);
		array_splice($data,0,1);
			
		$fh = fopen('descriptions.csv','r');
		while ($line = fgets($fh)) 				$descs[] = str_replace(array("\n","\r"), '', $line);
		for ($i = 0; $i < count($descs); $i++) 	$descs[$i] = explode(";", $descs[$i]);
		fclose($fh);
		
		if(is_numeric($_GET["i"])&&is_numeric($_GET["r"])&&is_numeric($_GET["t"])&&is_numeric($_GET["c"])) {
			$i = $_GET["i"];
			$t = $_GET["t"];
			$r = $_GET["r"];
			$c = $_GET["c"];
			
			$used = $_COOKIE["cases"];
			$k = rand(0, count($data)-1);
			while(strpos($used, "-".$k."-")!==false)	$k = rand(0, count($data)-1);
			setcookie("cases", $used." -".$k."-", 0, "/");
		}
		else if(!isset($_GET["i"])&&!isset($_GET["r"])&&!isset($_GET["t"])&&!isset($_GET["c"])) {
			$i = 0;
			$t = -1;
			$r = 50;
			$c = -1;
			
			$k = rand(0, count($data)-1);
			setcookie("cases", "-".$k."-", 0, "/");
		}
		else {
			header("Refresh:5; url='http://research.playcompass.com/mathe'");
			die("Hacking attempt... redirecting to root.");
		}

	?>

	<body onLoad="show_progress()" style="margin:10 0 10 0">

		<div class="content">
		
			<!-- Left Section -->
			<div class="left">
            
				<a href="http://research.playcompass.com/mathe" style="color:black;"> <img src="img/mathelogo.png" alt="Mathe the game" height="128" width="241"> </a>

				<div id="hoverButtonMenu">

					<div class="itemB"><a href="#" class="imgB1 <?php if(!strcmp($data[$k][3], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[3][0];?>','<?php echo $descs[3][1];?>')" 
					onclick="show_window('<?php echo $data[$k][3];?>', 'Αναζήτηση στο Web', 1200, 600)">Αναζήτηση στο Διαδίκτυο</a></div>
                    
					<div><a href="#" class="imgB2 <?php if(!strcmp($data[$k][4], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[4][0];?>','<?php echo $descs[4][1];?>')" 
					onclick="show_window('<?php echo $data[$k][4];?>', 'Αναζήτηση στο Web', 1200, 600)">Αντίστροφη Αναζήτηση Εικόνας</a></div>
                    
                    <div class="itemB"><a href="#" class="imgB3 <?php if(!strcmp($data[$k][2], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[2][0];?>','<?php echo $descs[2][1];?>')" 
					onclick="show_popup(2)">Ανάλυση Εικόνας</a></div>
                    
                    <div><a href="#" class="imgB4 <?php if(!strcmp($data[$k][1], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[1][0];?>','<?php echo $descs[1][1];?>')" 
					onclick="show_popup(1)">Έλεγχος Ισχυρισμού</a></div>	
                   
				</div>
				
				<div class="info">
					<h3 class="info-title"></h3>
					<p class="info-body"></p>
				</div>
				
			</div>
			
			<!-- Main Section -->
			<div class="center">
				<iframe id='news' width='100%' height='100%' src='items/<?php echo $data[$k][0];?>'></iframe>
			</div>		

			<!-- Bottom Section -->
			<div class="bottom">
                <div id="bottomBox">
					<div class="iOne">Επίπεδο<p><?php echo floor(1+$i/4);?>/3</p></div>
					<div class="iTwo">Άσκηση<p><?php echo ($i%4)+1;?>/4</p></div>
					<div class="iThree">
						<div><a class="imgTrue" href="#" onclick="answer(1)">Αληθινή</a></div>
						<div><a class="imgFalse" href="#" onclick="answer(0)">Φεύτικη</a></div>
					</div>
				  <div class="iFour">Χρόνος<p id="time"> --:--</p></div>
				  <div class="iFive" id="score">Βαθμός Επιτυχίας<p><span id="r"><?php echo $r;?></span>%</p></div>
				</div>
			</div>
			
			<!-- Popup Section -->
			<div class="popup" style="overflow: auto!important; -webkit-overflow-scrolling: touch!important;">
				<p><a id="new_tab" href="#" target="_blank">Άνοιγμα του εργαλείου σε νέα καρτέλα</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onClick="hide_popup()">Κλείσιμο</a></p>
				<iframe class='popup-1' width='100%' height='100%' name='<?php echo $data[$k][1];?>' src=''></iframe>
				<iframe class='popup-2' width='100%' height='100%' name='<?php echo $data[$k][2];?>' src=''></iframe>
				<img class="spinner" src="img/spinner.gif" width="100" height="100"/>
			</div>
			
			<!-- Start Section -->
			<div id="start" class="message-out">
				<div class="message-in">
					<h3>Καλώς ορίσατε στο</h3>
					<p><img src="img/mathelogo.png"/></p>
					<p>Μήπως η υπερβολική πίστη μας ότι στο Διαδίκτυο βρίσκουμε «κρυμμένες αλήθειες»<br> και ποιοτικές πληροφορίες μερικές φορές διαστρεβλώνει<br> την ίδια την πραγματικότητά μας;<br><br>
					Με αυτό το παιχνίδι θα έχετε την ευκαιρία να το διαπιστώσετε!<br><br>
					Θα δείτε μια σειρά από ειδήσεις ήδη δημοσιευμένες στο ελληνικό Διαδίκτυο<br>
					και θα πρέπει να απαντήσετε αν είναι αληθινές ή ψεύτικες!<br><br>
					Επειδή όμως συνήθως δεν αρκεί να διαβάζετε απλώς τις ειδήσεις θα μπορέσετε να χρησιμοποιήσετε<br>
					και διάφορα εργαλεία τα οποία μπορεί να σας βοηθήσουν να πάρετε τη σωστή απόφαση.<br><br>
					Α, και τα εργαλεία κοστίζουν… γιατί κάπως πρέπει να χάνετε πόντους!
					</p>
					<h4><a href="#" onClick="hide_progress('start')"><?php echo $tr_start; ?></a></h4>
				</div>
			</div>
			
			<!-- End Section -->
			<div id="end" class="message-out">
				<div class="message-in">
					<h3 id="end-title"></h3>
					<p id="end-body"></p>
					<p><img id="end-image" src="img/mathelogo.png" height="300"/></p>
					<h4><a href="#" onClick="hide_progress('end')">Θέλω να παίξω ξανά!</a></h4>
				</div>
			</div>
			
			<!-- Script Section -->
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script>
			
				$('iframe').on("load", function() {
					$('iframe').contents().find('a').click(function(event) {
					event.preventDefault();
					alert("Δεν επιτρέπεται να το κάνεις αυτό!");
					}); 
				});

				i = <?php echo $i; ?>;
				gnd = <?php echo $data[$k][6]; ?>;
				c = <?php echo $c; ?>;
				r = <?php echo $r; ?>;
				t = <?php echo $t; ?>;
				
				calc_time();
				setInterval(calc_time, 1000);
				function calc_time() {
					if(t > 0) {
						now = new Date().getTime();
						distance = now-t;
						minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
						seconds = Math.floor((distance % (1000 * 60)) / 1000);
						document.getElementById("time").innerHTML = (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
					}
				}
				
				function show_window(url, title, w, h) {
					if(r <= 10) {
						alert("Αυτή η βοήθεια κοστίζει 10 μονάδες επιτυχίας. Δεν έχει τις απαιτούμενες μονάδες για να την χρησιμοποιήσεις.");
					}
					else if(confirm("Αυτή η βοήθεια θα σου κοστήσει 10 μονάδες επιτυχίας. Θέλεις να συνεχίσεις;")) {
						r = r - 10;
						document.getElementById("r").innerHTML = r;
						
						var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
						var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;
						var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
						var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
						var systemZoom = width / window.screen.availWidth;
						var left = (width - w) / 2 / systemZoom + dualScreenLeft
						var top = (height - h) / 2 / systemZoom + dualScreenTop
						var newWindow = window.open(url, title, 'resizable=no, scrollbars=no, status=no, titlebar=no, toolbar=no, width=' + w / systemZoom + ', height=' + h / systemZoom + ', top=' + top + ', left=' + left);
						if (window.focus) newWindow.focus();
					} 
				}
				
				function show_popup(id) {
					
					if(id==1) 	dec = 15;
					else 		dec = 10;
					
					if(r <= dec) {
						alert("Αυτή η βοήθεια κοστίζει "+dec+" μονάδες επιτυχίας. Δεν έχει τις απαιτούμενες μονάδες για να την χρησιμοποιήσεις.");
					}
					else if (confirm("Αυτή η βοήθεια θα σου κοστήσει "+dec+" μονάδες επιτυχίας. Θέλεις να συνεχίσεις;")) {
						r = r - dec;
						document.getElementById("r").innerHTML = r;
						
						var iframe;
						if(id==1) iframe = document.getElementsByClassName("popup-1")[0];
						if(id==2) iframe = document.getElementsByClassName("popup-2")[0];
						document.getElementById("new_tab").href = iframe.name;
						iframe.src = iframe.name;
						iframe.style.display = "block";
						document.getElementsByClassName("popup")[0].style.display = "block";
						document.getElementsByClassName("spinner")[0].style.display = "block";
						setTimeout(function() { document.getElementsByClassName("spinner")[0].style.display = "none"; }, 3000);
					}
				}
				function hide_popup(id) {
					document.getElementsByClassName("popup-1")[0].style.display = "none";
					document.getElementsByClassName("popup-2")[0].style.display = "none";
					document.getElementsByClassName("popup")[0].style.display = "none";
					document.getElementsByClassName("spinner")[0].style.display = "none";
				}
				
				function show_progress() {
					if(i == 0) {
						document.getElementById("start").style.display = "block";
						document.getElementsByClassName("info-title")[0].innerHTML = "Καλώς ορίσατε!";
						document.getElementsByClassName("info-body")[0].innerHTML = "Για να δούμε κατά πόσο μπορείτε να εντοπίζετε ψευδείς ειδήσεις... Θα παίξουμε ένα παιχνιδάκι για να μάθουμε τα μυστικά του διαδικτύου!";
					}
					else if(i > 0 && c == 1) {
						audio = new Audio('sfx/correct.wav');
						audio.play();
						document.getElementsByClassName("info-title")[0].innerHTML = "Μπράβο!";
						document.getElementsByClassName("info-body")[0].innerHTML = "Σωστή απάντηση. Μήπως όμως το βρήκες τυχαία;";
					}
					else if(i > 0 && c == 0) {
						audio = new Audio('sfx/wrong.wav');
						audio.play();
						document.getElementsByClassName("info-title")[0].innerHTML = "Λάθος απάντηση...";
						document.getElementsByClassName("info-body")[0].innerHTML = "Πρέπει να είσαι πιο προσεκτικός...";
					}
				}
				function hide_progress(id) {
					if(id == 'start')	t = now = new Date().getTime();
					if(id == 'end')		window.location.href = "http://research.playcompass.com/mathe"
					document.getElementById(id).style.display = "none";
				}
				
				function answer(ans) {
					// score calculation
					if(ans == gnd) {
						r = r + 10;
						if(r > 100)	r = 100;
						c = 1;
					}
					else {
						r = r - 15;
						if(r < 0)	r = 0;
						c = 0;
					}
					
					// move on or finish
					if(i == 11 || r == 0) {
						document.getElementById("end").style.display = "block";
						if(r > 75)	{
							document.getElementById("end-title").innerHTML = "Αρίστευσες!";
							document.getElementById("end-body").innerHTML = "Συγκέντρωσες <b>" + r + "%</b> βαθμό επιτυχίας σε <b>" + minutes + "</b> λεπτά και <b>" + seconds + "</b> δευτερόλεπτα.<br><br> Τελικά τα ξέρεις όλα...<br> τόσο που θα μπορούσες να δουλέψεις και στην ΕΥΠ.";
							document.getElementById("end-image").src = "img/investigator.png";
						}
						else if(r > 55) {
							document.getElementById("end-title").innerHTML = "Μπράβο!";
							document.getElementById("end-body").innerHTML = "Συγκέντρωσες <b>" + r + "%</b> βαθμό επιτυχίας σε <b>" + minutes + "</b> λεπτά και <b>" + seconds + "</b> δευτερόλεπτα.<br><br> Σχεδόν κανείς δεν μπορεί να σε κοροϊδέψει στο καφενείο,<br> εσύ τους λες τις αληθινές ειδήσεις!";
							document.getElementById("end-image").src = "img/arrogant.png";
						}
						else if(r > 30) {
							document.getElementById("end-title").innerHTML = "Κάτι γίνεται...";
							document.getElementById("end-body").innerHTML = "Συγκέντρωσες <b>" + r + "%</b> βαθμό επιτυχίας σε <b>" + minutes + "</b> λεπτά και <b>" + seconds + "</b> δευτερόλεπτα.<br><br> Καλή η προσπάθεια σου, αλλά πρόσεχε! <br><br> Να φυλάγεσαι όταν ψεκάσουν!";
							document.getElementById("end-image").src = "img/spraying.png";
						}
						else if(r > 0) {
							document.getElementById("end-title").innerHTML = "Την επόμενη φορά τα πας ίσως καλύτερα...";
							document.getElementById("end-body").innerHTML = "Συγκέντρωσες <b>" + r + "%</b> βαθμό επιτυχίας σε <b>" + minutes + "</b> λεπτά και <b>" + seconds + "</b> δευτερόλεπτα.<br><br> Ξεψαχνίζεις τόσο τις ειδήσεις που είσαι έτοιμος να στείλεις λεφτά<br> για να στηρίξεις το αντιεμβολιαστικό κίνημα!";
							document.getElementById("end-image").src = "img/anti-vaccination.png";
						}
						else {
							document.getElementById("end-title").innerHTML = "Δυστυχώς έχασες!";
							document.getElementById("end-body").innerHTML = "H φήμη σου έπιασε πάτο...<br><br> Νομίζουμε ότι ήρθε η ώρα να μάθεις την αλήθεια!<br><br> Η Γη ΔΕΝ είναι επίπεδη!";
							document.getElementById("end-image").src = "img/earth.png";
						}
						t = -1;
					}
					else {
						window.location.href = "http://research.playcompass.com/mathe?i=" + (i+1) + "&r=" + r + "&t=" + t + "&c=" + c;
					}
				}
				
				function show_info(title, body) {
					document.getElementsByClassName("info-title")[0].innerHTML = title;
					document.getElementsByClassName("info-body")[0].innerHTML = body;
				}
				
				
				
			</script>
		
		</div>

		
	</body>

</html>