<?php
namespace core\models;

use Config\Database;
use PDO;

class Produto {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function salvar($nome, $preco, $variacoes) {

        $stmt = $this->db->prepare("INSERT INTO produtos (nome, preco) VALUES (?, ?)");
        $stmt->execute([$nome, $preco]);
        $produto_id = $this->db->lastInsertId();

        foreach ($variacoes['nome'] as $i => $nomeVar) {
            $stmtVar = $this->db->prepare("INSERT INTO variacoes (produto_id, nome) VALUES (?, ?)");
            $stmtVar->execute([$produto_id, $nomeVar]);
            $var_id = $this->db->lastInsertId();

            $stmtEst = $this->db->prepare("INSERT INTO estoques (variacao_id, quantidade) VALUES (?, ?)");
            $stmtEst->execute([$var_id, $variacoes['quantidade'][$i]]);
        }
    }
    public function todos() {
        $stmt = $this->db->query("SELECT * FROM produtos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function remover(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
    }
    public function buscarPorId(int $id): array
    {
        $stmt = $this->db->prepare("
        SELECT * FROM produtos WHERE id = ?
    ");
        $stmt->execute([$id]);
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->db->prepare("
        SELECT v.id, v.nome, e.quantidade 
        FROM variacoes v
        JOIN estoques e ON e.variacao_id = v.id
        WHERE v.produto_id = ?
    ");
        $stmt->execute([$id]);
        $variacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $produto['variacoes'] = $variacoes;
        return $produto;
    }

    public function atualizar(int $id, string $nome, $preco, array $variacoes)
    {
        $stmt = $this->db->prepare('UPDATE produtos SET nome = ?, preco = ? WHERE id = ?');
        $stmt->execute([$nome, $preco, $id]);

        foreach ($variacoes['id'] as $i => $varId) {
            $stmtVar = $this->db->prepare("UPDATE variacoes SET nome = ? WHERE id = ?");
            $stmtVar->execute([$variacoes['nome'][$i], $varId]);

            $stmtEst = $this->db->prepare("UPDATE estoques SET quantidade = ? WHERE variacao_id = ?");
            $stmtEst->execute([$variacoes['quantidade'][$i], $varId]);
        }
    }
    public function buscarVariacaoComProduto($variacao_id = 3)
    {
        $stmt = $this->db->prepare("
        SELECT v.id as variacao_id, v.nome as variacao_nome, p.nome, p.preco
        FROM variacoes v
        JOIN produtos p ON p.id = v.produto_id
        WHERE v.id = ?
    ");
        $stmt->execute([$variacao_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}