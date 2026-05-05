--TEST--
Drop profiles under ms threshold: default of 0 keeps every profile
--INI--
spx.data_dir="{PWD}/tmp_data_dir_disabled"
--ENV--
return <<<END
SPX_ENABLED=1
SPX_AUTO_START=0
SPX_REPORT=full
END;
--FILE--
<?php
$dataDir = ini_get('spx.data_dir');
$clean = function () use ($dataDir) { exec(sprintf('rm -rf %s', escapeshellarg($dataDir))); };
$clean();

function foo() {}

spx_profiler_start();
foo();
$key = spx_profiler_stop();

$json = "$dataDir/$key.json";
$gz   = "$dataDir/$key.txt.gz";
$zst  = "$dataDir/$key.txt.zst";

echo "json_exists=", file_exists($json) ? 'yes' : 'no', "\n";
echo "data_exists=", (file_exists($gz) || file_exists($zst)) ? 'yes' : 'no', "\n";

$clean();
?>
--EXPECT--
json_exists=yes
data_exists=yes
