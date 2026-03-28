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
        <button type="submit">=</button>
    </form>
</body>
</html>