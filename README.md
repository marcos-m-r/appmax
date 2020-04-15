Appmax - Prova PHP
=======================================

Como montar o ambiente de desenvolvimento
-------------------------------------------

- Clonar o repositório para o ambiente local
- Acessar o repositório

```bash
cd appmax
```

- Definir que o Git ignore a alteração das permissões dos arquivos

```bash
git config core.fileMode false
```

- Montar o container Docker

```bash
# Caso seja ambiente de produção
docker-compose up -d
```

- Executar o composer dentro do container

```bash
docker exec -it appmax-www bash

composer install
```
