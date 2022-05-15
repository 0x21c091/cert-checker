# Domain cert checker

Install dependencies

```bash
composer install
```

use check certs from badssl.com

```bash
php bin/console check github.com no-common-name.badssl.com
```

```bash
echo 'github.com no-common-name.badssl.com' | xargs php bin/console check
```

```bash
cat domains.list | xargs php bin/console check
```

```bash
 ! [NOTE] check domain: github.com                                              

 ! [NOTE] check domain: no-common-name.badssl.com                               

 !                                                                              
 ! [CAUTION] Could not download certificate for host `no-common-name.badssl.com`
 !           because Could not connect to `no-common-name.badssl.com`.          
 !                                                                              

                                                                                
 [OK] All domains are checked                                                   
                                                                                
```