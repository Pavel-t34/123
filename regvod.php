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
    $url = '/regvod.php?action=create';
    include 'forms/regvod.php';
  break;

  case 'create':
    $sql = $pdo->prepare('INSERT INTO `owner`(`name`, `surname`, `vod_ud`,`dob`, `cat`) VALUES (:name, :surname, :vod_ud, :dob, :cat)');
    $sql->execute([
      ':name' => $_POST['name'],
      ':surname' => $_POST['surname'],
      ':vod_ud' => $_POST['vod_ud'],
      ':dob' => $_POST['dob'],
      ':cat' => $_POST['cat'],
    ]);
    echo 'Успешно!<br><a href="/regvod.php">Список студентов</a>';
  break;
  
  case 'edit':
    $sql = $pdo->prepare('SELECT * FROM `owner` WHERE `id` = :id');
    $sql->execute([':id' => $_GET['id']]);
    $driver = $sql->fetch();
    $url = '/regvod.php?action=update&id=' . $_GET['id'];
    include 'forms/regvod.php';
  break;
  
  case 'update':
    $sql = $pdo->prepare('UPDATE `owner` SET  `name` = :name, `surname` = :surname, `vod_ud` = :vod_ud, `dob` = :dob, `cat` = :cat WHERE `id` = :id LIMIT 1');
    $sql->execute([
      ':id' => $_GET['id'],
      ':name' => $_POST['name'],
      ':surname' => $_POST['surname'],
      ':vod_ud' => $_POST['vod_ud'],
      ':dob' => $_POST['dob'],
      ':cat' => $_POST['cat'],
      
    ]);
    echo 'Успешно!<br><a href="/regvod.php">Список студентов</a>';
  break;

  case 'delete':
    $sql = $pdo->prepare('DELETE FROM `owner` WHERE `id` = :id LIMIT 1');
    $sql->execute([':id' => $_GET['id']]);
    echo 'Удалено!<br><a href="/regvod.php">Список студентов</a>';
  break;

  default:

    echo ' <a href="/secret.php" class="button28">Вернуться на главную</a> <hr>';

    echo '<a href="/regvod.php?action=add" class="button28">Добавить</a><br>';

    $drivers = $pdo->query('SELECT * FROM `owner`');


    echo '<table border="1" cellspacing="5">';
    echo '<br>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Имя</th>';
   	echo '<th>Фамилия</th>';
  	echo '<th>Вод.удостоверение</th>';
  	echo '<th>Дата</th>';
  	echo '<th>Категория</th>';
    echo '<th>&nbsp;</th>';
    echo '</tr>';

    foreach ($drivers as $driver)
    {
      echo '<tr>';
      echo '<td>' . $driver['id'] . '</td> '  
      . '<td>' . $driver['name'] . '</td>'
      . '<td>' . $driver['surname'] . '</td> ' 
      . '<td>' . $driver['vod_ud'] . '</td>'  
      . '<td>' . $driver['dob'] . '</td>'
      . '<td>' . $driver['cat'] . '</td>'
      
      . '<td><a href="/regvod.php?action=edit&id=' . $driver['id'] . '">ред.</a> <a href="/regvod.php?action=delete&id=' . $driver['id'] . '">уд.</a></td>';
      echo '</tr>';

    }
    echo '</table>';

  break;
