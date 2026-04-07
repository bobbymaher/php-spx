--TEST--
UI: report deletions
--CGI--
--INI--
log_errors=on
--ENV--
--FILE--
<?php
// Prepare the environment for spx to attempt report deletion.
$dataDir = getcwd() . '/tmp_data_dir';
@mkdir($dataDir);

$reports = ['foo', 'bar', 'baz'];
foreach($reports as $report) {
  file_put_contents("$dataDir/$report.json", $report);
  file_put_contents("$dataDir/$report.txt.gz", $report);
  file_put_contents("$dataDir/$report.txt.zst", $report);
}
// Create reports with just metadata
file_put_contents("$dataDir/barbaz.json", 'barbaz');
file_put_contents("$dataDir/foobar.txt.gz", 'foobar');
file_put_contents("$dataDir/foobar.txt.zst", 'foobar');
// Create a non-report file within the folder.
file_put_contents("$dataDir/foo.txt", 'foo.txt');
--EXPECT--
