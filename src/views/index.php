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
    <?PHP if (isset($data) && isset($budget)): ?>
        <tr>
            <td><?= $budget ?></td>
            <td><?= $data['maximumVehicleAmount'] ?></td>
            <td><?= $data['basic'] ?></td>
            <td><?= $data['special'] ?></td>
            <td><?= $data['association'] ?></td>
            <td><?= $data['storage'] ?></td>
        </tr>
    <?PHP endif; ?>
    </tbody>
</table>
</body>
</html>
