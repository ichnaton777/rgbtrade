# restore script, reverse of mybackup
# need a file prefix-def.mysql and prefix-data.mysql
mysql rgb  -urgb -prgbpw < rgb-def.mysql
mysql rgb  -urgb -prgbpw < rgb-data.mysql

