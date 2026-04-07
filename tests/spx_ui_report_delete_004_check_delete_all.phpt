--TEST--
UI: check directory state after deleting all
--CGI--
--INI--
log_errors=on
--ENV--
--FILE--
<?php
$dataDir = getcwd() . '/tmp_data_dir';
// Only non-report files should remain.
$iterator = new \FilesystemIterator($dataDir);
$files = [];
foreach($iterator as $file) {
  echo $file->getFilename() . "\n";
}
--EXPECT--
foo.txt
