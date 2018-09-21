<?php
ini_set("display_errors", 1);
define("ISOLATOR", realpath(__DIR__."/../isolator_dir"));
define("ISOLATOR_ETC", ISOLATOR."/etc");
define("ISOLATOR_TMP", ISOLATOR."/tmp");
define("ISOLATOR_HOME", ISOLATOR."/home");

require __DIR__."/../isolated_files/Isolator.php";

if (isset($_GET["code"])) {
	$id = 1;
	$st = new Isolator($id);
	file_put_contents(
		$f = ISOLATOR_HOME."/".$id."/u".$id."/".($fn = sha1($_GET["code"]).".php"),
		$_GET["code"]
	);
} else {
	exit;
}



if (! file_exists($f)) {
	file_put_contents($f, $this->code);
}

$st->setMemoryLimit(1024 * 512);
$st->setMaxProcesses(5);
$st->setMaxWallTime(10);
$st->setMaxExecutionTime(5);
$st->setExtraTime(5);

$st->run("/usr/bin/php7.1 /home/u".$id."/".$fn);


print "STDOUT:<br/> <pre>".htmlspecialchars($st->getStdout())."</pre>";
print "<br/>STDERR:<br/> <pre>".htmlspecialchars($st->getStderr())."</pre>";
unset($st);
