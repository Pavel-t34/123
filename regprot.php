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
    $url = '/regprot.php?action=create';
    include 'forms/regprot.php';
  break;

  case 'create':
    $sql = $pdo->prepare('INSERT INTO `protocol`(`date`, `violation`, `owner`, `car`, `insp`) VALUES (:date, :violation, :owner, :car, :insp)');
    $sql->execute([
      ':date' => $_POST['date'],
      ':violation' => $_POST['violation'],
      ':owner' => $_POST['owner'],
      ':car' => $_POST['car'],
      ':insp' => $_POST['insp'],
    ]);
    echo 'Успешно!<br><a href="/regprot.php">Список студентов</a>';
  break;
  
  case 'edit':
    $sql = $pdo->prepare('SELECT * FROM `protocol` WHERE `id` = :id');
    $sql->execute([':id' => $_GET['id']]);
    $protokol = $sql->fetch();
    $url = '/regprot.php?action=update&id=' . $_GET['id'];
    include 'forms/regprot.php';
  break;
  
  case 'update':
    $sql = $pdo->prepare('UPDATE `protocol` SET  `date` = :date, `violation` = :violation, `owner` = :owner, `car` = :car, `insp` = :insp WHERE `id` = :id LIMIT 1');
    $sql->execute([
      ':date' => $_GET['date'],
      ':violation' => $_POST['violation'],
      ':owner' => $_POST['owner'],
      ':car' => $_POST['car'],
      ':insp' => $_POST['insp'],
      
    ]);
    echo 'Успешно!<br><a href="/regprot.php">Список студентов</a>';
  break;

  case 'delete':
    $sql = $pdo->prepare('DELETE FROM `protocol` WHERE `id` = :id LIMIT 1');
    $sql->execute([':id' => $_GET['id']]);
    echo 'Удалено!<br><a href="/regprot.php">Список студентов</a>';
  break;

  default:

    echo '[ <a href="/">Вернуться на главную</a> ]<hr>';

    echo '<a href="/regprot.php?action=add">Добавить</a><br>';

    $protokols = $pdo->query('SELECT * FROM `protocol`');


    echo '<table border="1" cellspacing="0">';

    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Дата</th>';
   	echo '<th>Нарушение</th>';
  	echo '<th>Водитель</th>';
  	echo '<th>Автомобиль</th>';
 	  echo '<th>Инспектор</th>';
    echo '</tr>';

    foreach ($protokols as $protokol)
    {
      echo '<tr>';
      echo '<td>' . $protokol['id'] . '</td> '  
      . '<td>' . $protokol['date'] . '</td>'
      . '<td>' . $protokol['violation'] . '</td> ' 
      . '<td>' . $protokol['owner'] . '</td>'
      . '<td>' . $protokol['car'] . '</td> ' 
      . '<td>' . $protokol['insp'] . '</td>'
      
      . '<td><a href="/regprot.php?action=edit&id=' . $protokol['id'] . '">ред.</a> <a href="/regprot.php?action=delete&id=' . $protokol['id'] . '">уд.</a></td>';
      echo '</tr>';

    }
    echo '</table>';

  break;
