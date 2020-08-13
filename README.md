# ping-koneksi.php

![screenshot](https://github.com/aviantorichad/ping-koneksi.php/blob/master/ss.png)

## INSTALLATION

- clone or download this repo
- [NATIVE PHP]
  `cd ping-koneksi.php`
  then
  `php -S 0.0.0.0:9090`

- [XAMPP] extract/copy paste to your htdocs folder

- access it from your browser (native)
  `localhost:9090/index.php`
  or (xampp)
  `localhost/ping-koneksi.php/index.php`

## CONFIG/ADD LIST

- edit file index.php to add/edit/remove host list

```php
// ************* list ip/host.begin **************
$hosts = [];
$hosts['AP'] = '192.168.1.1';
$hosts['GOOGLE'] = 'google.com';
$hosts['YOUTUBE'] = 'youtube.com';
$hosts['FACEBOOK'] = 'facebook.com';
$hosts['INSTAGRAM'] = 'instagram.com';
$hosts['TWITTER'] = 'twitter.com';
$hosts['DETIK'] = 'detik.com';
// ************* list ip/host.end ****************
```

- save it
- and then reload browser

## USING IT

- Play Ping : for interval ping (10s default)
- Timer : timer (click this button to change timer)
- Ping Sekali : ping once

## LEGEND

- green : 200 <= (ping) [ok]
- yellow : 200 > (ping) < 500 [warning]
- red : (ping) > 500 [danger]
- blue : down (not connected) [RIP]
