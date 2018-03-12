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

// Limite de interações
$limit = 50;

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
if ($_POST && isset($_POST['mm']) && isset($_POST['b']) && isset($_POST['error'])) {
    //
    $mm = $_POST['mm'];
    //
    $b = $_POST['b'];
    //
    $error = $Math->evaluate("1/" . $_POST['error']);
    //
    $explode = explode(';', $mm);
    foreach ($explode as $value) {
        $A[] = explode(',', $value);
    }
    //
    $b = explode(',', $b);
}
// error_reporting(E_ALL);
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
                    <label class="label">Erro:</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input is-danger" type="text" name="error" value="10^2" placeholder="Ex: 10^2"
                               required>
                        <span class="icon is-small is-left"><i class="fa fa-long-arrow-right"></i></span>
                        <span class="icon is-small is-right"></span>
                    </div>
                    <p class="help is-danger">Padrão 10²</p>
                </div>
                <div class="field">
                    <label class="label">A matriz IxI</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="1,3,4;4,7,8;1,-4,5" name="mm"></textarea>
                    </div>
                </div>
                <div class="field">
                    <label class="label">A matriz b</label>
                    <div class="control">
                        <textarea class="textarea" placeholder="3,6,4" name="b"></textarea>
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
                    <?php $cj = $ci ? count($A[0]) : 0 ?>

                    <?php for ($i = 0; $i < count($b); $i++): ?>
                        <?php $X[$i] = 0 ?>
                    <?php endfor; ?>

                    <!-- Numerador -->
                    <?php $nn = 1 ?>
                    <!-- Denominador -->
                    <?php $dd = 1 ?>

                    <!-- Gauss - Jacobi -->
                    <?php while ((($nn / $dd) > $error) && $limit): ?>
                        <?php $limit = $limit - 1 ?>

                        <?php for ($i = 0; $i < $ci; $i++): ?>
                            <?php $Y[$i] = 0; ?>
                            <?php for ($j = 0; $j < $cj; $j++): ?>
                                <?php if ($i != $j): ?>
                                    <?php $ev = $Y[$i] . " + " . $A[$i][$j] . " * " . $X[$j] ?>
                                    <?php $Y[$i] = $Math->evaluate($ev) ?>
                                <?php endif; ?>
                                <?php $ev = "1/(" . $A[$i][$i] . "*(" . $b[$i] . "-" . $Y[$i] . "))" ?>
                                <?php $Y[$i] = $Math->evaluate($ev) ?>
                            <?php endfor; ?>


                            <?php if ($nn < mod($Math->evaluate($X[$i] - $Y[$i]))): ?>
                                <?php $nn = mod($Math->evaluate($X[$i] - $Y[$i])) ?>
                            <?php endif; ?>

                            <?php if ($dd < mod($Math->evaluate($Y[$i]))): ?>
                                <?php $dd = mod($Math->evaluate($Y[$i])) ?>
                            <?php endif; ?>


                        <?php endfor; ?>

                        <br/>
                        <?php foreach ($X as $x): ?>
                            <?php echo $x ?>
                        <?php endforeach; ?>
                        <br/>

                        <?php $X = $Y ?>

                        <?php foreach ($Y as $y): ?>
                            <?php echo $y ?>
                        <?php endforeach; ?>
                        <br/>

                        <?php echo $nn / $dd ?>
                        <?php echo ($nn / $dd) > $error ? "Sim" : "Não" ?>
                        <br/>
                    <?php endwhile; ?>

                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
