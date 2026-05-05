--TEST--
Drop profiles under ms threshold: threshold is interpreted in milliseconds (regression for unit-mismatch bug)
--INI--
spx.data_dir="{PWD}/tmp_data_dir_unit"
--ENV--
return <<<END
SPX_ENABLED=1
SPX_AUTO_START=0
SPX_REPORT=full
SPX_DROP_PROFILES_UNDER_MS=2
END;
--FILE--
<?php
$dataDir = ini_get('spx.data_dir');
$clean = function () use ($dataDir) { exec(sprintf('rm -rf %s', escapeshellarg($dataDir))); };
$clean();

function foo() {
    usleep(1000); // 1ms — below the 2ms threshold; profile must be dropped
}

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
json_exists=no
data_exists=no
