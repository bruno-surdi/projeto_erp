<?php

declare(strict_types=1);

namespace core\helpers;


function buscarCep($cep) {
    $cep = preg_replace('/[^0-9]/', '', $cep);
    $res = file_get_contents("https://viacep.com.br/ws/$cep/json/");
    return json_decode($res, true);
}