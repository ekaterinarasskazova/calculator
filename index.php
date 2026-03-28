<?php
session_start();
function isDigitChar($ch)
{
    return $ch >= '0' && $ch <= '9';
}

function isnum($x)
{
    if ($x === null) return false;
    if ($x === '') return false;

    $len = strlen($x);
    $dotCount = 0;

    if ($x[0] === '.' || $x[$len - 1] === '.') {
        return false;
    }

    for ($i = 0; $i < $len; $i++) {
        $ch = $x[$i];

        if ($ch === '.') {
            $dotCount++;
            if ($dotCount > 1) {
                return false;
            }
        } elseif (!isDigitChar($ch)) {
            return false;
        }
    }

    return true;
}
function calculate($val)
{
    if ($val === '') {
        return 'Ошибка: пустое выражение';
    }

    if (isnum($val)) {
        return $val + 0;
    }

    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!is_numeric($arg)) {
                return $arg;
            }
            $sum += $arg;
        }
        return $sum;
    }

    $args = explode('-', $val);
    if (count($args) > 1) {
        $first = calculate($args[0]);
        if (!is_numeric($first)) {
            return $first;
        }

        $res = $first;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!is_numeric($arg)) {
                return $arg;
            }
            $res -= $arg;
        }
        return $res;
    }

    $args = explode('*', $val);
    if (count($args) > 1) {
        $res = 1;
        for ($i = 0; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!is_numeric($arg)) {
                return $arg;
            }
            $res *= $arg;
        }
        return $res;
    }

    $args = explode('/', $val);
    if (count($args) > 1) {
        $first = calculate($args[0]);
        if (!is_numeric($first)) {
            return $first;
        }

        $res = $first;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!is_numeric($arg)) {
                return $arg;
            }
            if ((float)$arg == 0.0) {
                return 'Ошибка: деление на ноль';
            }
            $res /= $arg;
        }
        return $res;
    }

    return 'Ошибка: неправильное выражение';
}
function SqValidator($val)
{
    $open = 0;

    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] === '(') {
            $open++;
        } elseif ($val[$i] === ')') {
            $open--;
            if ($open < 0) {
                return false;
            }
        }
    }

    return $open === 0;
}
function calculateSq($val)
{
    if (!SqValidator($val)) {
        return 'Ошибка: неправильная расстановка скобок';
    }

    $start = strpos($val, '(');

    if ($start === false) {
        return calculate($val);
    }

    $end = $start + 1;
    $open = 1;

    while ($open > 0 && $end < strlen($val)) {
        if ($val[$end] === '(') {
            $open++;
        } elseif ($val[$end] === ')') {
            $open--;
        }
        $end++;
    }

    $inside = substr($val, $start + 1, $end - $start - 2);
    $insideResult = calculateSq($inside);

    if (!is_numeric($insideResult)) {
        return $insideResult;
    }

    $newVal = substr($val, 0, $start) . $insideResult . substr($val, $end);

    return calculateSq($newVal);
}
function trimSpacesManual($str)
{
    $result = '';
    for ($i = 0; $i < strlen($str); $i++) {
        if ($str[$i] !== ' ') {
            $result .= $str[$i];
        }
    }
    return $result;
}

function hasOnlyAllowedChars($val)
{
    if ($val === '') return false;

    for ($i = 0; $i < strlen($val); $i++) {
        $ch = $val[$i];

        if (
            !isDigitChar($ch) &&
            $ch !== '+' &&
            $ch !== '-' &&
            $ch !== '*' &&
            $ch !== '/' &&
            $ch !== '(' &&
            $ch !== ')' &&
            $ch !== '.'
        ) {
            return false;
        }
    }

    return true;
}

function hasEmptyBrackets($val)
{
    for ($i = 0; $i < strlen($val) - 1; $i++) {
        if ($val[$i] === '(' && $val[$i + 1] === ')') {
            return true;
        }
    }
    return false;
}

