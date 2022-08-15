<?php

function validaDadosEletrodo($registro)
{
    $erros = [];

    if (!filter_var($registro->descricao_eletrodo, FILTER_SANITIZE_STRING)) {
        $erros["descricao_eletrodo"] =  "Descrição: Campo vazio e ou informação inválida!";
    }

    if (!filter_var($registro->material_id_eletrodo, FILTER_SANITIZE_STRING)) {
        $erros["material_id_eletrodo"] =  "Material: Campo vazio e ou informação inválida!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}
