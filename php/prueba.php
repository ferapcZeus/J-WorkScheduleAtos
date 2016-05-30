<html lang="en">
<head>
  <meta charset="utf-8">
  <title>ready demo</title>
  <style>
  p {
    color: red;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
 
<p id="lolo">Not loaded yet.</p>
<script>
	$.ajax({
		url: 'peticiones/Listar2.php',
		type: 'POST',
		async: true,
		data: {'action' : 'jornadasRealiza'},
		dataType: 'json',
		success: function(jornadas)
		{
			$('#lolo').html("¡¡¡LOADED!!!")
			console.log(jornadas[0]);
			
		},
		error: function(es){console.log(es)}
	});
</script>
 
 
</body>
</html>