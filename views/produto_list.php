<?php $produtos = $data['produtos'] ?? []; ?>

<h2>Produtos Cadastrados</h2>

<a href="index.php?c=Produto&a=criar" class="btn btn-success mb-3">Novo Produto</a>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Preço</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $produto): ?>
        <tr>
            <td><?= $produto['id'] ?></td>
            <td><?= $produto['nome'] ?></td>
            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
            <td>
                <a href="index.php?c=Produto&a=editar&id=<?= $produto['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="index.php?c=Produto&a=remover&id=<?= $produto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir este produto?')">Remover</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
