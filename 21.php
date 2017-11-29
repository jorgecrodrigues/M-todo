<?php
/**
 * Classe para fazer a validação e a conversão de uma string para
 * uma expressão matemática válida para a linguagem.
 *
 * Crédito:
 * EvalMath - PHP Class to safely evaluate math expressions
 * Copyright (C) 2005 Miles Kaufmann <http://www.twmagic.com/>
 */
include_once('evalmath.class.php');
$Math = new EvalMath;

/**
 * Módulo de um número
 *
 * @param  int|float|double $num
 * @return int|float|double
 */
function mod($num)
{
    return $num < 0 ? $num * (-1) : $num;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Métodos computacionais</title>
    <!-- Bulma 0.6.1 -->
    <link rel="stylesheet" href="bulma-0.6.1/css/bulma.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css"/>
</head>
<body>
<?php include_once "nav.php"; ?>

<div class="container">
    <h2 class="is-size-2">Método da bisseção</h2>
    <br/>
    <br/>
    <form>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Valor de (A):</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="a" value="1" placeholder="Ex: 1" required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Valor de (B):</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="b" value="2" placeholder="Ex: 2" required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-7">
                <div class="field">
                    <label class="label">A função:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-warning" type="text" name="fn" value="x^3-x-2" placeholder="x^3-x-2"
                               required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-warning">Obrigatório</p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Erro:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-danger" type="text" name="error" value="10^2" placeholder="Ex: 10^2"
                               required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-danger">Padrão 10²</p>
                </div>
            </div>
        </div>

        <div class="field is-grouped">
            <div class="control">
                <button class="button is-primary">Calcular</button>
            </div>
        </div>
    </form>
    <br/>
    <br/>
    <!-- Verifica se todos os parêmetros necessários estão presentes. Obs: Não é feito nenhum tipo de validação dos valores. -->
    <?php if ($_GET && isset($_GET['a']) && isset($_GET['b']) && isset($_GET['fn']) && isset($_GET['error'])): ?>
        <div class="columns">
            <div class="column is-4">
                <h4 class="is-size-4"></h4>
                <!-- Converte o valores de a, b, e n para inteiros -->
                <?php $a = (int)$_GET['a']; ?>
                <?php $b = (int)$_GET['b']; ?>
                <!-- Obtém os as funções -->
                <?php $fn = $_GET['fn']; // Função ?>
                <!-- Obtém o valor para o erro, sedo inversamente proporcional -->
                <?php $error = $Math->evaluate('1/' . $_GET['error']); ?>

                <!-- O valor de A -->
                O valor de A: <b class="has-text-success"><?= $a; ?></b>
                <br/>
                <!-- O valor de B -->
                O valor de B: <b class="has-text-success"><?= $b; ?></b>
                <br/>
                <!-- A função. -->
                A função: <b class="has-text-success"><?= $fn; ?></b>
                <br/>
                <!-- O erro -->
                Erro: <b class="has-text-danger"><?= $error; ?></b>
                <br/>
                <br/>
            </div>
            <div class="column">
                <h4 class="is-size-4">Veja os valores plotados na tabela abaixo:</h4>
                <table class="table is-hoverable is-fullwidth">
                    <thead>
                    <tr>
                        <th>A</th>
                        <th>B</th>
                        <th>X</th>
                        <th>f(x)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Máximo de interações -->
                    <?php $max = 10 ?>
                    <?php while ($max): ?>
                        <!-- Decrenta o valor, máximo de interações -->
                        <?php $max-- ?>
                        <!-- O valor de X, sendo, de acordo com a fórmula, a + b / 2 -->
                        <?php $x = ($a + $b) / 2 ?>
                        <!-- O resultado da função -->
                        <?php $fx = $Math->evaluate(str_replace("x", $x, $fn)) ?>
                        <tr>
                            <td><?= $a ?></td>
                            <td><?= $b ?></td>
                            <td><?= $x ?></td>
                            <td><?= $fx ?></td>
                        </tr>
                        <!-- Se o resultado da função for menor que 0, então a = f(x) senão b = f(x) -->
                        <?php if ($fx < 0) {
                            $a = $x;
                        } else {
                            $b = $x;
                        } ?>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>