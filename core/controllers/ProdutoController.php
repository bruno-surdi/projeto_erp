<?php
declare(strict_types=1);

namespace core\controllers;

use core\models\Produto;

class ProdutoController extends Controller
{
    private Produto $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }
    public function index()
    {
//        $this->view('produto_form');
        $produtos = $this->produtoModel->Todos();
        $this->view('produto_list', ['produtos' => $produtos]);
    }

    public function criar()
    {
        $this->view('produto_form');
    }
    public function salvar()
    {
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $variacoes = $_POST['variacoes'];

        $this->produtoModel->salvar($nome, $preco, $variacoes);
        header("Location: index.php?c=Produto&a=index");
    }

    public function editar()
    {
        $id = (int) $_GET['id'];
        $produto = $this->produtoModel->buscarPorId($id);

        $this->view('produto_form', ['produto' => $produto]);
    }

    public function atualizar()
    {
        $id = (int) $_POST['id'];
        $nome = $_POST['nome'];
        $preco = $_POST['preco'];
        $variacoes = $_POST['variacoes'];

        $this->produtoModel->atualizar($id, $nome, $preco, $variacoes);
        header("Location: index.php?c=Produto&a=index");
    }

    public function remover()
    {
        $id = (int) $_GET['id'];
        $this->produtoModel->remover($id);
        header("Location: index.php?c=Produto&a=index");
    }
}
