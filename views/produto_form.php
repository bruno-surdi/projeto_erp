<?php $produto = $data['produto'] ?? null; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $produto ? 'Editar' : 'Cadastrar' ?> Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

<h2><?= $produto ? 'Editar' : 'Cadastrar' ?> Produto</h2>

<form method="POST" action="index.php?c=Produto&a=<?= $produto ? 'atualizar' : 'salvar' ?>">
    <?php if ($produto): ?>
        <input type="hidden" name="id" value="<?= $produto['id'] ?>">
    <?php endif; ?>

    <div class="mb-2">
        <label>Nome:</label>
        <input name="nome" class="form-control" value="<?= $produto['nome'] ?? '' ?>" required>
    </div>

    <div class="mb-3">
        <label>Preço:</label>
        <input name="preco" type="number" step="0.01" class="form-control" value="<?= $produto['preco'] ?? '' ?>" required>
    </div>

    <h4>Variações</h4>

    <div id="variacoes">
        <?php if (!empty($produto['variacoes'])): ?>
            <?php foreach ($produto['variacoes'] as $i => $v): ?>
                <input type="hidden" name="variacoes[id][]" value="<?= $v['id'] ?>">
                <div class="row mb-2">
                    <div class="col">
                        <input name="variacoes[nome][]" class="form-control" placeholder="Nome da variação" value="<?= $v['nome'] ?>">
                    </div>
                    <div class="col">
                        <input name="variacoes[quantidade][]" type="number" class="form-control" placeholder="Estoque" value="<?= $v['quantidade'] ?>">
                    </div>
<!--                    <div class="col">-->
<!--                        <form method="POST" action="index.php?c=Pedido&a=adicionar" class="d-flex">-->
<!--                            <input type="hidden" name="variacao_id" value="--><?php //= $v['id'] ?><!--">-->
<!--                            <input type="number" name="quantidade" value="1" min="1" class="form-control me-2">-->
<!--                            <button class="btn btn-success" type="submit">Comprar</button>-->
<!--                        </form>-->
<!--                    </div>-->
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Campo para novo cadastro -->
            <div class="row mb-2">
                <div class="col">
                    <input name="variacoes[nome][]" class="form-control" placeholder="Nome da variação">
                </div>
                <div class="col">
                    <input name="variacoes[quantidade][]" type="number" class="form-control" placeholder="Estoque">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary mt-2">Salvar Produto</button>
</form>
<?php foreach ($produto['variacoes'] as $v): ?>
    <form method="POST" action="index.php?c=Pedido&a=adicionar" class="d-flex mb-2">
        <input type="hidden" name="variacao_id" value="<?= $v['id'] ?>">
        <input type="number" name="quantidade" value="1" min="1" class="form-control me-2">
        <button class="btn btn-success" type="submit">Comprar <?= htmlspecialchars($v['nome']) ?></button>
    </form>
<?php endforeach; ?>

</body>
</html>
