<html>

	<head>
		<title>Mathe</title>
		<meta charset="UTF-8"> 
		<link rel="stylesheet" href="css/style.css">
		<link rel="icon" type="image/png" sizes="32x32" href="images/icon.ico">
	</head>
	
	<?php
		$file = file('items/cases.csv');
		foreach ($file as $line)				$data[] = str_getcsv($line);
		for ($i = 0; $i < count($data); $i++) 	$data[$i] = explode(";", $data[$i][0]);
		array_splice($data,0,1);
		
		$fh = fopen('descriptions.csv','r');
		while ($line = fgets($fh)) 				$descs[] = str_replace(array("\n","\r"), '', $line);
		fclose($fh);
		for ($i = 0; $i < count($descs); $i++) 	$descs[$i] = explode(";", $descs[$i]);

		$base = explode('index',$_SERVER['REQUEST_URI']);
		$base = 'http://'.$_SERVER['HTTP_HOST'].$base[0];
		$uri = $_SERVER['PHP_SELF'];

		if(is_numeric($_GET["i"])&&is_numeric($_GET["ans"])&&is_numeric($_GET["gnd"])&&is_numeric($_GET["r"])&&is_numeric($_GET["t"])) {
			$i = $_GET["i"];
			$t = $_GET["t"];
			$gnd = $_GET["gnd"];
			$ans = $_GET["ans"];
			$r = $_GET["ans"] == $_GET["gnd"] ? $_GET["r"]+5 : $_GET["r"]-10;
			if($r < 0) $r = 0;
			if($r > 100) $r = 100;
		}
		else if(!isset($_GET["i"])&&!isset($_GET["ans"])&&!isset($_GET["gnd"])&&!isset($_GET["r"])&&!isset($_GET["t"])) {
			$i = 0;
			$t = time()*1000;
			$gnd = 0;
			$ans = 0;
			$r = 50;
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
            
				<a href="<?php echo $base;?>" style="color:black;"> <img src="img/mathelogo.png" alt="Mathe the game" height="128" width="241"> </a>

				<div id="hoverButtonMenu">

					<div class="itemB"><a href="#" class="imgB1 <?php if(!strcmp($data[$i][3], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[3][0];?>','<?php echo $descs[3][1];?>')" 
					onclick="show_window('<?php echo $data[$i][3];?>', 'Αναζήτηση στο Web', 1200, 600)">Αναζήτηση στο Διαδίκτυο</a></div>
                    
					<div><a href="#" class="imgB2 <?php if(!strcmp($data[$i][4], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[4][0];?>','<?php echo $descs[4][1];?>')" 
					onclick="show_window('<?php echo $data[$i][4];?>', 'Αναζήτηση στο Web', 1200, 600)">Αντίστροφη Αναζήτηση Εικόνας</a></div>
                    
                    <div class="itemB"><a href="#" class="imgB3 <?php if(!strcmp($data[$i][2], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[2][0];?>','<?php echo $descs[2][1];?>')" 
					onclick="show_popup(2)">Ανάλυση Εικόνας</a></div>
                    
                    <div><a href="#" class="imgB4 <?php if(!strcmp($data[$i][1], '#')) echo 'disabled';?>" onMouseOver="show_info('<?php echo $descs[1][0];?>','<?php echo $descs[1][1];?>')" 
					onclick="show_popup(1)">Έλεγχος Ισχυρισμού</a></div>	
                   
				</div>
				
				<div class="info">
					<h3 class="info-title"></h3>
					<p class="info-body"></p>
				</div>
				
			</div>
			
			<!-- Main Section -->
			<div class="center">
				<iframe style="" width='100%' height='100%' src='items/<?php echo $data[$i][0];?>'></iframe>
			</div>		

			<!-- Bottom Section -->
			<div class="bottom">
                <div id="bottomBox">
				  <div class="iOne">Επίπεδο: <p><?php echo floor(1+$i/4);?>/4</p></div>
				  <div class="iTwo">Άσκηση: <p> <?php echo ($i%4)+1;?>/4</p></div>
				  <div class="iThree">
						<div><a class="imgTrue" href="<?php echo $uri.'?i='.($i+1).'&r='.$r.'&t='.$t.'&ans=1&gnd='.$data[$i][6];?>">Αληθινή</a></div>
						<div><a class="imgFalse" href="<?php echo $uri.'?i='.($i+1).'&r='.$r.'&t='.$t.'&ans=0&gnd='.$data[$i][6];?>">Φεύτικη</a></div>
				  </div>
				  <div class="iFour">Χρόνος:<p id="time"> --:--</p></div>
				  <div class="iFive" id="score">Βαθμός Επιτυχίας: <p><?php echo $r;?>%</p></div>
				</div>
			</div>
			
			<!-- Popup Section -->
			<div class="popup">
				<p><a id="new_tab" href="#" target="_blank">Άνοιγμα του εργαλείου σε νέα καρτέλα</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onClick="hide_popup()">Κλείσιμο</a></p>
				<iframe class='popup-1' width='100%' height='100%' name='<?php echo $data[$i][1];?>' src=''></iframe>
				<iframe class='popup-2' width='100%' height='100%' name='<?php echo $data[$i][2];?>' src=''></iframe>
				<img class="spinner" src="img/spinner.gif" width="100" height="100"/>
			</div>
			
			<!-- Progress Section -->
			<div id="start" class="message-out">
				<div class="message-in">
					<h3">Καλώς ορίσατε στο Mathe!</h3>
					<p><img src="img/mathelogo.png"/></p>
					<p>To Mathe είναι ένα παιχνίδι... τέλειο.<br>To Mathe είναι ένα παιχνίδι... άψογο.<br> Ο Λάζαρος ο Βρύσης... δεν παίζεται.</p>
					<p><a href="#" onClick="hide_progress('start')">ΟΚ</a></p>
				</div>
			</div>
			
			<div id="end" class="message-out">
				<div class="message-in">
					<h3 id="end-title">Καλώς ορίσατε στο Mathe!</h3>
					<p id="end-body">To Mathe είναι ένα παιχνίδι... τέλειο.<br>To Mathe είναι ένα παιχνίδι... άψογο.<br> Ο Λάζαρος ο Βρύσης... άντε να τον βρεις.</p>
					<p><a href="#" onClick="hide_progress('end')">Θέλω να παίξω ξανά!</a></p>
				</div>
			</div>
			
			<!-- Script Section -->
			<script>
				i = <?php echo $i; ?>;
				gnd = <?php echo $gnd; ?>;
				ans = <?php echo $ans; ?>;
				r = <?php echo $r; ?>;
				
				function show_window(url, title, w, h) {
					if(r <= 10) {
						alert("Αυτή η βοήθεια κοστίζει 10 μονάδες επιτυχίας. Δεν έχει τις απαιτούμενες μονάδες για να την χρησιμοποιήσεις.");
					}
					else if(confirm("Αυτή η βοήθεια θα σου κοστήσει 10 μονάδες επιτυχίας. Θέλεις να συνεχίσεις;")) {
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
					if(r <= 5) {
						alert("Αυτή η βοήθεια κοστίζει 5 μονάδες επιτυχίας. Δεν έχει τις απαιτούμενες μονάδες για να την χρησιμοποιήσεις.");
					}
					else if (confirm("Αυτή η βοήθεια θα σου κοστήσει 5 μονάδες επιτυχίας. Θέλεις να συνεχίσεις;")) {
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
					else if(i == 16 || r == 0) {
						document.getElementById("end").style.display = "block";
						if(r > 70)	{
							document.getElementById("end-title").innerHTML = "Αρίστευσες!";
							document.getElementById("end-body").innerHTML = "Φαίνεσαι παλιά καραβάνα στο διαδίκτυο ή σου έκανε μαθήματα ο Βρύσης.";
						}
						else if(r > 50) {
							document.getElementById("end-title").innerHTML = "Έχει καλώς.";
							document.getElementById("end-body").innerHTML = "Τα πήγες αρκετά καλά. Μπορείς όμως και καλύτερα...";
						}
						else if(r > 0) {
							document.getElementById("end-title").innerHTML = "Πόσιμπολ...";
							document.getElementById("end-body").innerHTML = "Μήπως σε βοήθησε η θεά τύχη; Την επόμενη φορά πρέπει να είσαι περισσότερο υπομονετικός.";
						}
						else {
							document.getElementById("end-title").innerHTML = "Δυστυχώς έχασες...";
							document.getElementById("end-body").innerHTML = "Πρέπει να είσαι πιο προσεκτικός την επόμενη φορά";
						}
					}
					else if(i > 0 && gnd==ans) {
						document.getElementsByClassName("info-title")[0].innerHTML = "Μπράβο!";
						document.getElementsByClassName("info-body")[0].innerHTML = "Σωστή απάντηση. Μήπως όμως το βρήκες τυχαία;";
					}
					else if(i > 0 && gnd!=ans) {
						document.getElementsByClassName("info-title")[0].innerHTML = "Λάθος απάντηση...";
						document.getElementsByClassName("info-body")[0].innerHTML = "Πρέπει να είσαι πιο προσεκτικός...";
					}
				}
				function hide_progress(id) {
					if(id == 'end')	window.location.href = "http://research.playcompass.com/mathe"
					document.getElementById(id).style.display = "none";
				}
				
				function show_info(title, body) {
					document.getElementsByClassName("info-title")[0].innerHTML = title;
					document.getElementsByClassName("info-body")[0].innerHTML = body;
				}
				
				var x = setInterval(function() {
					var start = '<?php echo $t; ?>';
				    var now = new Date().getTime();
				    var distance = now-start;
				    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
				    document.getElementById("time").innerHTML = (minutes < 10 ? '0' : '') + minutes + ":" + (seconds < 10 ? '0' : '') + seconds;
				}, 1000);
			</script>
		
		</div>

		
	</body>

</html>