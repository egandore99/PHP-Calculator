<?php
session_start();

if (!isset($_SESSION['operand1'])) {
    $_SESSION['operand1'] = '';
}

if (!isset($_SESSION['operator'])) {
    $_SESSION['operator'] = '';
}

if (!isset($_SESSION['operand2'])) {
    $_SESSION['operand2'] = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['input'])) {
        $input = $_POST['input'];

        if (is_numeric($input) || $input === '.') {
            if ($_SESSION['operator'] == '') {
                $_SESSION['operand1'] .= $input;
            } else {
                $_SESSION['operand2'] .= $input;
            }
        } else {
            switch ($input) {
                case '+':
                case '-':
                case '*':
                case '÷':
                    if ($_SESSION['operator'] != '' && $_SESSION['operand2'] != '') {
                        calculate();
                    }
                    $_SESSION['operator'] = $input;
                    break;
            }
        }
    }

    if (isset($_POST['clear'])) {
        $_SESSION['operand1'] = '';
        $_SESSION['operator'] = '';
        $_SESSION['operand2'] = '';
    }

    if (isset($_POST['calculate'])) {
        if ($_SESSION['operator'] != '' && $_SESSION['operand2'] != '') {
            calculate();
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function calculate() {
    $operand1 = floatval($_SESSION['operand1']);
    $operand2 = floatval($_SESSION['operand2']);

    switch ($_SESSION['operator']) {
        case '+':
            $_SESSION['operand1'] = $operand1 + $operand2;
            break;
        case '-':
            $_SESSION['operand1'] = $operand1 - $operand2;
            break;
        case '*':
            $_SESSION['operand1'] = $operand1 * $operand2;
            break;
        case '÷':
            if ($operand2 != 0) {
                $_SESSION['operand1'] = $operand1 / $operand2;
            } else {
                $_SESSION['operand1'] = 'Error';
            }
            break;
    }

    $_SESSION['operator'] = '';
    $_SESSION['operand2'] = '';
}

$display = htmlspecialchars($_SESSION['operand1'] . $_SESSION['operator'] . $_SESSION['operand2']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>PHP Calculator</title>
</head>
<body>
    <div class="calculator">
        <form method="post" action="">
            <div class="header">
                <div class="input" id="calc-input">
                    <?php echo $display; ?>
                </div>
            </div>
            <div class="keys">
                <div class="row">
                    <div class="number">
                        <button type="submit" name="input" value="7">7</button>
                        <button type="submit" name="input" value="8">8</button>
                        <button type="submit" name="input" value="9">9</button>
                    </div>
                    <div class="symbol">
                        <button type="submit" name="input" value="÷">÷</button>
                    </div>
                </div>
                <div class="row">
                    <div class="number">
                        <button type="submit" name="input" value="4">4</button>
                        <button type="submit" name="input" value="5">5</button>
                        <button type="submit" name="input" value="6">6</button>
                    </div>
                    <div class="symbol">
                        <button type="submit" name="input" value="-">-</button>
                    </div>
                </div>
                <div class="row">
                    <div class="number">
                        <button type="submit" name="input" value="1">1</button>
                        <button type="submit" name="input" value="2">2</button>
                        <button type="submit" name="input" value="3">3</button>
                    </div>
                    <div class="symbol">
                        <button type="submit" name="input" value="+">+</button>
                    </div>
                </div>
                <div class="row">
                    <div class="number">
                        <button type="submit" name="clear" value="AC" class="dull">AC</button>
                        <button type="submit" name="input" value="0">0</button>
                        <button type="submit" name="input" value=".">.</button>
                    </div>
                    <div class="symbol action">
                        <button type="submit" name="calculate" value="=">=</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="credit">
        <a href="https://gandore.dev/">
        <p style="transform: rotate(90deg);
                  transform-origin: left bottom;
                  display: inline-block;
                  font-size: 15px;
                  color: #ffffff;
                  margin-top:150px;"> &copy; Eduard Gandore</p>
        </a>
    </div>
</body>
</html>
