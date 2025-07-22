<?php
namespace core\controllers;

use core\models\Produto;
use function core\helpers\buscarCep;

class PedidoController extends Controller
{

    private Produto $produtoModel;

    public function __construct()
    {
        session_start();
        $this->produtoModel = new Produto();
    }
    public function adicionar()
    {

        session_start();
        $id = (int) $_POST['variacao_id'];
        $qtd = (int) $_POST['quantidade'];

        $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + $qtd;
        header("Location: index.php?c=Pedido&a=verCarrinho");
    }

    public function verCarrinho()
    {
        $carrinho = $_SESSION['carrinho'] ?? [];
        $itens = [];
        $subtotal = 0;
        foreach ($carrinho as $varId => $qtd) {
            $dados = $this->produtoModel->buscarVariacaoComProduto($varId);

            $dados['quantidade'] = $qtd;
            $dados['total'] = $qtd * $dados['preco'];
            $subtotal += $dados['total'];
            $itens[] = $dados;
        }

        $frete = $this->calcularFrete($subtotal);

        $this->view('carrinho_form', [
            'itens' => $itens,
            'subtotal' => $subtotal,
            'frete' => $frete,
            'total' => $subtotal + $frete,
        ]);
    }

    private function calcularFrete($subtotal): float
    {
        if ($subtotal > 200) return 0;
        if ($subtotal >= 52 && $subtotal <= 166.59) return 15;
        return 20;
    }

    public function buscarCep()
    {
        session_start();
        $cep = $_POST['cep'] ?? '89814045';
        $endereco = null;

        if ($cep) {
            $json = buscarCep($cep); // sua função já retorna JSON string
            $endereco = "Endereço: {$json['logradouro']}, {$json['bairro']} - {$json['localidade']}";
        }
        // Busque o carrinho normalmente para passar para a view
        $carrinho = $_SESSION['carrinho'] ?? [];
        $itens = [];
        $subtotal = 0;
        foreach ($carrinho as $varId => $qtd) {
            $dados = $this->produtoModel->buscarVariacaoComProduto($varId);
            $dados['quantidade'] = $qtd;
            $dados['total'] = $qtd * $dados['preco'];
            $subtotal += $dados['total'];
            $itens[] = $dados;
        }

        $frete = $this->calcularFrete($subtotal);

        $this->view('carrinho_form', [
            'itens' => $itens,
            'subtotal' => $subtotal,
            'frete' => $frete,
            'total' => $subtotal + $frete,
            'cep' => $cep,
            'endereco' => $endereco,
        ]);
    }
}
