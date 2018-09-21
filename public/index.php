<?php
ini_set("display_errors", 1);
define("ISOLATOR", realpath(__DIR__."/../isolator_dir"));
define("ISOLATOR_ETC", ISOLATOR."/etc");
define("ISOLATOR_TMP", ISOLATOR."/tmp");
define("ISOLATOR_HOME", ISOLATOR."/home");

require __DIR__."/../isolated_files/Isolator.php";

if (isset($_POST["code"])) {
	$id = 1;
	$st = new Isolator($id);
	file_put_contents(
		$f = ISOLATOR_HOME."/".$id."/u".$id."/".($fn = sha1($_POST["code"]).".php"),
		$_GET["code"]
	);
} else {
	exit;
}

if (! file_exists($f)) {
	file_put_contents($f, $this->code);
}

$st->setMemoryLimit(1024 * 512); // max memory usage per exec 512 MB
$st->setMaxProcesses(5); // max child processes per exec 5 processes
$st->setMaxWallTime(10); // max walltime per exec 10 seconds
$st->setMaxExecutionTime(5); // max exec time per exec 5 seconds
$st->setExtraTime(5); // max extratime per exec 5 seconds


$st->run("/usr/bin/php7.1 /home/u".$id."/".$fn);

print "ISOLATE OUT:<br/> <pre>".htmlspecialchars($st->getIsolateOut())."</pre>";
print "<br/>STDOUT:<br/> <pre>".htmlspecialchars($st->getStdout())."</pre>";
print "<br/>STDERR:<br/> <pre>".htmlspecialchars($st->getStderr())."</pre>";
unset($st);
?><!DOCTYPE html>
<html>
<head>
	<title>SGB Ngods</title>
</head>
<body>
	<center>
	<h3>Enter your PHP code here!</h3>
	<form action="?action=1" method="POST">
		<textarea name="code"><?php  print htmlspecialchars("<?php echo \"Hello SGB!\";"); ?></textarea>
		<input type="submit" name="submit" value="Submit"/>
	</form>
	</center>
</body>
</html>