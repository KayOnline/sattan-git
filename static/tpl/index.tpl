<!DOCTYPE html>
<html>
<head>
	<title>dwoo demo</title>
</head>
<body>
	{dump($dwoo.get['m'])}
	{dump($dwoo.session['author'])}
	{dump($dwoo.const.ROOT_PATH)}
	{dump($dwoo.env)}
	<span>{$a}-{$b}-{$c}</span>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
		$(function() {
			alert("OK");
		});
	</script>
</body>
</html>