<!DOCTYPE html>
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>Premier contact par Cesar Gabriel Marrero</title>
   <style type="text/css">
      BODY { font-family:verdana; font-size:16px; }
      .sGras { font-weight:bold; }
      .sItalique { font-style:italic; }
   </style>
</head>
<body>
   <p>
      <?php if(!isset($_GET["MonNom"]) || $_GET["MonNom"] == ""){
		  
		  echo "Bonjour bel(le) inconnu(e) !<br/><br/> ";
		  echo "Syntaxe: <span class=\"sGras\"> index.php?".
		  "MonNom=<span class=\"sItalique\">Gabriel Marrero</span></span>\n";
	  } else{
		  $MonNom = $_GET["MonNom"];
		  echo "Salutations <span class=\"sGras\">$MonNom</span>!\n";
	  }
	  ?>
       
   </p>
</body>
</html>