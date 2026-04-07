--TEST--
UI: delete confinement check
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
SPX_KEY=dev&SPX_UI_URI=/data/reports/delete/../data_dir/reportkey
--EXPECT--
File not found.