function hasInvalidSequence($val)
{
    $operators = ['+', '-', '*', '/'];

    $len = strlen($val);
    if ($len === 0) return true;

    if (in_array($val[0], $operators, true)) {
        return true;
    }

    if (in_array($val[$len - 1], $operators, true)) {
        return true;
    }

    for ($i = 0; $i < $len - 1; $i++) {
        $a = $val[$i];
        $b = $val[$i + 1];

        if (in_array($a, $operators, true) && in_array($b, $operators, true)) {
            return true;
        }

        if ($a === '(' && in_array($b, $operators, true)) {
            return true;
        }

        if (in_array($a, $operators, true) && $b === ')') {
            return true;
        }

        if ((isDigitChar($a) || $a === '.') && $b === '(') {
            return true;
        }

        if ($a === ')' && (isDigitChar($b) || $b === '.')) {
            return true;
        }

        if ($a === ')' && $b === '(') {
            return true;
        }
    }

    return false;
}

function validateExpression($val)
{
    if ($val === '') {
        return 'Ошибка: выражение не введено';
    }

    if (!hasOnlyAllowedChars($val)) {
        return 'Ошибка: недопустимые символы';
    }

    if (!SqValidator($val)) {
        return 'Ошибка: неправильная расстановка скобок';
    }

    if (hasEmptyBrackets($val)) {
        return 'Ошибка: пустые скобки';
    }

    if (hasInvalidSequence($val)) {
        return 'Ошибка: неправильная последовательность символов';
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['val'])) {
    $expr = $_POST['val'];
    $expr = trimSpacesManual($expr);

    $validation = validateExpression($expr);

    if ($validation === true) {
        $result = calculateSq($expr);
    } else {
        $result = $validation;
    }

    header('Location: index.php?expr=' . urlencode($expr) . '&result=' . urlencode((string)$result));
    exit;
}

$currentExpr = isset($_GET['expr']) ? $_GET['expr'] : '';
$currentResult = isset($_GET['result']) ? $_GET['result'] : '';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .container {
            width: 420px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.12);
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .display {
            width: 100%;
            height: 50px;
            font-size: 24px;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 12px;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        button {
            height: 55px;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .result-box {
            min-height: 40px;
            padding: 10px;
            margin-bottom: 16px;
            border-radius: 8px;
            background: #eef3ff;
            font-size: 18px;
            word-break: break-word;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Калькулятор</h1>
    <form method="POST" action="index.php">
        <input type="text" id="display" name="val" class="display" value="<?php echo htmlspecialchars($currentExpr); ?>" readonly >
        <div class="result-box">
            <?php
            if ($result !== '') {
                echo htmlspecialchars($currentResult);
            } else {
                echo 'Пока нет результата';
            }
            ?>
        </div>
        <div>
            <button type="button" onclick="appendValue('7')">7</button>
            <button type="button" onclick="appendValue('8')">8</button>
            <button type="button" onclick="appendValue('9')">9</button>
            <button type="button" onclick="appendValue('/')">/</button>
        
            <button type="button" onclick="appendValue('4')">4</button>
            <button type="button" onclick="appendValue('5')">5</button>
            <button type="button" onclick="appendValue('6')">6</button>
            <button type="button" onclick="appendValue('*')">*</button>
        
            <button type="button" onclick="appendValue('1')">1</button>
            <button type="button" onclick="appendValue('2')">2</button>
            <button type="button" onclick="appendValue('3')">3</button>
            <button type="button" onclick="appendValue('-')">-</button>
        
            <button type="button" onclick="appendValue('0')">0</button>
            <button type="button" onclick="appendValue('(')">(</button>
            <button type="button" onclick="appendValue(')')">)</button>
            <button type="button" onclick="appendValue('+')">+</button>
        
            <button type="button" onclick="clearDisplay()">C</button>
            <button type="submit" style="grid-column: span 3;">=</button>
        </div>
    </form>
    <div class="result">
        value="<?php echo htmlspecialchars($currentExpr); ?>"
    </div>
</div>
<script>
    const display = document.getElementById('display');

    function appendValue(value) {
        display.value += value;
    }

    function clearDisplay() {
        display.value = '';
    }
</script>
</body>
</html>