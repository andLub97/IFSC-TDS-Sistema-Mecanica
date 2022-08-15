<?php
require_once("valida_acesso.php");
?>
<?php
require_once("conexao.php");
require_once("eletrodo_filtro.php");

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
                validaDadosEletrodo($registro);

                $sql = "insert into eletrodo(descricao, material_id) VALUES (?, ?) ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->descricao_eletrodo,
                    $registro->material_id_eletrodo
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
                validaDadosEletrodo($registro);

                $sql = "update eletrodo set descricao = ?, material_id = ? where id = ? ";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                    $registro->descricao_eletrodo,
                    $registro->material_id_eletrodo,
                    $registro->id_eletrodo
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

                $sql = "delete from eletrodo where id = ? ";
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

                $sql = "select * from eletrodo where id = ?";
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
                $id = $_POST["id"];
                $sql = "select * from eletrodo where material_id = ? order by descricao";
                $conexao = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BANCO, USUARIO, SENHA);
                $pre = $conexao->prepare($sql);
                $pre->execute(array(
                   $id
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
function buscarEletrodo(int $id)
{
    try {
        $sql = "select * from eletrodo where id = ?";
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
function listarEletrodo()
{
    try {
        $sql = "select * from eletrodo order by descricao";
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