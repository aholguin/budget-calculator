<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th, table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th, tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>
<body>
<form method="post" action="index.php">
    <div>
        <label>Enter the budget’s total amount.</label>
        <label>
            <input name="budget" type="number" step="0.01" required>
        </label>
        <input type="submit">
    </div>
</form>
<table>
    <thead>
    <tr>
        <th>Budget</th>
        <th>Maximum vehicle amount</th>
        <th>Basic</th>
        <th>Special</th>
        <th>Association</th>
        <th>Storage</th>
    </tr>
    </thead>
    <tbody>
    <?PHP foreach ($_SESSION['budgetHistory'] as $history): ?>
        <tr>
            <td><?= $history['budget'] ?></td>
            <td><?= $history['maximumVehicleAmount'] ?></td>
            <td><?= $history['basic'] ?></td>
            <td><?= $history['special'] ?></td>
            <td><?= $history['association'] ?></td>
            <td><?= $history['storage'] ?></td>
        </tr>
    <?PHP endforeach; ?>
    </tbody>
</table>
</body>
</html>
