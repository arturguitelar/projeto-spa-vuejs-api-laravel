# SPA com VueJS e API com Laravel

Esta aplicação é uma mini rede-social que utiliza [Vue.js](https://vuejs.org/) no frontend e [Laravel](https://laravel.com/) como api no backend.

Este projeto foi criado para estudo utilizando como base o curso [SPA com VueJS e API com Laravel](https://www.udemy.com/spa-com-vue-js/) do [Guilherme Ferreira](https://www.udemy.com/user/guilherme-ferreira-4/), criador do [GuiaCódigo](https://www.guiacodigo.com/).

Versão Laravel utilizada: 5.6.39.

Versão Vuejs utilizada: 2.5.17.

O projeto segue a licença MIT e o código pode ser usado por qualquer pessoa, basta que se dê as devidas referências.

E, quando puder, compre o curso! Vale muito a pena! :D

**Como instalar.**

O projeto utiliza duas aplicações:
A aplicação em Vue.js (pasta "social") é o frontend da rede-social. É uma SPA que consome os dados de uma api.
A aplicação em Laravel (pasta "webserice") é a api que provém dados para a rede-social.
As duas aplicações rodam em portas diferentes e ambas necessitam ter seus pacotes instalados.

A aplicação "social" necessita ter o [Node.js](https://nodejs.org) e o [Vue-cli](https://cli.vuejs.org/) (caso queria desenvolver no projeto) para ser utilizada.

A aplicação "webservice" necessita ter o [Composer](https://getcomposer.org/) para ser utilizada. Ela utiliza o framework [Laravel](https://laravel.com/) que, por sua vez, utiliza o [Artisan](https://laravel.com/docs/5.6/artisan).

**Suba o webservice**
Na pasta "webservice":
Para instalar as dependências:
```
composer install
```

Para instalar as migrações do banco de dados:
```
php artisan migrate
```

Para rodar o server:
```
php artisan serve
```

**Depois suba a rede-social**
Na pasta "social".

Para instalar as dependências:
```
npm install
```

Para rodar o server:
```
npm start
```

###Coisas interessantes abordadas no curso durante este projeto:
> Em progresso
