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
		$_POST["code"]
	);

	$st->setMemoryLimit(1024 * 512); // max memory usage per exec 512 MB
	$st->setMaxProcesses(3); // max child processes per exec 3 processes
	$st->setMaxWallTime(5); // max walltime per exec 5 seconds
	$st->setMaxExecutionTime(5); // max exec time per exec 5 seconds
	$st->setExtraTime(5); // max extratime per exec 5 seconds


	$st->run("/usr/bin/php7.1 /home/u".$id."/".$fn);

	print "ISOLATE OUT:<br/> <pre>".htmlspecialchars($st->getIsolateOut())."</pre>";
	print "<br/>STDOUT:<br/> <pre>".htmlspecialchars($st->getStdout())."</pre>";
	print "<br/>STDERR:<br/> <pre>".htmlspecialchars($st->getStderr())."</pre>";
	unset($st);
	exit;
}

?><!DOCTYPE html>
<html>
<head>
	<title>SGB Ngods</title>
</head>
<body>
	<center>
	<h3>Enter your PHP code here!</h3>
	<div style="border: 1px solid #000;">
		<form action="?action=1" method="POST">
			<textarea style="width: 425px; height: 188px; background: transparent none repeat scroll 0% 0% !important; z-index: auto; position: relative; line-height: 14px; font-size: 12px; transition: none 0s ease 0s;" name="code"><?php print htmlspecialchars(base64_decode("PD9waHAKcHJpbnQgCiJDdXJyZW50IFdvcmtpbmcgRGlyZWN0b3J5OiIuCnNoZWxsX2V4ZWMoInB3ZCIpLiJcbiIuCiJMaXN0IEZpbGVzOlxuIi4Kc2hlbGxfZXhlYygibHMgLWFsIikuIlxuIi4KIlVzZXI6ICIuCnNoZWxsX2V4ZWMoIndob2FtaSIpLiJcbiIuCiJQSFAgVmVyc2lvbjogIi5QSFBfVkVSU0lPTjsK")); ?></textarea>
			<br/><input type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	</center>
</body>
</html>