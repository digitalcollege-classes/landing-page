## Como usar

1. Clonar a aplicação
```shell
git clone https://github.com/digitalcollege-classes/landing-page
```

2. Entrar no diretório
```shell
cd landing-page
```

3. Subir o docker
```shell
make up
```

4. Instala as depedencias
```shell
make composer_install
```

5. Se for a primeira vez migre os dados sql
```shell
make migrate
```


Pronto, deve estar rodando em <http://localhost:8080/admin>

---

### Troubleshooting

1. Se for precisar resetar o banco de dados
```shell
make reset_db
```

## Como contribuir com esse projeto

1. Atualize a sua branch principal
```
git checkout main
git pull origin main
```

2. Crie sua branch
```
git checkout -b nome-da-nova-branch
```
h
3. Faça as alterações que devem ser feitas
_faça os códigos_

4. Prepare o envio
```
git add .
git commit -m "descreva aqui..."
git push origin nome-da-nova-branch
```

5. Abra o Pull Request
Acesse <https://github.com/digitalcollege-classes/landing-page/pulls> e clique em "Compare & pull" para abrir o pull request

6. Peça aos coleguinhas para revisar seu código

7. Tá pronto o sorvetinho