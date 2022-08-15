<?php
require_once("valida_acesso.php");
?>
<?php
require_once("eletrodo_crud.php");
require_once("operacao_crud.php");

if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    try {
        $erros = [];
        $id = filter_input(INPUT_POST, "id_ponto", FILTER_VALIDATE_INT);
        $pagina = filter_input(INPUT_POST, "pagina_ponto", FILTER_VALIDATE_INT);
        $texto_busca = filter_input(INPUT_POST, "texto_busca_ponto", FILTER_SANITIZE_STRING);

        $sql = "select * from ponto where id = ?";

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
                    <h4>Visualizar Ponto</h4>
                </div>
                <div class="col-md-3 d-flex justify-content-center">
                </div>
                <div class="col-md-5 d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" title="Home" id="home_index_ponto"><i class="fas fa-home"></i>
                                    <span>Home</span></a></li>
                            <li class="breadcrumb-item"><a href="#" title="Ponto" id="ponto_index"><i class="fas fa-map-marker-alt"></i> <span>Ponto</span></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Visualizar</li>
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
            <hr>
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="tab_ponto" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="dadostab_ponto" data-bs-toggle="tab" data-bs-target="#dados_ponto" type="button" role="tab" aria-controls="dados_ponto" aria-selected="true">Dados</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complementotab_ponto" data-bs-toggle="tab" data-bs-target="#complemento_ponto" type="button" role="tab" aria-controls="complemento_ponto" aria-selected="false">Complemento</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tabdados_ponto">
                        <div class="tab-pane fade show active" id="dados_ponto" role="tabpanel" aria-labelledby="dados_ponto">
                            <h4>
                                <b><?= isset($resultado["id"]) ? $resultado["id"] : "" ?></b>
                            </h4>
                            <br>
                            <dl>
                                <dt>Eletrodo</dt>
                                <dd>
                                    <?= isset($resultado["eletrodo_id"]) ? buscarEletrodo($resultado["eletrodo_id"])[0]["descricao"] : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Operação</dt>
                                <dd>
                                    <?= isset($resultado["operacao_id"]) ? buscarOperacao($resultado["operacao_id"])[0]["descricao"] : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Polaridade</dt>
                                <dd>
                                    <?php
                                    if ($resultado["polaridade"] == 0) {
                                        echo "Negativa";
                                    } else {
                                        echo "Positiva";
                                    }
                                    ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="tab-pane fade" id="complemento_ponto" role="tabpanel" aria-labelledby="complemento_ponto">
                            <dl>
                                <dt>Valor Corrente</dt>
                                <dd>
                                    <?= isset($resultado["valor_corrente"]) ? number_format($resultado["valor_corrente"], 3, ',', '.') : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Valor Desgaste</dt>
                                <dd>
                                    <?= isset($resultado["valor_desgaste"]) ? number_format($resultado["valor_desgaste"], 3, ',', '.') : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Valor Remoção</dt>
                                <dd>
                                    <?= isset($resultado["valor_remocao"]) ? number_format($resultado["valor_remocao"], 3, ',', '.') : ""; ?>
                                </dd>
                            </dl>
                            <dl>
                                <dt>Valor Rugosidade</dt>
                                <dd>
                                    <?= isset($resultado["valor_rugosidade"]) ? number_format($resultado["valor_rugosidade"], 3, ',', '.') : ""; ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="hidden" id="pagina_ponto" name="pagina" value="<?php echo isset($pagina) ? $pagina : '' ?>" />
                    <input type="hidden" id="texto_busca_ponto" name="texto_busca_ponto" value="<?php echo isset($texto_busca) ? $texto_busca : '' ?>" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //devido ao load precisa carregar o arquivo js dessa forma
    var url = "./js/sistema/ponto.js";
    $.getScript(url);
</script>