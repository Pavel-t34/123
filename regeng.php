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
    $url = '/regeng.php?action=create';
    include 'forms/regeng.php';
  break;

  case 'create':
    $sql = $pdo->prepare('INSERT INTO `engine`(`model`, `power`, `vin`) VALUES (:model, :power, :vin)');
    $sql->execute([
      ':model' => $_POST['model'],
      ':power' => $_POST['power'],
      ':vin' => $_POST['vin'],
    ]);
    echo 'Успешно!<br><a href="/regeng.php">Список студентов</a>';
  break;
  
  case 'edit':
    $sql = $pdo->prepare('SELECT * FROM `engine` WHERE `id` = :id');
    $sql->execute([':id' => $_GET['id']]);
    $engine = $sql->fetch();
    $url = '/regeng.php?action=update&id=' . $_GET['id'];
    include 'forms/regeng.php';
  break;
  
  case 'update':
    $sql = $pdo->prepare('UPDATE `engine` SET  `model` = :model, `power` = :power, `vin` = :vin WHERE `id` = :id LIMIT 1');
    $sql->execute([
      ':id' => $_GET['id'],
      ':model' => $_POST['model'],
      ':power' => $_POST['power'],
      ':vin' => $_POST['vin'],
      
    ]);
    echo 'Успешно!<br><a href="/regeng.php">Список студентов</a>';
  break;

  case 'delete':
    $sql = $pdo->prepare('DELETE FROM `engine` WHERE `id` = :id LIMIT 1');
    $sql->execute([':id' => $_GET['id']]);
    echo 'Удалено!<br><a href="/regeng.php">Список студентов</a>';
  break;

  default:

    echo '<a href="/secret.php" class="button28">Вернуться на главную</a><hr>';

    echo '<a href="/regeng.php?action=add" class="button28">Добавить</a><br>';

    $engines = $pdo->query('SELECT * FROM `engine`');


    echo '<table border="1" cellspacing="0">';

  	echo '<br>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>модель</th>';
   	echo '<th>мощность</th>';
  	echo '<th>vin</th>';
    echo '</tr>';

    foreach ($engines as $engine)
    {
      echo '<tr>';
      echo '<td>' . $engine['id'] . '</td> '  
      . '<td>' . $engine['model'] . '</td>'
      . '<td>' . $engine['power'] . '</td> ' 
      . '<td>' . $engine['vin'] . '</td>'  
      
      . '<td><a href="/regeng.php?action=edit&id=' . $engine['id'] . '">ред.</a> <a href="/regeng.php?action=delete&id=' . $engine['id'] . '">уд.</a></td>';
      echo '</tr>';

    }
    echo '</table>';

  break;
