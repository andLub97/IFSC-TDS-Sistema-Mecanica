<?php

function validaDadosOperacao($registro)
{
    $erros = [];

    if (!filter_var($registro->descricao_operacao, FILTER_SANITIZE_STRING)) {
        $erros["descricao_operacao"] =  "Descrição: Campo vazio e ou informação inválida!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}
