<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_material", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_material", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_material", FILTER_SANITIZE_STRING);

        $sql = "select * from material where id = ?";

        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);

        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $id
        ));

        $resultado = $pre->fetch(PDO::FETCH_ASSOC);
        if (!$resultado) {
            throw new Exception("Não foi possível realizar a consulta!");
        }
    } catch (Exception $e) {
        $erros[] = $e->getMessage();
        $_SESSION["erros"] = $erros;
    } finally {
        $conexao = null;
    }
}
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4 d-flex justify-content-start">
                    <h4>Editar Material</h4>
                </div>
                <div class="col-md-4 d-flex justify-content-center">
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_material"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="material" id="material_index"><i class="fas fa-box"></i> <span>Material</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Editar</li>
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
            <div class="alert alert-info alert-dismissible fade show" style="display: none;" id="div_mensagem_registro_material">
                <button type="button" class="btn-close btn-sm" aria-label="Close" id="div_mensagem_registro_botao_material"></button>
                <p id="div_mensagem_registro_texto_material"></p>
            </div>
            <hr>
            <div class="col-md-12">
                <form enctype="multipart/form-data" method="post" accept-charset="utf-8" id="material_dados" role="form" action="">
                    <ul class="nav nav-tabs" id="tab_material" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_material" data-bs-toggle="tab" data-bs-target="#dados_material" type="button" role="tab" aria-controls="dados_material" aria-selected="true">Dados</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="tabdados_material">
                        <div class="tab-pane fade show active" id="dados_material" role="tabpanel" aria-labelledby="dados_material">
                            <div class="col-md-6">
                                <label for="descricao_material" class="form-label">Descrição</label>
                                <input type="text" class="form-control" id="descricao_material" name="descricao_material" maxlength="50" value="<?php echo isset($resultado['descricao']) ? $resultado['descricao'] : ''; ?>" autofocus>
                            </div>
                            <input type="hidden" id="id_material" name="id_material" value="<?php echo isset($id) ? $id : '' ?>" />
                        </div>
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-primary" id="botao_salvar_material">Salvar</button>
                        <button type="reset" class="btn btn-secondary" id="botao_limpar_material">Limpar</button>
                    </div>
                </form>
            </div>
            <div>
                <input type="hidden" id="pagina_material" name="pagina_material" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                <input type="hidden" id="texto_busca_material" name="texto_busca_material" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
            </div>
        </div>
    </div>
</div>

<!--modal de salvar-->
<div class="modal fade" id="modal_salvar_material" tabindex="-1" aria-labelledby="logoutlabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutlabel_material">Pergunta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja salvar o registro?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal_salvar_sim_material">Sim</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<script>
     //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/material.js";
    $.getScript(url);
</script>