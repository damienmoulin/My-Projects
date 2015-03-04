// script de tchat.php
  
  <h1>Tchat</h1>
  	<!-- VERIFICATION DU NOMBRE D'ENTREE' DANS LA 
  	TABLE TCHAT AFIN DE SUPPRIMER LES MESSAGES TROP VIEUX -->
  	<?php require_once('../../admin/connexion/mysql_connexion.php');
  	$sql = "SELECT `id` FROM `tchat` WHERE 1";
  
  	if (!($reponse = $db->query($sql))){
  		die ('ERREUR DE REQUETE (SELECT ID)');
  	}
  
  	if ($reponse->num_rows > 15){
  		$query = "DELETE FROM `tchat` ORDER BY `id` LIMIT 5";
  		if (!($result = $db->query($query))){
  			die ('ERREUR DE REQUETE (DELETE TCHAT)');
  		}
  	}
  	?>
  	<!-- SCRIPT TERMINER -->
  	<div class="tchat">
  		<table>
  			<div id="zone">
  			</div>
  		</table>
  			<input id="pseudo" type="text" placeholder="Pseudo">
  			<input id="tchat" type="text" placeholder="Message">
  			<input id="validate" type="submit"/>
  			<div class="gitHub">
  					<a href=""><p>Voir le code</p></a>
  			</div>
  			<div class="retour">
  					<a href="http://damienmoulin.com/index.php"><p>Retour</p></a>
  			</div>
  	</div>
  
  	<script src="jquery.min.js"></script>
  	<script type="text/javascript">
  		$('#validate').click(function(){
  			var message = document.getElementById('tchat').value;
  			var pseudo = document.getElementById('pseudo').value;
  			$.get('scripttchat.php',{message:message,pseudo:pseudo});
  			document.getElementById('tchat').value = "";
  		});
  
  		function refresh(){
  			$.get('tchatAffichage.php').done( function(data){
  				var affichage = data.split('</br>');
  					document.getElementById('zone').innerHTML = '<table>'+affichage+'</table>';
  			})
  			setTimeout("refresh()",1000);
  		}
  		refresh();
  	</script>
  	
  	
//scripttchat.php

<!-- SCRIPT TCHAT AJAX -->

<?php
	require_once('../../admin/connexion/mysql_connexion.php');
	$message = $db->real_escape_string(strip_tags($_GET['message']));
	$pseudo = $db->real_escape_string(strip_tags($_GET['pseudo']));
	$date = date("Y-m-d");

	if (strlen($pseudo) > 0 && strlen($message) > 0){
		$sql="INSERT INTO `tchat`(`pseudo`, `message`, `date`) VALUES ('".$pseudo."','".$message."','".$date."')";
		if (!($result = $db->query($sql))){
			die ('Erreur Requette (TCHAT INSERT)');
		};

	}
?>

// tchataffichage.php

<?php
require_once('../../admin/connexion/mysql_connexion.php');
			$sql_tchat = "SELECT `pseudo`, `message`, `date` FROM `tchat` ORDER BY id DESC LIMIT 15";
			if (!($reponse = $db->query($sql_tchat))){
				die ('Erreur de Requette (SELECT TCHAT)');
			}
			while ($row = $reponse->fetch_assoc()){
				echo "<tr>"."<td>".$row['date']." : "."</td>"."<td>"."<strong>".$row['pseudo']."</strong>"." : "."</td>"."<td>".$row['message']."</td>".'</tr>';
			};
?>
