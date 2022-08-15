<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");
require_once("ponto_filtro.php");

//operações via ajax
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") === "POST") {
    if (!isset($_POST["acao"])) {
        return;
    }

    switch ($_POST["acao"]) {
        case "adicionar":
            try {
                $errosAux = "";

                $registro = new stdClass();
                $registro = json_decode($_POST['registro']);
                validaDadosPonto($registro);

                $sql = "insert into ponto(valor_corrente, valor_desgaste, valor_remocao, valor_rugosidade, polaridade, eletrodo_id, operacao_id) VALUES (?, ?, ?, ?, ?, ?, ?) ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->valor_corrente_ponto,
                    $registro->valor_desgaste_ponto,
                    $registro->valor_remocao_ponto,
                    $registro->valor_rugosidade_ponto,
                    $registro->polaridade_ponto,
                    $registro->eletrodo_id_ponto,
                    $registro->operacao_id_ponto
                ));
                print json_encode($conexao->lastInsertId());
            } catch (Exception $e) {
                if (isset($_SESSION["erros"])) {
                    foreach ($_SESSION["erros"] as $chave => $valor) {
                        $errosAux .= $valor . "<br>";
                    }
                }
                $errosAux .= $e->getMessage();
                unset($_SESSION["erros"]);
                echo "Erro: " . $errosAux . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case "editar":
            try {
                $errosAux = "";

                $registro = new stdClass();
                $registro = json_decode($_POST['registro']);
                validaDadosPonto($registro);

                $sql = "update ponto set valor_corrente = ?, valor_desgaste = ?, valor_remocao = ?, valor_rugosidade = ?, polaridade = ?, eletrodo_id = ?, operacao_id = ? where id = ? ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->valor_corrente_ponto,
                    $registro->valor_desgaste_ponto,
                    $registro->valor_remocao_ponto,
                    $registro->valor_rugosidade_ponto,
                    $registro->polaridade_ponto,
                    $registro->eletrodo_id_ponto,
                    $registro->operacao_id_ponto,
                    $registro->id_ponto
                ));
                print json_encode(1);
            } catch (Exception $e) {
                foreach ($_SESSION["erros"] as $chave => $valor) {
                    $errosAux .= $valor . "<br>";
                }
                $errosAux .= $e->getMessage();
                unset($_SESSION["erros"]);
                echo "Erro: " . $errosAux . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case "excluir":
            try {
                $registro = new stdClass();
                $registro = json_decode($_POST["registro"]);

                $sql = "delete from ponto where id = ? ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->id
                ));

                print json_encode(1);
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case 'buscar':
            try {
                $registro = new stdClass();
                $registro = json_decode($_POST["registro"]);

                $sql = "select * from ponto where id = ?";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->id
                ));

                print json_encode($pre->fetchAll(PDO::FETCH_ASSOC));
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        case 'simulador':
            try {
                $eletrodo_id = $_POST["eletrodo_id"];
                $polaridade = $_POST["polaridade"];

                $sql = "select p.id as id, m.descricao as material, e.descricao as eletrodo, o.descricao as operacao, p.polaridade
                from ponto p, material m, eletrodo e, operacao o
                where p.eletrodo_id = e.id
                and e.material_id = m.id
                and p.operacao_id = o.id
                and p.eletrodo_id = ?
                and p.polaridade = ?
                order by material, eletrodo, operacao, polaridade";

                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);

                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $eletrodo_id,
                    $polaridade
                ));

                print json_encode($pre->fetchAll(PDO::FETCH_ASSOC));
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage() . "<br>";
            } finally {
                $conexao = null;
            }
            break;
        default:
            print json_encode(0);
            return;
    }
}

//consulta sem ajax
function buscarPonto(int $id)
{
    try {
        $sql = "select * from ponto where id = ?";
        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
        $pre = $conexao->prepare($sql);
        $pre->execute(array(
            $id
        ));

        return $pre->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage() . "<br>";
    } finally {
        $conexao = null;
    }
}

//consulta sem ajax
function listarPonto()
{
    try {
        $sql = "select * from ponto order by descricao";
        $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
        $pre = $conexao->prepare($sql);
        $pre->execute();

        return $pre->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage() . "<br>";
    } finally {
        $conexao = null;
    }
}
