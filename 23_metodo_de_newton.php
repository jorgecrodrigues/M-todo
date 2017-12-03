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

/**
 * Vericica o sinal de um número;
 *
 * @param $number
 * @return int
 */
function sign($number)
{
    return ($number > 0) ? 1 : (($number < 0) ? -1 : 0);
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
    <h2 class="is-size-2">Método de Newton</h2>
    <br/>
    <br/>
    <form>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Valor de (X):</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="x" value="2" placeholder="Ex: 2" required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">A função:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-warning" type="text" name="fn" value="x^2+7*x-6" placeholder="x^2+7*x-6"
                               required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-warning">Obrigatório</p>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Derivada da função:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-warning" type="text" name="dd" value="2*x+7" placeholder="2*x+7"
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
    <?php if ($_GET && isset($_GET['x']) && isset($_GET['fn']) && isset($_GET['dd']) && isset($_GET['error'])): ?>
        <div class="columns">
            <div class="column is-3">
                <h4 class="is-size-4"></h4>
                <!-- Converte o valores para inteiros -->
                <?php $x = (float)$_GET['x']; ?>
                <!-- Obtém a funções -->
                <?php $fn = $_GET['fn']; // Função ?>
                <!-- Obtém a derivada da funções -->
                <?php $dd = $_GET['dd']; // Derivada da função ?>
                <!-- Obtém o valor para o erro, sedo inversamente proporcional -->
                <?php $error = $Math->evaluate('1/' . $_GET['error']); ?>
                <!-- O valor de B -->
                O valor de X: <b class="has-text-success"><?= $x; ?></b>
                <br/>
                <!-- A função. -->
                A função: <b class="has-text-success"><?= $fn; ?></b>
                <br/>
                <!-- A derivada da função. -->
                A derivada da função: <b class="has-text-success"><?= $dd; ?></b>
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
                        <th>X</th>
                        <th>f(x)</th>
                        <th>f'(x)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Máximo de interações -->
                    <?php $max = 1000; ?>
                    <?php do { ?>
                        <!-- Decrenta o valor, máximo de interações -->
                        <?php $max-- ?>
                        <!-- O resultado da função -->
                        <?php $fx = $Math->evaluate(str_replace("x", $x, $fn)) ?>
                        <?php $fdd = $Math->evaluate(str_replace("x", $x, $dd)) ?>
                        <tr>
                            <td><?= $x ?></td>
                            <td><?= $fx ?></td>
                            <td><?= $fdd ?></td>
                        </tr>
                        <!--  -->
                        <?php $x = $x - ($fx / $fdd) ?>
                    <?php } while ($max and abs($fx) >= $error) ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>