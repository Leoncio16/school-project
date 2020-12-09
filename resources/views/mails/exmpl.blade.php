<html>
<head>
    <meta charset="utf-8">
</head>
<body style="background-color: #264653; color: white; text-align:center; margin: 0;">

<div style="padding: 20px; color:white;">
<h1>
  Witaj, jest dostępny nowy artykuł "{{$title}}"
</h1>
</div>
<div style="background-color:black; color: white; padding: 20px;">
  <?php
    echo "<p style='color:white;'>".$content."</p><br><br>";
    echo "<a style='text-decoration:none; color: white; font-weight:bold; cursor:pointer;' href='wp.pl'>Przejdz do strony</a>";
  ?>
</div>
<div style="padding:20px; color:white;">
  <p>	Moja Aplikacja &copy; <?php echo date("Y"); ?></p>
</div>

</body>
</html>
