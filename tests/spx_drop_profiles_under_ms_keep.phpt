--TEST--
Drop profiles under ms threshold: profile above threshold is kept
--ENV--
return <<<END
SPX_ENABLED=1
SPX_AUTO_START=0
SPX_REPORT=full
SPX_DROP_PROFILES_UNDER_MS=1
END;
--FILE--
<?php
function foo() {
    usleep(50000); // 50ms — well above the 1ms threshold
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
json_exists=yes
data_exists=yes
