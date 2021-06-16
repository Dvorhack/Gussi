<?php 
session_start();
?>





<!DOCTYPE html>
<html>
 
	<head>
		<metacharset="utf-8">
		<title>Gussi-Liste</title>
		<link rel="stylesheet" type="text/css" href="list.css">
		<link rel="stylesheet/less" type="text/css" href="styles.less" />
		<meta name="viewport" content="width=device-width"/>
	</head>
 
  	<body>
		<h1>Playlist</h1>
		<br><br><br><br>
		<form method="POST" action="upload.php" enctype="multipart/form-data">
		 <input type="hidden" name="MAX_FILE_SIZE" value="100000">Fichier : <input type="file" name="avatar">
		 <input type="submit" name="envoyer" value="Envoyer le fichier">
</form>

</form>
	
		<div id="liste">
			<?php 
			$fileList = glob('sounds/*');

			foreach($fileList as $filename){
			
				if(is_file($filename)){
					$name = explode('.mp3',explode('/',$filename)[1])[0];
					//$nameclean= explode('_',$name[1]);
					?>
					<div class="ListElt" onclick="changeTrack(<?php echo "'".$filename."'"; ?>)">
					
						<?php 
							$phrase=preg_split("/(-|_)/",$name);
							$string = "";
							for ($i = 0; $i< sizeof($phrase) ; $i++){
							$string.=$phrase[$i]." ";
				
			}
							if(file_exists('Pochettes/'.$name.'.jpg')){
								echo '<img src="Pochettes/'.$name.'.jpg"  class="Image2"/>'; 

							}
							else{
								echo '<img src="Pochettes/defaut.jpg"  class="Image2"/>' ;
							}
							echo ' <div class="Testpochette"> '.$string.' </br> Durée: '.shell_exec("mp3info -p '%S' $filename").' sec </div>';
						?>
					</div>
					<?php 
			
				}   
			
			}
			?>
		</div>
			
		
		<ul class="menutop" onclick="toMain()">

			<li class="menutop" style="text-align: center;padding: 14px 16px">Musique en cours :</li>
			<?php
				echo"<li class='menutop' style='text-align: center;padding: 14px 16px'>".$_SESSION['titre_musique']."</li>"; 
			?>
		</ul> 
  	</body>
	
	<script type="text/javascript">

		function toMain(){
			document.location.href="index.php";
		}
		function changeTrack(nomMusique){
			document.location.href="index.php?track="+nomMusique;
		}
	</script>
	
	
 
</html>