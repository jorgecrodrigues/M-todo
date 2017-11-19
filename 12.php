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
    <h2 class="is-size-2">1/3 de Simpson Repetida</h2>
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
                        <input class="input is-success" type="text" name="b" value="7" placeholder="Ex: 7" required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Subdivisões do intervalo:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="m" value="1" placeholder="Ex: 1" required/>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column is-5">
                <div class="field">
                    <label class="label">A função:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-warning" type="text" name="fn" value="1/x^2" placeholder="Ex: 1/x^2"
                               required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-warning">Obrigatório</p>
                </div>
            </div>
            <div class="column is-5">
                <div class="field">
                    <label class="label">A derivada quarta da função:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-warning" type="text" name="dd" value="120*x^-6" placeholder="120*x^-6"
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
    <?php if ($_GET && isset($_GET['a']) && isset($_GET['b']) && isset($_GET['m']) && isset($_GET['fn']) && isset($_GET['dd']) && isset($_GET['error'])): ?>
        <div class="columns">
            <div class="column">
                <h4 class="is-size-4"></h4>
                <!-- Converte o valores de a, b, e n para inteiros -->
                <?php $a = (int)$_GET['a']; ?>
                <?php $b = (int)$_GET['b']; ?>
                <?php $m = (int)$_GET['m']; ?>
                <!-- n=m/2 é a metade de subdivisões do intervalo [a,b] -->
                <?php $n = round($m / 2); ?>
                <!-- Faz o cálculo de h sendo (b - a) / n -->
                <?php $h = ($b - $a) / $m; ?>
                <!-- Obtém os as funções -->
                <?php $fn = $_GET['fn']; // Função ?>
                <?php $dd = $_GET['dd']; // Derivada segunda ?>
                <!-- O valor de h -->
                O valor de H: <b class="has-text-success"><?= $h ?></b>
                <br/>
                <!-- Metade das subdivisões  -->
                O valor de N: <b class="has-text-success"><?= $n ?></b>
                <br/>
                <!-- A função. -->
                A função: <b class="has-text-success"><?= $fn; ?></b>
                <br/>
                <!-- Obtém o valor para o erro, sedo inversamente proporcional -->
                <?php $error = $Math->evaluate('1/' . $_GET['error']); ?>
            </div>
            <div class="column">
                <h4 class="is-size-4">Interações:</h4>
                <table class="table is-hoverable">
                    <thead>
                    <tr>
                        <th>x</th>
                        <th>f(x)</th>
                        <th>Domínio</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- O somatório -->
                    <?php $sum = 0; ?>
                    <?php $index = 0; ?>
                    <?php for ($i = $a; $i <= $b; $i = $i + $h): ?>
                        <!-- ATENÇÃO! Para ( X0 < Xi > Xn ) multiplicar por 2 se par ou 4 se ímpar. -->
                        <?php if ($v = $i > $a && $i < $b - $h): ?>
                            <?php $index = $index + 1 ?>
                            <?php $v = $index % 2 == 0 ? 2 : 4 ?>
                        <?php else: ?>
                            <?php $v = 1 ?>
                        <?php endif; ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= $v; ?> * <?= (str_replace("x", $i, $fn)); ?></td>
                            <td><?= $v * $Math->evaluate(str_replace("x", $i, $fn)); ?></td>
                        </tr>
                        <?php $sum = $sum + ($v * $Math->evaluate(str_replace("x", $i, $fn))); ?>
                    <?php endfor; ?>
                    <tr>
                        <!-- O valor numérico da integral calculada segundo a regra 1/3 de Simpson repetida será: -->
                        <?php $it = ($h / 3) * $sum ?>
                        <th colspan="3">I(t): <?= $it ?></th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="column">
                <h4 class="is-size-4">Estimativa de erro:</h4>
                <table class="table is-hoverable">
                    <thead>
                    <tr>
                        <th>x</th>
                        <th>|f''(x)|</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $max = array(); ?>
                    <?php for ($i = $a; $i <= $b; $i = $i + 1): ?>
                        <?php array_push($max, $Math->evaluate(str_replace("x", $i, $dd))); ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td>
                                <?= (str_replace("x", $i, $dd)); ?> =
                                <?= $Math->evaluate(str_replace("x", $i, $dd)); ?>
                            </td>
                        </tr>
                    <?php endfor; ?>
                    <tr>
                        <!-- Estimativa para o erro na regra do 1/3 de Simpson repetida será: -->
                        <?php $et = (pow(($b - $a), 5) / (2880 * pow($n, 4))) * mod(max($max)); ?>
                        <th colspan="2">E(t): <?= $et ?></th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            O número de subdivisões para o erro ser menor que <?= $error ?> é:
                            <?= round(sqrt((pow($b - $a, 5) / (2880 * $error)) * mod(max($max)))); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
