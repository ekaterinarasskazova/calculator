<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
</head>
<body>
    <h1>Калькулятор</h1>
    <form method="POST" action="index.php">
        <input type="text" id="display" name="val" readonly>
        
        <div>
            <button type="button" onclick="appendValue('7')">7</button>
            <button type="button" onclick="appendValue('8')">8</button>
            <button type="button" onclick="appendValue('9')">9</button>
            <button type="button" onclick="appendValue('/')">/</button>
        </div>

        <div>
            <button type="button" onclick="appendValue('4')">4</button>
            <button type="button" onclick="appendValue('5')">5</button>
            <button type="button" onclick="appendValue('6')">6</button>
            <button type="button" onclick="appendValue('*')">*</button>
        </div>

        <div>
            <button type="button" onclick="appendValue('1')">1</button>
            <button type="button" onclick="appendValue('2')">2</button>
            <button type="button" onclick="appendValue('3')">3</button>
            <button type="button" onclick="appendValue('-')">-</button>
        </div>

        <div>
            <button type="button" onclick="appendValue('0')">0</button>
            <button type="button" onclick="appendValue('(')">(</button>
            <button type="button" onclick="appendValue(')')">)</button>
            <button type="button" onclick="appendValue('+')">+</button>
        </div>

        <div>
            <button type="button" onclick="clearDisplay()">C</button>
            <button type="submit">=</button>
        </div>
    </form>
</body>
</html>