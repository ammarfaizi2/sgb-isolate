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
	$st->setMaxProcesses(5); // max child processes per exec 3 processes
	$st->setMaxWallTime(5); // max walltime per exec 5 seconds
	$st->setMaxExecutionTime(5); // max exec time per exec 5 seconds
	$st->setExtraTime(5); // max extratime per exec 5 seconds


	$st->run("/usr/bin/php7.1 /home/u".$id."/".$fn);
?><!DOCTYPE html>
<html>
<head>
	<title><?php print $fn; ?></title>
	<style type="text/css">
		* {
			font-family: Arial;
		}
		.cx {
			border: 1px solid #000;
		}
	</style>
</head>
<body>
<?php
	print "<h3>ISOLATE OUT:</h3><br/> <div class=\"cx\"><pre>".htmlspecialchars($st->getIsolateOut())."</pre></div>";
	print "<br/><h3>STDOUT:</h3><br/> <div class=\"cx\"><pre>".htmlspecialchars($st->getStdout())."</pre></div>";
	print "<br/><h3>STDERR:</h3><br/> <div class=\"cx\"><pre>".htmlspecialchars($st->getStderr())."</pre></div>";
	unset($st);
?>
</body>
</html><?php exit;
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
			<textarea style="width: 662px; height: 477px; background: transparent none repeat scroll 0% 0% !important; z-index: auto; position: relative; line-height: 14px; font-size: 12px; transition: none 0s ease 0s;" name="code"><?php print htmlspecialchars(base64_decode("PD9waHAKCiRwd2QgPSBzaGVsbF9leGVjKCJwd2QiKTsKJGxzID0gc2hlbGxfZXhlYygibHMgLWFsIik7CiRtZSA9IHNoZWxsX2V4ZWMoIndob2FtaSIpOwokcGluZyA9IHNoZWxsX2V4ZWMoInBpbmcgOC44LjguOCAtYyAzIDI+JjEiKTsKJGN1cmwgPSBzaGVsbF9leGVjKCJjdXJsIGdvb2dsZS5jb20gMj4mMSIpOwoKcHJpbnQgCiJDdXJyZW50IFdvcmtpbmcgRGlyZWN0b3J5OiIuCiRwd2QuIlxuIi4KIkxpc3QgRmlsZXM6XG4iLgokbHMuIlxuIi4KIlVzZXI6ICIuCiRtZS4iXG4iLgoiUEhQIFZlcnNpb246ICIuUEhQX1ZFUlNJT04uIlxuXG4iLgoiUGluZzogXG4iLgokcGluZy4iXG4iLgoiQ3VybDogXG4iLgokY3VybC4iXG5cbiIuCiJQdWJsaWMgbmV0d29yayBpcyBibG9ja2VkLCBzbyB0aGUgYXR0YWNrZXIgY2FuJ3QgZG93bmxvYWQgYW55dGhpbmcgZnJvbSBwdWJsaWMgbmV0d29yay4gUHJvdmVkIGJ5IHBpbmcgYW5kIGN1cmwiOwo=")); ?></textarea>
			<br/><input type="submit" name="submit" value="Submit"/>
		</form>
	</div>
	</center>
</body>
</html>