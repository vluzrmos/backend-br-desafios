# Desafios

- [Loans](https://github.com/backend-br/desafios/tree/master/loans/PROBLEM.md)
- [Secure Password](https://github.com/backend-br/desafios/tree/master/secure-password/PROBLEM.md)
- [Points of Interest](https://github.com/backend-br/desafios/tree/master/points-of-interest/PROBLEM.md)
- [Url Shortener](https://github.com/backend-br/desafios/tree/master/url-shortener/PROBLEM.md)

# Requisitos do Projeto
- Docker

# Instalar dependências

```bash
docker compose run app composer install
```

# Iniciar servidor
```bash
docker compose up -d
```

# Endpoints:

- Desafio Loans:
    - [POST] /loans/customer-loans
- Desafio Secure Password:
    - [POST] /secure-password/validate-password
- Desafio Points of Interest: 
    - [POST] /points-of-interest
        - name: string
        - x: float
        - y: float
    - [GET] /points-of-interest
    - [GET] /points-of-interest/near?x=&y=&dmax=
- Desafio Url Shortener:
    - [POST] /url-shortener/shorten-url
        - url: string
    - [GET] /url-shortener/{id}