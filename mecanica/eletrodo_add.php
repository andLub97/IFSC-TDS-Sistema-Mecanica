<?php
require_once("valida_acesso.php");
require_once("material_crud.php");
?>
<?php
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_eletrodo", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_eletrodo", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_eletrodo", FILTER_SANITIZE_STRING);

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
                    <h4>Adicionar Eletrodo</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_eletrodo"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Eletrodo" id="eletrodo_index"><i class="fas fa-bolt"></i> <span>Eletrodo</span></a></li>
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
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_eletrodo">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_eletrodo"></button>
                <p id="div_mensagem_registro_texto_eletrodo"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="eletrodo_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_eletrodo" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_eletrodo" data-bs-toggle="tab" data-bs-target="#dados_eletrodo" type="button" role="tab" aria-controls="dados_eletrodo" aria-selected="true">Dados</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_eletrodo">
                        <div class="tab-pane fade show active" id="dados_eletrodo" role="tabpanel" aria-labelledby="dados_eletrodo">
                            <div class="col-md-6">
                                <label for="material_id_eletrodo" class="form-label">Material</label><select name="material_id_eletrodo" id="material_id_eletrodo" class="form-select">
                                    <?php
                                    $materiais = listarMaterial();
                                    foreach ($materiais as $material) {
                                        echo "<option value='" . $material["id"] . "'>" . $material["descricao"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="descricao" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="descricao_eletrodo" name="descricao_eletrodo" maxlength="50" autofocus>
                            </div>
                            <input type="hidden" id="id_eletrodo" value="<?php echo isset($id) ? $id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_eletrodo">Salvar</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_eletrodo">Limpar</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_eletrodo" name="pagina_eletrodo" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_eletrodo" name="texto_busca_eletrodo" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_eletrodo" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_eletrodo">Pergunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja salvar o registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_eletrodo">Sim</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/eletrodo.js";
    $.getScript(url);
</script>