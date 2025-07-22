<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar CEP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="container mt-4">

<h3>Verificação de CEP (ViaCEP)</h3>

<input type="text" id="cep" placeholder="Digite o CEP" maxlength="9">
<button id="buscarCep">Buscar</button>

<div id="resultado" class="mt-3"></div>

<script>
    $('#buscarCep').on('click', function () {
        console.log('111111')
        const cep = $('#cep').val().replace(/\D/g, '');
        if (cep.length !== 8) {
            alert('CEP inválido!');
            return;
        }

        $.get('https://viacep.com.br/ws/' + cep + '/json/', function (data) {
            if (data.erro) {
                $('#resultado').html('<p>CEP não encontrado.</p>');
            } else {
                $('#resultado').html(`
                <p><strong>Rua:</strong> ${data.logradouro}</p>
                <p><strong>Bairro:</strong> ${data.bairro}</p>
                <p><strong>Cidade:</strong> ${data.localidade}</p>
                <p><strong>UF:</strong> ${data.uf}</p>
            `);
            }
        });
    });
</script>

</body>
</html>
