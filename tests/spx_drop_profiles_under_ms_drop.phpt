--TEST--
Drop profiles under ms threshold: profile is dropped
--ENV--
return <<<END
SPX_ENABLED=1
SPX_AUTO_START=0
SPX_REPORT=full
SPX_DROP_PROFILES_UNDER_MS=10000
END;
--FILE--
<?php
function foo() {
}

spx_profiler_start();
foo();
$key = spx_profiler_stop();

$json = '/tmp/spx/' . $key . '.json';
$data = '/tmp/spx/' . $key . '.txt.gz';

echo "json_exists=", file_exists($json) ? 'yes' : 'no', "\n";
echo "data_exists=", file_exists($data) ? 'yes' : 'no', "\n";

@unlink($json);
@unlink($data);
?>
--EXPECT--
json_exists=no
data_exists=no
