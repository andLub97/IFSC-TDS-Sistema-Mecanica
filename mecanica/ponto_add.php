<?php
require_once("valida_acesso.php");
?>
<?php
require_once("eletrodo_crud.php");
require_once("operacao_crud.php");

//a listagem de categoria é geral poderia ser filtrado por status
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_ponto", FILTER_VALIDATE_INT);
        $usuario_id = isset($_SESSION["usuario_id"]) ?  $_SESSION["usuario_id"] : 0;
        $pagina = filter_input(INPUT_POST, "pagina_ponto", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_ponto", FILTER_SANITIZE_STRING);

        if (!isset($pagina)) {
            $pagina = 1;
        }
    } catch (Exception $e) {
        $erros[] = $e->getMessage();
        $_SESSION["erros"] = $erros;
    }
}
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Adicionar Ponto</h4>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_ponto"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Ponto" id="ponto_index"><i class="fas fa-map-marker-alt"></i> <span>Ponto</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Adicionar</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <hr>
            <?php
            if (isset($_SESSION["erros"])) {
                echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                echo "<button type='button' class='btn-close btn-sm' data-bs-dismiss='alert'
                aria-label='Close'></button>";
                foreach ($_SESSION["erros"] as $chave => $valor) {
                    echo $valor . "<br>";
                }
                echo "</div>";
            }
            unset($_SESSION["erros"]);
            ?>
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_ponto">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_ponto"></button>
                <p id="div_mensagem_registro_texto_ponto"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="ponto_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_ponto" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_ponto" data-bs-toggle="tab" data-bs-target="#dados_ponto" type="button" role="tab" aria-controls="dados_ponto" aria-selected="true">Dados</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complementotab_ponto" data-bs-toggle="tab" data-bs-target="#complemento_ponto" type="button" role="tab" aria-controls="complemento_ponto" aria-selected="false">Complemento</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_ponto">
                        <div class="tab-pane fade show active" id="dados_ponto" role="tabpanel" aria-labelledby="dados_ponto">
                            <div class="col-md-6">
                                <label for="eletrodo_ponto" class="form-label">Eletrodo</label><select name="eletrodo_id_ponto" id="eletrodo_id_ponto" class="form-select">
                                    <?php
                                    $eletrodos = listarEletrodo();
                                    foreach ($eletrodos as $eletrodo) {
                                        echo "<option value='" . $eletrodo["id"] . "'>" . $eletrodo["descricao"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="operacao_ponto" class="form-label">Operação</label><select name="operacao_id_ponto" id="operacao_id_ponto" class="form-select">
                                    <?php
                                    $operacoes = listarOperacao();
                                    foreach ($operacoes as $operacao) {
                                        echo "<option value='" . $operacao["id"] . "'>" . $operacao["descricao"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="eletrodo_ponto" class="form-label">Polaridade</label><select name="polaridade_ponto" id="polaridade_ponto" class="form-select">
                                    <option value="0">Negativa</option>
                                    <option value="1">Positiva</option>
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="complemento_ponto" role="tabpanel" aria-labelledby="complemento_ponto">
                            <div class="col-md-6">
                                <label for="valor_corrente_ponto" class="form-label">Valor Corrente</label>
                                <input type="text" class="form-control" id="valor_corrente_ponto" name="valor_corrente_ponto" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="valor_desgaste_ponto" class="form-label">Valor Desgaste</label>
                                <input type="text" class="form-control" id="valor_desgaste_ponto" name="valor_desgaste_ponto" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="valor_remocao_ponto" class="form-label">Valor Remoção</label>
                                <input type="text" class="form-control" id="valor_remocao_ponto" name="valor_remocao_ponto" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="valor_rugosidade_ponto" class="form-label">Valor Rugosidade</label>
                                <input type="text" class="form-control" id="valor_rugosidade_ponto" name="valor_rugosidade_ponto" maxlength="100">
                            </div>

                            <input type="hidden" id="id_ponto" name="id_ponto" value="<?php echo isset($id) ? $id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_ponto">Salvar</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_ponto">Limpar</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_ponto" name="pagina_ponto" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_ponto" name="texto_busca_ponto" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_ponto" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_ponto">Pergunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja salvar o registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_ponto">Sim</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/ponto.js";
    $.getScript(url);
</script>