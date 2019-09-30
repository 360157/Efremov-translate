## Setup

-- Add to composer.json

1) 
```bash
"repositories": [
           {
               "type":"package",
               "package":{
   
                   "name":"sashaef/translateprovider",
                   "version": "dev-master",
                   "source":{
                       "type":"git",
                       "url":"ssh://git@95.211.204.15:8415/esv2/translateprovider.git",
                       "reference":"master"
                   }
               }
           }
       ],
```       
2) 

 ```bash
 "require": {
            ...,
            "sashaef/translateprovider": "dev-master"
        },     
  ```       
-- Than run composer install and composer update        



-- Add to config/app.php

```bash
Sashaef\TranslateProvider\TranslateProvider::class,
```


-- Add to composer.json

```bash
"autoload": {
        "psr-4": {
            "App\\": "app/",
            "Sashaef\\TranslateProvider\\": "vendor/sashaef/translateprovider/src/"
        },
}
```

-- Than
```bash
php artisan migrate
```
## WEB
```bash
/system-trans
/interface-trans
/langs
```
## API
```bash
route - translate/show
```
@bodyparams - "key"   (interface:main:new_translation:2)

@response    {
                 "interface:main:new_translation:2": "r2fd"
             }
             