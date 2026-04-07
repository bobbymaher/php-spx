--TEST--
UI: delete all reports (empty directory)
--CGI--
--INI--
spx.http_enabled=1
spx.http_key="dev"
spx.http_ip_whitelist="127.0.0.1"
spx.data_dir="{PWD}/tmp_data_dir"
log_errors=on
--ENV--
return <<<END
REMOTE_ADDR=127.0.0.1
REQUEST_URI=/
END;
--FILE--
<?php
// noop, never gets called.
?>
--GET--
SPX_KEY=dev&SPX_UI_URI=/data/reports/delete_all
--EXPECT--
{"success": true}
--CLEAN--
<?php
$dataDir = __DIR__ . '/tmp_data_dir';
exec(sprintf('rm -rf %s', escapeshellarg($dataDir)));
