<?php
session_start();
if(isset($_GET['track'])){
	//echo '<p>changement musique pour '.$_GET['track']."</p>";
	$file = explode("/",$_GET['track'])[1];
	$cmd = "python3 /home/pi/site/command.py 'new $file'";
	//$cmd = "omxplayer -o local /home/pi/site/$file &";
	//echo $cmd;
	exec($cmd);
	$_SESSION['musique'] = $file;
	$_SESSION['playPause'] = 0;
}
if(isset($_GET['playPause'])){
	/*
	0 -> Play
	1 -> Pause
	*/
	if($_SESSION['playPause'] == 0)
		$cmd = "python3 /home/pi/site/command.py pause";
	else
		$cmd = "python3 /home/pi/site/command.py play";

	$_SESSION['playPause'] = ($_SESSION['playPause'] + 1) % 2;

	system($cmd);
}
if(isset($_GET['next'])){

	$cmd = "python3 /home/pi/site/command.py next";
	system($cmd);
}
if(isset($_GET['prev'])){
	$cmd = "python3 /home/pi/site/command.py prev";

	

	system($cmd);
}
if(isset($_GET['vol'])){
	$cmd = "python3 /home/pi/site/command.py 'vol " . $_GET['vol'] . "'";
	$_SESSION['vol'] = $_GET['vol']*150;
	//echo $cmd;
	system($cmd);
}
if(isset($_GET['time'])){
	$cmd = "python3 /home/pi/site/command.py 'time " . $_GET['time'] . "'";
	//$_SESSION['time'] = $_GET['vol']*40;
	//echo $cmd;
	system($cmd);
}
?>


<!DOCTYPE html>
<html>
 
  	<head>
		<metacharset="utf-8">
		<title>Gussi-Control</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width"/>

  	</head>
 
  	<body>
	
		<a href="list.php"><img src="Images/playlist.png" class="Retour"/></a>
		<?php 	
				$tuile=explode(".",$file);
				if(file_exists('Pochettes/'.$tuile[0].'.jpg')){
					echo '<img src="Pochettes/'.$tuile[0].'.jpg" alt="Bonjour à tous je suis l image" class="Image"/>'; 

				}
				else{
					echo '<img src="Images/LogoTigre.png" alt="Bonjour à tous je suis l image" class="Image"/>' ;
					}
		?>
		
		
		<br />
		
		<?php 
		if(isset($file)){
			
			$tuile=explode(".",$file);
			$phrase=preg_split("/(-|_)/",$tuile[0]);
			$string = "";
			for ($i = 0; $i< sizeof($phrase) ; $i++){
				$string.=$phrase[$i]." ";
				
			}
			echo "<div class='tuile' style='text-align:center;padding-top:20px;font-size:150%;'>$string</div>"; 
			$_SESSION['titre_musique']=$string;
		}else if(isset($_SESSION['titre_musique']))
			echo "<div class='tuile' style='text-align:center;padding-top:20px;font-size:150%;'>".$_SESSION['titre_musique']."</div>";
		else
			echo "<div class='tuile' style='text-align:center;padding-top:20px;font-size:150%;'>Pas de musique en cours</div>";
		?>

		<p class="Vol">
			<img src="Images/Volume.png"  class="Image2"/>
			<input class="custom-slider" id="VolSlide" type="range" value=<?php echo $_SESSION['vol'] ?>  onmouseup="modifVol()">
			
		</p>
		
		<p class="Timer">
		<img src="Images/white.jpg"  class="Image2"/>
			<input class="custom-slider" id="TimeSlide" type="range" value="50" onmouseup="modifTime()">
			
		</p>
		
		<div class="Boutton">
			<img src="Images/Backward.png" class="TailleButton" onclick="prevTrack()"/>
			<?php
			if ($_SESSION['playPause'] == 0)
				echo '<img src="Images/Play.png" class="TailleButtonPause" onclick="playPause()"/>';
			else
				echo '<img src="Images/Pause.png" class="TailleButtonPause" onclick="playPause()"/>';

			?>
			<img src="Images/Forward.png" class="TailleButton"onclick="nextTrack()"/>
		</div>
  	</body>
	<script>
		
		function prevTrack(){
			var url = window.location.href.split("?")[0];    

			url += '?prev=1'
			
			window.location.href = url;
		}
		function nextTrack(){
			var url = window.location.href.split("?")[0];    

			url += '?next=1'
			
			window.location.href = url;
		}
		function playPause(){
			var url = window.location.href.split("?")[0];    

			url += '?playPause=1'
			
			window.location.href = url;
		}
		function modifVol(){
			var url = window.location.href.split("?")[0];    

			url += '?vol=' + document.getElementById("VolSlide").value/40
			
			window.location.href = url;
			
		//	alert('volume ' + document.getElementById("VolSlide").value/10);
		}
		function modifTime(){
			var url = window.location.href.split("?")[0];    

			url += '?time=' + document.getElementById("TimeSlide").value
			
			window.location.href = url;
			
		//	alert('volume ' + document.getElementById("VolSlide").value/10);
		}
		document.getElementById("VolSlide").addEventListener('touchend', function(){
			var url = window.location.href.split("?")[0];    

			url += '?vol=' + document.getElementById("VolSlide").value/150
			
			window.location.href = url;
		});

		document.getElementById("TimeSlide").addEventListener('touchend', function(){
			var url = window.location.href.split("?")[0];    

			url += '?time=' + document.getElementById("TimeSlide").value
			
			window.location.href = url;
		});
	</script>
</html>