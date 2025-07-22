<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h3>Carrinho de Compras</h3>

<?php if (empty($data['itens'])): ?>
    <p>Carrinho vazio.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Variação</th>
            <th>Quantidade</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($data['itens'] as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['nome']) ?></td>
                <td><?= htmlspecialchars($item['variacao_nome']) ?></td>
                <td><?= (int)$item['quantidade'] ?></td>
                <td>R$<?= number_format($item['total'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="mt-3">
        <p><strong>Subtotal:</strong> R$<?= number_format($data['subtotal'], 2, ',', '.') ?></p>
        <p><strong>Frete:</strong> R$<?= number_format($data['frete'], 2, ',', '.') ?></p>
        <p><strong>Total:</strong> R$<?= number_format($data['total'], 2, ',', '.') ?></p>
    </div>

    <hr>

    <h4>Verificar Endereço por CEP</h4>
    <form method="POST" action="index.php?c=Pedido&a=buscarCep" class="d-flex gap-2 mb-3">
        <input type="text" name="cep" class="form-control" placeholder="Digite o CEP" value="<?= htmlspecialchars($data['cep'] ?? '') ?>">
        <button class="btn btn-info">Buscar CEP</button>
    </form>

    <?php if (!empty($data['endereco'])): ?>
        <div class="alert alert-success">
            <h5>Endereço encontrado:</h5>
            <p><strong>CEP:</strong> <?= htmlspecialchars($data['endereco']['cep']) ?></p>
            <p><strong>Logradouro:</strong> <?= htmlspecialchars($data['endereco']['logradouro']) ?></p>
            <p><strong>Complemento:</strong> <?= htmlspecialchars($data['endereco']['complemento']) ?></p>
            <p><strong>Bairro:</strong> <?= htmlspecialchars($data['endereco']['bairro']) ?></p>
            <p><strong>Cidade:</strong> <?= htmlspecialchars($data['endereco']['localidade']) ?> - <?= htmlspecialchars($data['endereco']['uf']) ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($data['endereco']['estado']) ?></p>
        </div>
    <?php elseif (isset($data['cep'])): ?>
        <div class="alert alert-warning">
            Endereço não encontrado para o CEP <?= htmlspecialchars($data['cep']) ?>.
        </div>
    <?php endif; ?>

<?php endif; ?>

<a href="index.php?c=Produto&a=index" class="btn btn-secondary mt-3">Voltar</a>

</body>
</html>
