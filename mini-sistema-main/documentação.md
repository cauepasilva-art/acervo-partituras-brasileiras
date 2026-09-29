# Mini sistema para gerenciamento de alunos

## Objetivos:

### Requisitos funcionais:
1. Adicionar alunos
- Receber Nome, Turma, Nascimento, Ativo.

2. Excluir aluno:
- Excluir um aluno específico pelo ID.

3. Consultar aluno:
- Consultar um aluno específico pelo ID.

4. Listar todos os alunos:
- Criar um relatório com todos os alunos cadastrados.

5. Atualizar aluno:
- Atualizar um cadastro a partir de um ID.

### Login
RF:
1. Cadastro de usuário.
2. Página de login.
3. Página de logout.
4. Verificação de usuário logado.

### Realização do mini sistema

# 1. App
- Criar a pasta app para armazenar os arquivos de gerenciamento de alunos.

## 1.1. create.php

O create vai ter a função de cadastrar um aluno no sistema (após o login).
Ele vai ser separado em 3 partes:
1. Verificar se o usuário está logado, a partir do arquivo `verifica_user.php`.
2. Mostrar um formulário com os campos:
- nome
- turma
- data de nascimento
- se está ativo
3. Quando o formulário é enviado, o código recebe o POST e chama a função `cadastrar()` da `functions.php`.

No código real, o arquivo inclui `verifica_user.php` para bloquear acesso sem login. Depois ele monta o formulário com os campos de aluno e, ao enviar, executa:

```php
if($_SERVER['REQUEST_METHOD']== "POST"){
    var_dump($_POST);
    cadastrar($conexao, $_POST['nome'], $_POST['nasc'], $_POST['turma'], $_POST['ativo']);
}
```

Ou seja, ele pega os dados enviados e manda para a função de cadastro.

## 1.2 delete.php

O delete serve para excluir um aluno do banco.

Ele mostra um formulário com o campo `id` para receber o código do aluno que será apagado. Quando o formulário é enviado, o código executa:

```php
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    deletar($conexao, $_POST['id']);
}
```

Assim, ele chama a função `deletar()`, que faz um `DELETE` na tabela `alunos` pelo ID informado.

## 1.3 select_where.php

Essa página é usada para consultar um aluno específico pelo ID.

Ela mostra um formulário com o campo `id` e, ao enviar, executa:

```php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    consultar($conexao, $_POST['id']);
}
```

A função `consultar()` faz um `SELECT` filtrando pelo `id` e mostra os dados do aluno encontrado.

## 1.4 select.php

Essa página tem a função de listar todos os alunos cadastrados.

Ela chama a função `listar()`, que faz um `SELECT * FROM alunos` e imprime todos os registros na tela. Essa página funciona como um relatório geral do banco.

## 1.5 update.php

O update serve para editar um cadastro já existente.

A página recebe o ID do aluno e também os novos dados, como nome, turma, nascimento e status ativo. Quando o formulário é enviado, o código executa:

```php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    atualizar($conexao, $_POST['id'], $_POST['nome'], $_POST['turma'], $_POST['nasc'], $_POST['ativo']);
}
```

A função `atualizar()` faz um `UPDATE` na tabela `alunos` para alterar o registro escolhido.

# 2. Login

O sistema de login foi criado para controlar o acesso às páginas do sistema e garantir que apenas usuários autenticados possam usar as funções de gerenciamento.

## 2.1 cadastrar.php

Essa pagina serve para cadastrar um novo usuário no sistema.

Ela contém um formulário com os campos `email` e `senha`. Quando o formulário é enviado, o código executa:

```php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    cadastrar_user($conexao, $_POST['email'], $_POST['senha']);
}
```

Ou seja, ele envia os dados para a função `cadastrar_user()`, que insere os valores na tabela `usuarios`.

## 2.2 login.php

Essa pagina é a tela de autenticação do sistema.

O usuário informa email e senha. Quando o formulário é enviado, o código faz a busca do usuário pelo email com `consulta_user()`. Se o email e a senha baterem com o registro do banco, ele salva `$_SESSION['id']` e redireciona para `../index.php`.

## 2.3 verifica_user.php

Esse arquivo verifica se o usuário está logado.

Ele inicia a sessão e verifica se a variável `$_SESSION['id']` foi criada. Caso não exista, a página redireciona para `../login/login.php` e bloqueia o acesso.

## 2.4 logout.php

Essa página encerra a sessão do usuário.

O código limpa `$_SESSION` e chama `session_destroy()`, depois redireciona para a página inicial com `header("Location: ../index.php")`.

# 3. Includes

A pasta `includes` guarda funçoes e coisas que vão ser usadas em várias páginas do projeto.

## 3.1 header.php

O `header.php` é o cabeçalho do sistema.

Ele contém o título do site e o menu de navegação com links para as páginas principais do projeto, (usando o `href` do html) como:
- início
- cadastrar aluno
- excluir aluno
- relatório
- consultar aluno
- atualizar aluno
- cadastrar usuário
- entrar
- sair

Esse arquivo é incluído em muitas páginas com `include '../includes/header.php';`, para repetir o mesmo menu em todas as telas sem precisar escrever o mesmo código várias vezes.

## 3.2 footer.php

O `footer.php` é o rodapé do sistema.

Ele é usado para fechar a página e, no projeto atual, mostra apenas a mensagem "Eu sou o footer". 

## 4. Funções principais em functions.php

O arquivo `functions.php` reúne as funções do sistema para manipular o banco de dados.

### cadastrar()
Insere um novo aluno na tabela `alunos`.

### deletar()
Remove um aluno da tabela `alunos` pelo ID informado.

### listar()
Busca todos os alunos cadastrados e os exibe no navegador.

### consultar()
Busca um aluno específico pelo ID e mostra seus dados.

### atualizar()
Altera os dados de um aluno existente no banco.

### cadastrar_user()
Insere um usuário na tabela `usuarios`.

### consulta_user()
Busca um usuário pelo email para autenticação.

# 4. Banco

# Banco do Projeto

## Estrutura do banco

O sistema usa duas tabelas principais:

### Tabela de alunos

```sql
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    nasc DATE,
    turma VARCHAR(50),
    ativo BOOLEAN
);
```

### Tabela de usuários

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100),
    senha VARCHAR(100)
);
```

## Função do banco no sistema

O banco é usado para guardar as informações do sistema.

- A tabela `alunos` guarda os dados dos alunos cadastrados
- A tabela `usuarios` guarda os dados para fazer login

## Como o sistema usa o banco

- Quando o usuário cadastra um aluno, os dados vão para a tabela `alunos`
- Quando ele consulta um aluno, o PHP busca no banco
- Quando ele atualiza, o sistema muda os dados no banco
- Quando ele exclui, o sistema remove o registro do banco
- Quando faz login, o sistema compara email e senha com a tabela `usuarios`

## Conexão com o banco

O arquivo de conexão está em `database/connect.php` e é usado por todas as páginas que precisam acessar o banco.

Esse banco é o responsável por armazenar tudo que o sistema usa.

