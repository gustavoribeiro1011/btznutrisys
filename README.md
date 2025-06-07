# BTZ NUTRI SYS

Sistema para gerenciamento e projeção de consumo de ração para granjas de frango de corte

## Tecnologias

- PHP 8.2
- Laravel 12
- PostgreSQL 17

## Como instalar

  Observação:
- Esse projeto utiliza PostgreSQL na versão 17, antes de começar verifique se as extenções do seu arquivo php.ini estão habilitadas:
  extension=pgsql
  extension=pdo_pgsql

  Rodar os seguintes comandos:
- git clone https://github.com/gustavoribeiro/btznutrisys
- cd btznutrisys
- composer install
- php artisan migrate
- php artisan serve

## Decisões técnicas
