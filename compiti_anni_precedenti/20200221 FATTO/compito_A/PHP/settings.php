<?php 
if(isset($_POST["username"]) && isset($_POST["remember"]) && $_POST["remember"] == "on") {
  setcookie("username", $_POST["username"], time() + 3600);
}

if(isset($_POST["notizie"]) && isset($_POST["remember"]) && $_POST["remember"] == "on") {
  setcookie("categoria", $_POST["notizie"], time() + 3600);
}
?>

<html lang="it">
  <head>
    <title>Esercizio PHP</title>
  </head>
  <body>
    <div class="header">
      <a  class="home">Esercizio PHP</a>
      <div class="products">
        <a href="index.php">Homepage</a>
        <a href="settings.php">Settings</a>
      </div>
    </div>

    <form action="settings.php" method="post" style="border: 2px dotted blue; text-align:center; width: 400px;">
	   <p>
		     <label for="username">Username </label><input name="username" type="text" value="<?php echo (isset($_COOKIE["username"]) ? $_COOKIE["username"] : "")?>" >
	   </p>
     <p>
       <label for="notizie">Categoria notizie:</label>
       <select name="notizie">
         <option value="">--------</option>
          <option value="politica" <?php echo (isset($_COOKIE["categoria"]) && $_COOKIE["categoria"] == "politica" ? "selected" : "")?>>Politica</option>
          <option value="attualità" <?php echo (isset($_COOKIE["categoria"]) && $_COOKIE["categoria"] == "attualità" ? "selected" : "")?>>Attualità</option>
          <option value="sport" <?php echo (isset($_COOKIE["categoria"]) && $_COOKIE["categoria"] == "sport" ? "selected" : "")?>>Sport</option>
          <option value="scienze" <?php echo (isset($_COOKIE["categoria"]) && $_COOKIE["categoria"] == "scienze" ? "selected" : "")?>>Scienze</option>
        </select>
	   </p>
		 <p>
      <input type="checkbox" name="remember" /> Remember me
	   </p>
		<p>
      <input type="submit" value="submit"></input>
    </p>
    </form>

  </body>
</html>
