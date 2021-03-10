# PHP REST API

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/sistematico/php-rest-api/Deploy?label=Github%20Action&logo=github&logoColor=white&style=flat-square)](https://github.com/sistematico/ptp-rest-api/actions?query=workflow%3ADeploy%20VueJS)

Projeto de API REST usando o PHP.

## Ramificações

| Ramificação                  | Status    |
| ---------------------------- | ---------:|
| [Back-End](/../../tree/backend) | :recycle: |
| Front-End | :recycle: |

## Nginx

Sugestão de configuração do Nginx:

```
server {
    listen 80;
    listen [::]:80;
    server_name rest.site.com;
    return 301 https://rest.site.com$request_uri;
}

server {
    listen 443 ssl;
    listen [::]:443 ssl;

    ssl_certificate         /etc/letsencrypt/live/site.com/fullchain.pem;
    ssl_certificate_key     /etc/letsencrypt/live/site.com/privkey.pem;

    root /var/www/rest.site.com/dist;
    index index.html;
    server_name rest.site.com;

    location / {
        try_files $uri $uri/ /index.html;
    }
}
```

## Setup do projeto
```
npm install
```

### Compila e habilita o hot-reload para desenvolvimento
```
npm run serve
```

### Compila e minifica para produção
```
npm run build
```

### Executa o lint e fixes nos arquivos
```
npm run lint
```

### Customizar a configuração
Veja [Referência para Configuração](https://cli.vuejs.org/config/).

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
