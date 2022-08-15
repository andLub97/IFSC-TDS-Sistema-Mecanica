<?php

function validaDadosPonto($registro)
{
    $erros = [];

    //retirar a máscara nessa sequência
    $registro->valor_corrente_ponto = str_replace(".", "", $registro->valor_corrente_ponto);
    $registro->valor_corrente_ponto = str_replace(",", ".", $registro->valor_corrente_ponto);
    if (!filter_var($registro->valor_corrente_ponto, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_corrente_ponto"] =  "Valor Corrente: Campo vazio e ou informação inválida!";
    }

    //retirar a máscara nessa sequência
    $registro->valor_desgaste_ponto = str_replace(".", "", $registro->valor_desgaste_ponto);
    $registro->valor_desgaste_ponto = str_replace(",", ".", $registro->valor_desgaste_ponto);
    if (!filter_var($registro->valor_desgaste_ponto, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_desgaste_ponto"] =  "Valor Desgaste: Campo vazio e ou informação inválida!";
    }

    //retirar a máscara nessa sequência
    $registro->valor_remocao_ponto = str_replace(".", "", $registro->valor_remocao_ponto);
    $registro->valor_remocao_ponto = str_replace(",", ".", $registro->valor_remocao_ponto);
    if (!filter_var($registro->valor_remocao_ponto, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_remocao_ponto"] =  "Valor Remoção: Campo vazio e ou informação inválida!";
    }

    //retirar a máscara nessa sequência
    $registro->valor_rugosidade_ponto = str_replace(".", "", $registro->valor_rugosidade_ponto);
    $registro->valor_rugosidade_ponto = str_replace(",", ".", $registro->valor_rugosidade_ponto);
    if (!filter_var($registro->valor_rugosidade_ponto, FILTER_VALIDATE_FLOAT)) {
        $erros["valor_rugosidade_ponto"] =  "Valor Rugosidade: Campo vazio e ou informação inválida!";
    }

    if (count($erros) > 0) {
        $_SESSION["erros"] = $erros;
        throw new Exception("Erro nas informações!");
    }
}
