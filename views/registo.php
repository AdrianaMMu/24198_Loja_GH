<?php
require "../api/auth.php";
$error_msg = false;
$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["telemovel"]) && isset($_POST["nif"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) {
    //Ver se os campos estão preenchidos
    if (empty($_POST["username"])) {
        $error_msg = true;
        $msg .= "Preencha o campo username.";
    }
    if (empty($_POST["email"])) {
        $error_msg = true;
        $msg .= "Preencha o campo email.";
    }
    if (empty($_POST["telemovel"])) {
        $error_msg = true;
        $msg .= "Preencha o campo telemovel.";
    }
    if (empty($_POST["nif"])) {
        $error_msg = true;
        $msg .= "Preencha o campo nif.";
    }
    if (empty($_POST["password"])) {
        $error_msg = true;
        $msg .= "Preencha o campo password.";
    }
    if (empty($_POST["confirm_password"])) {
        $error_msg = true;
        $msg .= "Preencha o campo confirmar password.";
    }
    if ($_POST["password"] != $_POST["confirm_password"]) {
        $error_msg = true;
        $msg .= "As passwords não coincidem.";
    }

    if (!$error_msg) {
        if (registo($_POST["email"], $_POST["username"], $_POST["password"], $_POST["telemovel"], $_POST["nif"])) {
            header("Location: login.php");
        } else {
            $error_msg = true;
            $msg = "O registo falhou. Verifique os seus dados.";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SeaDreams | Registo</title>
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
            margin: 0;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            background-color: #ffffff;
            color: #001f3f;
            padding: 1.5rem;
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
            line-height: 1;
        }

        /* Ajusta largura da coluna */
        .col-md-4 {
            max-width: 400px;
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
                        <h1 class="h4 text-center mb-4">Registo</h1>
                        <form method="POST" novalidate>
                            <div class="mb-3">
                                <label for="username" class="form-label">Nome de utilizador:</label>
                                <input type="text" id="username" name="username" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="telemovel" class="form-label">Telemóvel:</label>
                                <input type="text" id="telemovel" name="telemovel" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="nif" class="form-label">NIF:</label>
                                <input type="text" id="nif" name="nif" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required />
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirmar Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required />
                            </div>
                            <div class="d-grid mb-2">
                                <button type="submit" class="btn btn-primary">Registar</button>
                            </div>
                            <div class="d-grid">
                                <a href="login.php" class="btn btn-outline-secondary">Voltar para Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opcional, para componentes interativos) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>