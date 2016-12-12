<?
$pdo = new PDO('mysql:host=127.0.0.1;dbname=gibdd60', 'gibdd60', 'Ebhugre0');
$pdo->exec('SET NAMES "utf8";');

$number = $_POST['number'];
$searchs = $pdo->query('SELECT * FROM `gibdd60`.`car` WHERE `number` = '.$number);

echo '<table border="1" cellspacing="0">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Марка</th>';
    echo '<th>Модель</th>';
    echo '<th>Двигатель</th>';
    echo '<th>Номер</th>';
    echo '<th>Владелец</th>';
    echo '<th>Год</th>';
    echo '<th>VIN</th>';
    echo '<th>&nbsp;</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>' . $searchs['id'] . '</td> ' 
      . '<td>' . $searchs['brand'] . '</td> ' 
      . '<td>' . $searchs['model'] . '</td>'
      . '<td>' . $searchs['engine'] . '</td>'
      . '<td>' . $searchs['number'] . '</td>'  
      . '<td>' . $searchs['owner'] . '</td>'
      . '<td>' . $searchs['year'] . '</td>'
      . '<td>' . $searchs['vin'] . '</td>';
  echo '</tr>';
echo '</table>';