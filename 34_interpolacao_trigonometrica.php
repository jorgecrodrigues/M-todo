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
 * @param $find
 * @param $replace
 * @param $array
 * @return array|mixed
 */
function recursive_array_replace($find, $replace, $array)
{
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = array();
    foreach ($array as $key => $value) {
        $newArray[$key] = recursive_array_replace($find, $replace, $value);
    }
    return $newArray;
}

//
$fields = false;

// Verifica pelas entradas necessárias.
if ($_POST && isset($_POST['x']) && isset($_POST['x']) && isset($_POST['value'])) {
    // O valor de x
    $value = (int)($_POST['value']);
    // (x, y)
    $x = $_POST['x'];
    $y = $_POST['y'];
    //
    //
    $i = (is_array($x) && is_array($y)) && count($x) === count($y) ? count($x) : 0;
    //
    if ($i) {
        $fields = true;
    }

    // Divite o total de ponto por 2, e arredonda para o próximo menor valor inteiro.
    if ($i) {
        $m = floor(count($x) / 2);
    }
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

    <style>
        #original .columns {
            display: none;
        }

        hr {
            margin: 0;
        }
    </style>

    <script src="jquery-3.2.1/jquery-3.2.1.min.js"></script>

    <script>
        $(window.document).ready(function () {
            $('#more').click(function () {
                $($('#original .columns')[0]).clone().appendTo('#destiny');
            })
            $('#remove').click(function () {
                $('#destiny .columns').last().remove();
            })
        });
    </script>
</head>
<body>
<?php include_once "nav.php"; ?>

<div class="container">
    <h2 class="is-size-2">Spline Linear</h2>
    <br/>
    <br/>

    <form id="original">
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Valor de (X):</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="x[]" placeholder="Ex: 2" required>
                        <span class="icon is-small is-left"><i class="fa fa-angle-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Valor de f(x):</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-success" type="text" name="y[]" placeholder="Ex: 3" required>
                        <span class="icon is-small is-left"><i class="fa fa-angle-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-success">Obrigatório</p>
                </div>
            </div>
        </div>
    </form>

    <div class="columns">
        <div class="column is-4">
            <form method="post">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">O valor procurado</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input is-success" type="text" name="value" placeholder="Ex: 2" required>
                                <span class="icon is-small is-left"><i class="fa fa-angle-right"></i></span>
                                <span class="icon is-small is-right"></span>
                            </div>
                            <p class="help is-success">Obrigatório</p>
                        </div>
                    </div>
                </div>
                <div id="destiny">
                    <?php if ($fields): ?>
                        <?php for ($index = 0; $index < $i; $index++): ?>
                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Valor de (X):</label>
                                        <div class="control has-icons-left has-icons-right">
                                            <input class="input is-success" type="text" name="x[]" placeholder="Ex: 2"
                                                   value="<?php echo $x[$index]; ?>" required>
                                            <span class="icon is-small is-left"><i class="fa fa-angle-right"></i></span>
                                            <span class="icon is-small is-right"></span>
                                        </div>
                                        <p class="help is-success">Obrigatório</p>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label">Valor de f(x):</label>
                                        <div class="control has-icons-left has-icons-right">
                                            <input class="input is-success" type="text" name="y[]" placeholder="Ex: 3"
                                                   value="<?php echo $y[$index]; ?>" required>
                                            <span class="icon is-small is-left"><i class="fa fa-angle-right"></i></span>
                                            <span class="icon is-small is-right"></span>
                                        </div>
                                        <p class="help is-success">Obrigatório</p>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
                <br/>
                <br/>
                <div class="field is-grouped">
                    <div class="control">
                        <button id="more" type="button" class="button is-warning">Adicionar valores</button>
                    </div>
                    <div class="control">
                        <button id="remove" type="button" class="button is-danger">Remover campo</button>
                    </div>
                    <div class="control">
                        <button class="button is-primary">Calcular</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Percorre todos os valores de x -->
        <div class="column">
            <?php if ($i): ?>
            <!-- Delta recebe os valores de (x) -->
            <?php $x = is_array($x) ? $x : []; ?>
            <?php $y = is_array($y) ? $y : []; ?>
            <?php $count = count($x); ?>
            <div class="columns">
                <div class="column">
                    <?php for ($ii = 0; $ii < ($count - 1); $ii++): ?>
                        <div class="columns">
                            <!-- Si(x) = f(xi-1) * ((xi - x) / (xi - xi-1)) + f(xi) * ((x - xi-1) / xi - xi-1) -->
                            <!-- Si(x) = f(xi-1) * ((xi - x) / (xi - xi-1)) + f(xi) * ((x - xi-1) / xi - xi-1) -->
                            <?php $s[$ii] = $y[$ii] . " * ((" . $x[$ii + 1] . " - x) / (" . $x[$ii + 1] . " - " . $x[$ii] . ")) + " . $y[$ii + 1] . " * ((x -" . $x[$ii] . ") / (" . $x[$ii + 1] . " - " . $x[$ii] . "))" ?>
                            <div class="column">
                                S<?php echo $ii + 1 ?>(x) = <?php echo $s[$ii] ?>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
