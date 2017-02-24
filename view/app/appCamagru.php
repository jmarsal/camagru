<?php
if (!isset($_SESSION)){
    session_start();
}
?>
<?php echo "<h2 class='bienvenue'>Bienvenue ".$_SESSION["login"]."<h2/>"; ?>
<div class="booth">
    <video id="myvideo"></video>
    <button id="startbutton">Prendre une photo</button>
    <canvas id="canvas"></canvas>
    <img src="http://placekitten.com/g/320/261" id="photo" alt="photo">
</div>