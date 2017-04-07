## Lojas

[![Total Downloads](https://poser.pugx.org/mixdinternet/stores/d/total.svg)](https://packagist.org/packages/mixdinternet/stores)
[![Latest Stable Version](https://poser.pugx.org/mixdinternet/stores/v/stable.svg)](https://packagist.org/packages/mixdinternet/stores)
[![License](https://poser.pugx.org/mixdinternet/stores/license.svg)](https://packagist.org/packages/mixdinternet/seo)

![Área administrativa](http://mixd.com.br/github/47fa6fb2a4618843fc8a43f79fabbcef1.png "Área administrativa")

Gerenciador de lojas com opção de mapa.

## Instalação

Adicione no seu composer.json

```js
  "require": {
    "mixdinternet/stores": "0.1.*"
  }
```

ou

```js
  composer require mixdinternet/stores
```

## Service Provider

Abra o arquivo `config/app.php` e adicione

`Mixdinternet\Stores\Providers\StoresServiceProvider::class`

## Migrations

```
  php artisan migrate
```

## Key do maps

Adicione no .env `MAPS_KEY` e acrescente sua key 