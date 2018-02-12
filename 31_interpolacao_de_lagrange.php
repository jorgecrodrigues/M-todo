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
    //
    $value = (int)($_POST['value']);
    // (x, y)
    $x = $_POST['x'];
    $y = $_POST['y'];

    $i = (is_array($x) && is_array($y)) && count($x) === count($y) ? count($x) : 0;

    if ($i) {
        $fields = true;
    }

    for ($xx = 0; $xx < $i; $xx++) {
        $dd = '';
        $nn = '';
        for ($yy = 0; $yy < $i; $yy++) {
            if ($xx !== $yy) {
                $nn = $nn . "(x-$x[$yy])";
                $dd = $dd . "($x[$xx]-$x[$yy])";
            }
        }
        $lx[$xx]['nn'] = $nn;
        $lx[$xx]['vnn'] = $Math->evaluate(str_replace('x', $value, $nn));
        $lx[$xx]['dd'] = $dd;
        $lx[$xx]['vdd'] = $Math->evaluate($dd);
    }


    $lx = recursive_array_replace('--', '+', $lx);
    $lx = recursive_array_replace(')(', ')*(', $lx);
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
    <h2 class="is-size-2">Forma de Lagrange</h2>
    <br/>
    <br/>


    <?php if (isset($lx)): ?>
        <?php foreach ($lx as $key => $li): ?>
            <div class="columns">
                <div class="column is-2">
                    L<?php echo $key ?>(x) =
                </div>
                <div class="column has-text-centered">
                    <?php echo $li['nn'] ?> = <?php echo $li['vnn'] ?>
                    <hr/>
                    <?php echo $li['dd'] ?> = <?php echo $li['vdd'] ?>
                    <br/>
                    <br/>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($lx)): ?>
        <div class="columns">
            <div class="column is-2">
                P(x) =
            </div>
            <div class="column has-text-centered">
                <?php $r = ""; ?>
                <?php foreach ($lx as $key => $li): ?>
                    <?php $r = $r . "((" . $y[$key] . "*" . $li['vnn'] . ") / " . $li['vdd'] . ")" ?>
                    <?php $r .= $key < ($i - 1) ? " + " : "" ?>
                <?php endforeach; ?>
                <?php echo $r ?> = <?php echo $Math->evaluate($r) ?>
            </div>
        </div>
    <?php endif; ?>

    <form id="original">
        <div class="columns">
            <div class="column is-2">
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
            <div class="column is-2">
                <div class="field">
                    <label class="label">Valor de (Y):</label>
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

    <form method="post">
        <div class="columns">
            <div class="column is-4">
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
                        <div class="column is-2">
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
                        <div class="column is-2">
                            <div class="field">
                                <label class="label">Valor de (Y):</label>
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
</body>
</html>