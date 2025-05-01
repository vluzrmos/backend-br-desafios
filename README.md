# Desafios

- [Loans](https://github.com/backend-br/desafios/tree/master/loans/PROBLEM.md)
- [Secure Password](https://github.com/backend-br/desafios/tree/master/secure-password/PROBLEM.md)

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
    - [GET] /points-of-interest/nearby?x=&y=&dmax=