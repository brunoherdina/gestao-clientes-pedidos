# README

1) Ajustar o .env da aplicação para ficar  de acordo com as informações presentes em docker-compose.yml

2) Estando na pasta raíz do projeto, execute os comandos abaixo de acordo com a ação desejada:

 - ./scripts/build.sh -> Realiza a build do projeto
 - ./scripts/install.sh -> Instala as dependências, roda as migrations e seeders e executa o projeto (não é necessário rodar o up.sh)
 - ./scripts/up.sh -> Inicia a aplicação
 - ./scripts/down.sh -> Finaliza a aplicação