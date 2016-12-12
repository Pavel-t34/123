<style>
  body 
     { 
       background: url(gibdd.jpg) right bottom no-repeat;
     }
      a.button28 {
  position: relative;
  display: inline-block;
  font-size: 90%;
  font-weight: 700;
  color: rgb(209,209,217);
  text-decoration: none;
  text-shadow: 0 -1px 2px rgba(0,0,0,.2);
  padding: .5em 1em;
  outline: none;
  border-radius: 3px;
  background: linear-gradient(rgb(110,112,120), rgb(81,81,86)) rgb(110,112,120);
  box-shadow:
   0 1px rgba(255,255,255,.2) inset,
   0 3px 5px rgba(0,1,6,.5),
   0 0 1px 1px rgba(0,1,6,.2);
  transition: .2s ease-in-out;
}
a.button28:hover:not(:active) {
  background: linear-gradient(rgb(126,126,134), rgb(70,71,76)) rgb(126,126,134);
}
a.button28:active {
  top: 1px;
  background: linear-gradient(rgb(76,77,82), rgb(56,57,62)) rgb(76,77,82);
  box-shadow:
   0 0 1px rgba(0,0,0,.5) inset,
   0 2px 3px rgba(0,0,0,.5) inset,
   0 1px 1px rgba(255,255,255,.1);
}
    </style>
<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=gibdd60', 'gibdd60', 'Ebhugre0');

$pdo->exec('SET NAMES "utf8";');

$action = '';

if (isset($_GET['action']))
{
  $action = $_GET['action'];
}

switch ($action)
{
  case 'add':
    $url = '/regavto.php?action=create';
    include 'forms/regavto.php';
  break;

  case 'create':
    $sql = $pdo->prepare('INSERT INTO `car`(`brand`, `model`, `engine`,`number`, `owner`,  `year`, `vin`) VALUES (:brand, :model, :engine, :number, :owner , :year, :vin )');
    $sql->execute([
      ':brand' => $_POST['brand'],
      ':model' => $_POST['model'],
      ':engine' => $_POST['engine'],
      ':number' => $_POST['number'],
      ':owner' => $_POST['owner'],
      ':year' => $_POST['year'],
      ':vin' => $_POST['vin'],
    ]);
    echo 'Успешно!<br><a href="/regavto.php">Список студентов</a>';
  break;
  
  case 'edit':
    $sql = $pdo->prepare('SELECT * FROM `car` WHERE `id` = :id');
    $sql->execute([':id' => $_GET['id']]);
    $car = $sql->fetch();
    $url = '/regavto.php?action=update&id=' . $_GET['id'];
    include 'forms/regavto.php';
  break;
  
  case 'update':
    $sql = $pdo->prepare('UPDATE `car` SET  `brand` = :brand, `model` = :model, `engine` = :engine, `number` = :number, `owner` = :owner,`year` = :year, `vin` = :vin WHERE `id` = :id LIMIT 1');
    $sql->execute([
      ':id' => $_GET['id'],
      ':brand' => $_POST['brand'],
      ':model' => $_POST['model'],
      ':engine' => $_POST['engine'],
      ':number' => $_POST['number'],
      ':owner' => $_POST['owner'],
      ':year' => $_POST['year'],
      ':vin' => $_POST['vin'],
      
    ]);
    echo 'Успешно!<br><a href="/regavto.php">Список студентов</a>';
  break;

  case 'delete':
    $sql = $pdo->prepare('DELETE FROM `car` WHERE `id` = :id LIMIT 1');
    $sql->execute([':id' => $_GET['id']]);
    echo 'Удалено!<br><a href="/regavto.php">Список студентов</a>';
  break;

  default:

    echo '<a href="/" class="button28">Вернуться на главную</a> <hr>';

    echo '<a href="/regavto.php?action=add" class="button28">Добавить</a><br>';
  echo '<br>';

    $cars = $pdo->query('SELECT * FROM `car`');


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

    foreach ($cars as $car)
    {
      echo '<tr>';
      echo 
      '<td>' . $car['id'] . '</td> '  
      . '<td>' . $car['brand'] . '</td>'
      . '<td>' . $car['model'] . '</td> ' 
      . '<td>' . $car['engine'] . '</td>'  
      . '<td>' . $car['number'] . '</td> '
      . '<td>' . $car['owner'] . '</td>'
      . '<td>' . $car['year'] . '</td>'
      . '<td>' . $car['vin'] . '</td> ' 
      
      . '<td><a href="/regavto.php?action=edit&id=' . $car['id'] . '">ред.</a> <a href="/regavto.php?action=delete&id=' . $car['id'] . '">уд.</a></td>';
      echo '</tr>';

    }
    echo '</table>';

  break;
