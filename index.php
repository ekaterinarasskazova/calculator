<?php
session_start();
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
    </style>
</head>
<body>
<div class="container">
    <h1>Калькулятор</h1>
    <form method="POST" action="index.php">
        <input type="text" id="display" name="val" readonly>
        
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