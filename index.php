<?php
// Inclui o arquivo que contém funções de autenticação
require 'api/auth.php';

// Inicia a sessão para controlar o usuário logado
session_start();

// Verifica se o usuário está logado, senão redireciona para a página de login
if(!isset($_SESSION["user"])){
    header("Location: views/login.php");
    exit();
}

// Inclui o arquivo que contém a conexão com o banco de dados
require 'api/db.php';

// Obtém o parâmetro 'search' da URL, protege contra SQL Injection com real_escape_string
$search = isset($_GET['search']) ? $con->real_escape_string($_GET['search']) : '';

// Monta a query SQL para buscar produtos
$sql = "SELECT id, nome, descricao, preco, imagem FROM produto";

// Se foi feita uma busca, adiciona filtro na query para nome ou descrição contendo o termo
if ($search !== '') {
    $sql .= " WHERE nome LIKE '%$search%' OR descricao LIKE '%$search%'";
}

// Executa a query no banco de dados
$result = $con->query($sql);

// Inicializa array para armazenar os produtos retornados
$produtos = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $produtos[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SeaDreams | Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background:  #ffffff;
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            background-color: #003366 !important;
        }

        .navbar-brand {
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #ffd700 !important;
        }

        .nav-link {
            color: #cce6ff !important;
        }

        .nav-link:hover {
            color: #ffd700 !important;
        }

        .container {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        form input.form-control {
            border-radius: 0.5rem;
            border: none;
            box-shadow: none;
            background-color:rgba(0, 116, 162, 0.24);
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    
        }

        form input.form-control:focus {
            box-shadow: 0 0 0 0.25rem #005c85;
            border-color: #005c85;
        }

        button.btn-primary {
            background-color: #0074a2;
            border: none;
            border-radius: 0.5rem;
        }

        button.btn-primary:hover {
            background-color: #005c85;
        }

        /* Cards */
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;
            color: #001f3f;
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .card-title {
            font-weight: 700;
            font-family: 'Georgia', serif;
            color: #003366;
        }

        .text-success {
            color: #0074a2 !important;
            font-weight: 700;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px #000;
        }

        .btn-primary {
            background-color: #0074a2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #005c85;
        }

        .card-img-top {
    height: 180px;         /* altura fixa */
    width: 100%;           /* largura total do card */
    object-fit: contain;   /* redimensiona mantendo a proporção, sem cortar */
    background-color: #f0f0f0; /* opcional, cor de fundo para as áreas vazias */
    border-top-left-radius: 1rem;
    border-top-right-radius: 1rem;
        }

        .card {
    max-height: 380px;      /* limita altura máxima do card, opcional */
    overflow: hidden;       /* esconde o conteúdo que ultrapassar a altura */}

        /* Form de busca */
        .search-row {
            margin-bottom: 2rem;
        }

        
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="brand-logo">
            <div class="logo-icon">⚓ SeaDreams </div>
            
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if(isAdmin()){ ?>
                    <li class="nav-item">
                        <a class="nav-link" href="views/areaadmin.php">Área de administração</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="views/logout.php">Logout</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="views/cart.php" title="Carrinho">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16" style="margin-right: 4px;">
                            <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zm3.14 4l1.25 6.5h7.22l1.25-6.5H3.14zM5.5 16a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <form class="row search-row" method="get" action="">
        <div class="col-md-10">
            <input type="text" class="form-control" name="search" placeholder="Pesquisar produtos..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </form>

    <div class="row g-4">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <?php
                    if (!empty($produto['imagem'])) {
                        $imgData = base64_encode($produto['imagem']);
                        $src = 'data:image/jpeg;base64,' . $imgData;
                    } else {
                        $src = 'https://via.placeholder.com/300x180?text=Sem+Imagem';
                    }
                    ?>
                    <img src="<?php echo $src; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <div class="mt-auto">
                            <strong class="text-success">€<?php echo number_format($produto['preco'], 2, ',', '.'); ?></strong>
                            <form method="post" action="api/add_to_cart.php" class="mt-3 d-flex align-items-center gap-2">
                                <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                                <input type="number" name="quantidade" value="1" min="1" class="for m-control form-control-sm" style="width: 70px;">
                                <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>