# 24198_Loja_GH

## Desenvolvido

Projeto desenvolvido durante a formação do CET-Especialista em Tecnologia e Programação com o formador João Monge 

---

Projeto de loja online desenvolvido em PHP, com funcionalidades básicas de gestão de utilizadores, produtos, carrinho de compras e ativação de conta via email.

---

## Estrutura do projeto

- `index.php`  
  Página principal do site (home).

- **Pasta `api/`**  
  Contém os scripts backend para funcionalidades da loja e autenticação.

  - `admin/`  
    Scripts para administração dos produtos:
    - `delete_product.php` — Apagar produto
    - `edit_product.php` — Editar produto
    - `insert_product.php` — Inserir novo produto

  - `PHPMailer/`  
    Biblioteca PHPMailer para envio de emails (ex: confirmação de conta).

  - Arquivos principais da API:
    - `add_to_cart.php` — Adicionar item ao carrinho
    - `auth.php` — Funções de autenticação e gestão de utilizadores
    - `db.php` — Configuração e conexão à base de dados
    - `delete_cart.php` — Remover item do carrinho
    - `email.php` — Funções para envio de email
    - `update_cart.php` — Atualizar quantidades no carrinho

- **Pasta `views/`**  
  Contém as páginas frontend da aplicação.

  - `areaadmin.php` — Área administrativa (dashboard)
  - `ativarconta.php` — Página para ativação de conta via email
  - `cart.php` — Página do carrinho de compras
  - `finish.php` — Confirmação de finalização de compra
  - `login.php` — Página de login
  - `logout.php` — Página de logout
  - `registo.php` — Página de registo de novos utilizadores

- Arquivo de base de dados:
  - `24198_Loja.sql` — Dump da base de dados usada no projeto (estruturas e dados iniciais)

---

## Funcionalidades principais

- Registo e login de utilizadores com verificação por email (token de ativação).
- Gestão de sessão e permissões (ex: área admin).
- Administração de produtos (inserir, editar, apagar).
- Carrinho de compras com adicionar, atualizar e remover produtos.
- Envio de emails automáticos para ativação de conta.
- Interface responsiva com design simples usando Bootstrap.

---

## Tecnologias utilizadas

- PHP (procedural)
- MySQL/MariaDB
- PHPMailer para envio de emails
- Bootstrap 5 para frontend responsivo
- HTML5, CSS3 e JavaScript

---

## Como usar

1. Importe o ficheiro `24198_Loja.sql` na sua base de dados MySQL para criar as tabelas e dados iniciais.

2. Configure o ficheiro `api/db.php` para ligar à sua base de dados (host, username, password, dbname).

3. Configure as credenciais de email no `api/email.php` para envio de emails com PHPMailer.

4. Coloque o projeto num servidor local (ex: XAMPP, WAMP) ou servidor remoto com suporte PHP.

5. Acesse `index.php` no navegador para começar a usar o site.

---

## Considerações

- É recomendado utilizar HTTPS para proteger dados sensíveis.
- As passwords são guardadas de forma segura com hashing bcrypt.
- O sistema prevê ativação de conta por email para validar utilizadores.




