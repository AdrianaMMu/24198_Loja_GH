<!-- Página com CSS/Bootstrap com um formulário para o login -->

<?php

session_start();

require "../api/auth.php"; // Importa funções relacionadas à autenticação

$error_msg = false;  // Controle para mostrar mensagem de erro
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica se o formulário foi submetido

    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) { // Valida se campos não estão vazios
        $error_msg = true;
        $msg = "Preencha todos os campos";
    } else {

        if (login($username, $password)) { // Chama a função login (de auth.php) para autenticar
            header("Location: ../index.php"); // Se login ok, redireciona para página inicial
        } else {
            $error_msg = true;
            $msg = "O login falhou. Verifique o seu username e password.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SeaDreams | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: linear-gradient(to bottom, #001f3f, #0074a2);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;
            color: #001f3f;
        }

        .card h1 {
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #003366;
        }

        .btn-primary {
            background-color: #0074a2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #005c85;
        }

        .btn-outline-secondary {
            border-color: #0074a2;
            color: #0074a2;
        }

        .btn-outline-secondary:hover {
            background-color: #0074a2;
            color: white;
        }

        .brand-logo {
            font-size: 2rem;
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #ffffff;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px #000;
        }

        .form-label {
            font-weight: 600;
        }

        .logo-icon {
            font-size: 2.5rem;
            color: #ffd700;
        }
    </style>
</head>

<body>

    <?php
    if ($error_msg) {
        echo "<div class='position-fixed top-0 end-0 p-3' style='z-index: 1050;'>
                  <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                      $msg
                      <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>
              </div>";
    }
    ?>

    <div class="container">
        <div class="brand-logo">
            <div class="logo-icon">⚓</div>
            SeaDreams
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="h4 text-center mb-4">Login</h1>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid mb-2">
                                <input type="submit" value="Login" class="btn btn-primary">
                            </div>
                            <div class="d-grid mb-2">
                            <a href="../views/registo.php" class="btn btn-outline-secondary">Registar</a>
                        </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>