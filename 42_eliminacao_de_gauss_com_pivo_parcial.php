<?php

/**
 * Módulo de um número.
 *
 * @param  int $x
 * @return float|int
 */
function mod($x)
{
    if ($x < 0) return -1 * $x;
    return $x;
}

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

// Verifica pelas entradas necessárias.
if ($_POST && isset($_POST['mm'])) {
    //
    $mm = $_POST['mm'];

    $explode = explode(';', $mm);
    foreach ($explode as $value) {
        $A[] = explode(',', $value);
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
    <script src="jquery-3.2.1/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include_once "nav.php"; ?>
<br/>
<br/>
<div class="container">
    <div class="columns">
        <div class="column is-4">
            <h2 class="is-size-2">Eliminação de Gauss com Pivô Parcial</h2>
            <form method="post">
                <div class="field">
                    <label class="label">A matriz IxI</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="1,3,4,3;
4,7,8,6;
1,-4,5,4"
                                  name="mm"></textarea>
                    </div>
                </div>
                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-primary">Calcular</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="column">
            <div class="columns">
                <div class="column has-text-centered">
                    <?php $ci = count($A) ?>
                    <!-- Percorrento a matriz -->
                    <?php for ($ii = 0; $ii < $ci; $ii++): ?>
                        <?php $cj = count($A[$ii]) ?>
                        <div class="columns">
                            <?php for ($jj = 0; $jj < $cj; $jj++): ?>
                                <div class="column">
                                    <?php echo $A[$ii][$jj] . " [" . $ii . "," . $jj . "]" ?>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endfor; ?>

                    <hr/>
                    <hr/>

                    <?php $count = count($A) ?>
                    <!-- Percorrento a matriz -->
                    <?php for ($k = 0; $k < $count; $k++): ?>

                        <!-- Pivoteamento  -->
                        <?php $pivot = $A[$k][$k] ?>
                        <?php $line = $k ?>

                        <div class="columns has-text-left">
                            <div class="column">Pivô <?php echo $pivot ?></div>
                            <div class="column">Linha pivô <?php echo $line ?></div>
                        </div>

                        <?php for ($i = $k + 1; $i < $count; $i++): ?>
                            <?php if (mod($A[$i][$k]) > mod($pivot)): ?>
                                <?php $pivot = $A[$i][$k] ?>
                                <?php $line = $i ?>
                                <div class="columns has-text-left">
                                    <div class="column">Pivô <?php echo $pivot ?></div>
                                    <div class="column">Linha pivô <?php echo $line ?></div>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($pivot == 0): ?>
                            <?php die(500) ?>
                        <?php endif; ?>

                        <?php if ($line != $k): ?>
                            <?php for ($j = 0; $j < $count + 1; $j++): ?>
                                <?php $switch = $A[$k][$j]; ?>
                                <?php $A[$k][$j] = $A[$line][$j]; ?>
                                <?php $A[$line][$j] = $switch; ?>
                            <?php endfor; ?>
                        <?php endif; ?>

                        <?php $ci = count($A) ?>
                        <!-- Percorrento a matriz -->
                        <?php for ($ii = 0; $ii < $ci; $ii++): ?>
                            <?php $cj = count($A[$ii]) ?>
                            <div class="columns">
                                <?php for ($jj = 0; $jj < $cj; $jj++): ?>
                                    <div class="column">
                                        <?php echo "[" . $ii . "," . $jj . "] <br/>" . $A[$ii][$jj] ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        <?php endfor; ?>

                        <?php if ($k + 1 < $count): ?>
                            <hr/>
                            <b>Etapa: <?php echo $k + 1 ?></b>
                            <br/>
                        <?php endif; ?>

                        <?php $ij = $A[$k][$k] ?>
                        <?php for ($i = $k + 1; $i < $count; $i++): ?>
                            <div class="has-text-left">
                                <?php $m = $A[$i][$k] / $A[$k][$k]; ?>
                                <b><?php echo "[$i, $k] " ?></b>
                                <?php echo $A[$i][$k] . "/" . $A[$k][$k] . "=" . $m ?>
                                <br/>
                                <?php $A[$i][$k] = 0; ?>
                                <?php for ($j = $k + 1; $j < $count + 1; $j++): ?>
                                    <b><?php echo "[$i, $j]" ?></b>
                                    <?php echo " (" . $A[$i][$j] . "-" . $m . "*" . $A[$k][$j] ?>
                                    <?php $A[$i][$j] = $Math->evaluate("" . $A[$i][$j] . "-" . $m . "*" . $A[$k][$j]) ?>
                                    <?php echo "=" . $A[$i][$j] . ") " ?>
                                    <br/>
                                <?php endfor; ?>
                            </div>
                            <br/>
                            <br/>
                        <?php endfor; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
