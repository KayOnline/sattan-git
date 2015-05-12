<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><!DOCTYPE html>
<html>
<head>
	<title>dwoo demo</title>
</head>
<body>
	<?php echo $this->classCall('dump', array((is_string($tmp=(isset($_GET['m'])?$_GET['m']:null)) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp), false));?>

	<?php echo $this->classCall('dump', array((is_string($tmp=(isset($_SESSION['author'])?$_SESSION['author']:null)) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp), false));?>

	<?php echo $this->classCall('dump', array((is_string($tmp=(defined("ROOT_PATH") ? ROOT_PATH : null)) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp), false));?>

	<?php echo $this->classCall('dump', array((is_string($tmp=(isset($this->globals["env"]) ? $this->globals["env"]:null)) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp), false));?>

	<span><?php echo (is_string($tmp=$this->scope["a"]) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp);?>-<?php echo (is_string($tmp=$this->scope["b"]) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp);?>-<?php echo (is_string($tmp=$this->scope["c"]) ? htmlspecialchars($tmp, ENT_QUOTES, $this->charset) : $tmp);?></span>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<script type="text/javascript">
		$(function() {
			alert("OK");
		});
	</script>
</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>