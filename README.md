

        DB::enableQueryLog();
 $queries = DB::getQueryLog();
    
        $lastQuery = end($queries);
    
        $sqlWithBindings = vsprintf(str_replace('?', "'%s'", $lastQuery['query']), $lastQuery['bindings']);
    

    aws acess
    joaoufma3@gmail.com
    #JOao1408
---

🦀 Sistema de Rastreamento e Gestão da Pesca de Caranguejo - Back-End

Este repositório contém o back-end do sistema para otimização de custeio e rastreabilidade do pescado de caranguejo na região de Araioses-MA. A API foi desenvolvida com Laravel, proporcionando uma estrutura robusta e segura para gerenciar dados e a lógica de negócios do sistema.


---

🚀 Tecnologias Utilizadas

PHP: Linguagem de programação para desenvolvimento do back-end.

Laravel: Framework PHP para construção de APIs RESTful.

MySQL: Banco de dados relacional utilizado para armazenamento de dados.

Composer: Gerenciador de dependências do PHP.



---

🔧 Pré-requisitos

Antes de rodar o projeto, certifique-se de ter instalado:

1. PHP (>= 8.1): Download PHP


2. Composer: Instalar Composer


3. MySQL: Banco de dados para armazenar informações.


4. Git: Para clonar o repositório.




---

💻 Passos para Rodar o Projeto

1. Clone o Repositório

Abra o terminal e execute:

git clone <URL_DO_REPOSITORIO>

2. Acesse a Pasta do Projeto

cd nome-do-projeto-back-end

3. Instale as Dependências

Execute o comando para instalar todas as dependências do Laravel:

composer install

4. Configure o Arquivo .env

1. Renomeie o arquivo .env.example para .env.


2. Edite as configurações do banco de dados:



DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome-do-banco
DB_USERNAME=usuario
DB_PASSWORD=senha

3. Gere a chave da aplicação:



php artisan key:generate

5. Execute as Migrações do Banco de Dados

Para criar as tabelas no banco configurado:

php artisan migrate

php artisan db:seed

1. Inicie o Servidor Local

Execute o comando para rodar o servidor localmente:

php artisan serve

O servidor estará disponível em:

http://127.0.0.1:8000


---

✅ Funcionalidades Implementadas

Autenticação de usuários com Laravel Sanctum.

Gerenciamento de registros de pesca (CRUD).

Controle financeiro para administradores.

Geração de relatórios das atividades de pesca.

API RESTful para comunicação com o front-end.



---

📄 Rotas Principais

Autenticação

POST /api/login - Login do usuário.

POST /api/logout - Logout do usuário.


Usuários

POST /api/users - Criar novo usuário.

GET /api/users - Listar usuários existentes.


Registros de Pesca

POST /api/fishing-records - Adicionar novo registro de pesca.

GET /api/fishing-records - Listar registros de pesca.

PUT /api/fishing-records/{id} - Atualizar um registro.

DELETE /api/fishing-records/{id} - Remover um registro.


Relatórios

GET /api/reports - Gerar relatórios das atividades de pesca.



---

👨‍💻 Desenvolvedor

João Felipe Melo da Luz
Universidade Federal do Maranhão - Engenharia da Computação
Orientador: Prof. Dr. Haroldo Gomes


---


# back-cooperativa
# back-cooperativa
