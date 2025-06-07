<?php

require '../api/auth.php';

session_start();

if(!isset($_SESSION["user"])){
    header("Location: views/login.php");
    exit();
}

require '../api/db.php';


$sql = $con->prepare("SELECT p.id, p.nome, p.descricao, p.preco, p.imagem, c.quantidade FROM produto p JOIN Carrinho c ON p.id = c.produtoId WHERE c.userId = ?");
$sql->bind_param("i", $_SESSION["user"]["id"]);
$sql->execute();
$result = $sql->get_result();
echo $result->num_rows;

$PAYPAL_CLIENT_ID = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Carrinho de compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
        }

        h2 {
            font-weight: 700;
            color: #0074a2;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .cart-item {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px 25px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: box-shadow 0.3s ease;
        }
        .cart-item:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .cart-item img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
            border: 1px solid #ddd;
        }

        .flex-grow-1 {
            flex-grow: 1;
        }

        h5 {
            font-weight: 700;
            color: #004a75;
            margin-bottom: 6px;
        }

        .text-muted {
            font-size: 0.9rem;
            color: #666 !important;
            margin-bottom: 8px;
        }

        .fw-bold {
            font-size: 1.1rem;
            color: #0074a2;
            margin-bottom: 12px;
        }

        .cart-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cart-actions form {
            margin-bottom: 0;
        }

        input[type="number"] {
            width: 80px;
            border-radius: 6px;
            border: 1px solid #ccc;
            padding: 4px 8px;
            font-size: 0.9rem;
        }

        button.btn-primary.btn-sm {
            background-color: #0074a2;
            border: none;
            transition: background-color 0.3s ease;
        }

        button.btn-primary.btn-sm:hover {
            background-color: #005c85;
        }

        button.btn-danger.btn-sm {
            background-color: #d9534f;
            border: none;
            transition: background-color 0.3s ease;
        }

        button.btn-danger.btn-sm:hover {
            background-color: #b52b27;
        }

        .ms-auto.text-center {
            min-width: 130px;
            text-align: center;
        }

        .badge.bg-secondary {
            background-color: #6c757d !important;
            font-size: 1rem;
            padding: 8px 12px;
            border-radius: 10px;
        }

        .d-flex.justify-content-end.mt-4 h4 {
            font-weight: 700;
            color: #006699;
        }

        .badge.bg-success {
            background-color: #28a745 !important;
            font-size: 1.2rem;
            padding: 8px 14px;
            border-radius: 12px;
        }

        .alert-info {
            font-size: 1.1rem;
            text-align: center;
            background-color: #d1ecf1 !important;
            color: #0c5460 !important;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        #paypal-button-container {
            margin-top: 30px;
        }

        .d-flex.justify-content-center {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Carrinho de Compras</h2>
        <?php if ($result->num_rows === 0): ?>
            <div class="alert alert-info">O seu carrinho está vazio.</div>
        <?php endif; ?>
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-12 cart-item">
                    <?php 
                        $image = base64_encode($row['imagem']);
                        $src = 'data:image/jpeg;base64,' . $image;
                    ?>
                    <div>
                        <img src="<?php echo $src ?>" alt="Imagem">
                    </div>
                    <div class="flex-grow-1">
                        <h5><?php echo htmlspecialchars($row['nome']); ?></h5>
                        <p class="mb-1 text-muted"><?php echo htmlspecialchars($row['descricao']); ?></p>
                        <div class="fw-bold mb-2"><?php echo number_format($row['preco'], 2, ',', '.'); ?> €</div>
                        <div class="cart-actions">
                            <form action="../api/update_cart.php" method="post" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="produtoId" value="<?php echo $row['id']; ?>">
                                <input type="number" name="quantidade" value="<?php echo $row['quantidade']; ?>" min="1" class="form-control form-control-sm" style="width: 70px;">
                                <button type="submit" class="btn btn-primary btn-sm">Atualizar</button>
                            </form>
                            <form action="../api/delete_cart.php" method="post">
                                <input type="hidden" name="produtoId" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                            </form>
                        </div>
                    </div>
                    <div class="ms-auto text-center">
                        <span class="badge bg-secondary fs-6">Subtotal: <?php echo number_format($row["quantidade"]*$row['preco'], 2, ',', '.'); ?> €</span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <?php
        // Reset result pointer and calculate total
        $result->data_seek(0);
        $total = 0;
        while($row = $result->fetch_assoc()) {
            $total += $row["quantidade"] * $row["preco"];
        }
        ?>
        <?php if ($total > 0): ?>
            <div class="d-flex justify-content-end mt-4">
                <h4>Total do Pedido: <span class="badge bg-success"><?php echo number_format($total, 2, ',', '.'); ?> €</span></h4>
            </div>
        <?php endif; ?>
    </div>
    <div class="d-flex justify-content-center">
        <div id="paypal-button-container" class="w-50"></div>
    </div>

    <script src=<?php echo "https://www.paypal.com/sdk/js?client-id=$PAYPAL_CLIENT_ID&currency=EUR" ?>></script>
    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '<?php echo $total; ?>'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    window.location.href = "finish.php";
                });
            },
            onError: function(err) {
                console.error('Erro no pagamento:', err);
                alert('Ocorreu um erro durante o pagamento. Tente novamente.');
            }
        }).render('#paypal-button-container');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>