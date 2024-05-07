# Projeto Desafio

## Instalação

-> Intalar PHP v8.1 <br>
-> Instalar postgres <br>
-> Instalar composer

## Execução

- Criar o arquivo .env e configurar com os dados do seu banco, EX:
  DB_CONNECTION=pgsql <br>
  DB_HOST=localhost <br>
  DB_PORT=5050 <br>
  DB_DATABASE=desafio <br>
  DB_USERNAME=us_postgres <br>
  DB_PASSWORD=us_postgres <br><br>
- <b>Na pasta database tem um dump do banco para facilitar app/database/backup.sql</b>

Installar o composer
```bash
composer install
```

Para executar o projeto, basta executar o comando abaixo na raiz do projeto

```bash
 php -S localhost:8080 
```

## Acesso

Apos executar todos os passo, acessar http://localhost:8080/api/