# PHP REST API (Back-End)

Projeto de API REST usando o PHP(Back-End).

## Ramificações

| Ramificação                  | Status    |
| ---------------------------- | ---------:|
| Back-End     | :recycle: |
| [Front-End](/../../tree/frontend)  | :recycle: |

## Nginx

Sugestão de configuração do Nginx:

```
server {
    listen 80;
    listen [::]:80;
    server_name api.site.com;
    return 301 https://api.site.com$request_uri;
}

server {
    listen                  443 ssl;
    listen                  [::]:443 ssl;

    ssl_certificate         /etc/letsencrypt/live/site.com/fullchain.pem;
    ssl_certificate_key     /etc/letsencrypt/live/site.com/privkey.pem;

    root                    /var/www/api.site.com/public;
    index                   index.php;
    server_name             api.site.com;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    location / {
        #add_header 'Access-Control-Allow-Origin' '*';
        add_header Access-Control-Allow-Origin $http_origin;
        try_files /$uri /$uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }
}
```

## Contribua!

- Viu algum erro ou tem alguma sugestão? Abra uma [issue](https://github.com/sistematico/php-rest-api/issues/new)!

## Contato

- lucas@archlinux.com.br

## Agradecimentos

Agradeço de :heart: a JetBrains por me fornecer de forma gratuita as melhores ferramentas do mundo.

[![JetBrains](https://i.imgur.com/fRGi3wI.png)](https://www.jetbrains.com) [![PhpStorm](https://i.imgur.com/lqhtz4L.png)](https://www.jetbrains.com/phpstorm/) [![WebStorm](https://i.imgur.com/hATeqvO.png)](https://www.jetbrains.com/webstorm/) [![DataGrip](https://i.imgur.com/Lhx4pdh.png)](https://www.jetbrains.com/datagrip/)

## Ajude

Se você achou meu trabalho útil de qualquer forma, considere doar qualquer valor através do das seguintes plataformas:

[![PagSeguro](https://img.shields.io/badge/PagSeguro-gray?logo=pagseguro&logoColor=white&style=flat-square)](https://pag.ae/bfxkQW) [![ko-fi](https://img.shields.io/badge/ko--fi-gray?logo=ko-fi&logoColor=white&style=flat-square)](https://ko-fi.com/L4L119L8J) [![Buy Me a Coffee](https://img.shields.io/badge/Buy_Me_a_Coffee-gray?logo=buy-me-a-coffee&logoColor=white&style=flat-square)](https://www.buymeacoffee.com/sistematico)
