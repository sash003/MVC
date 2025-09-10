<?php

session_start();

header ("Content-Type:text/html; charset=UTF-8", false);

// запрет кэширования
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0", false);
header("Pragma: no-cache");





if(isset($_GET['href'])){
  $href = $_GET['href'];
  $file = include "template/views".$href;
  exit($file);
}



mb_internal_encoding("UTF-8");
error_reporting(E_ALL);
ini_set('display_startup_errors', 1);
ini_set('display_errors', '1');




class AjaxController{

  function __construct(){
    $xml      = simplexml_load_file(__DIR__.'/config/db_conf.xml');
    $host     = $xml->host[0];
    $dbname   = $xml->dbname[0];
    $user     = $xml->user[0];
    $password = $xml->password[0];

    $db       = $this->db = new \PDO('mysql: host='.$host.'; dbname='. $dbname, $user, $password);

    $db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    $db->exec("SET NAMES 'utf8'");
    $db->exec("SET CHARACTER SET 'utf8'");
    $db->exec("SET SESSION collation_connection = 'utf8_general_ci'");
    /*
    $books = ['Шримад Бхагаватам', 'Бхагавад Гита', 'Чайтанья Чаритамрита'];
    $images = ['bhagavatam', 'bhagavad_gita', 'charitamrita'];
    for($i = 0; $i < 333; $i++){
    foreach($books as $key=>$value){
    $this->query("insert into `books` (`book`, `img`) values (?,?)", [$value, $images[$key]]);
    }
    }
    */
  }



  function exitUser()
  {
    $_SESSION['name'] = null;
    $_SESSION['ava'] = null;
    unset($_SESSION['name']);
    unset($_SESSION['ava']);
    setcookie('name', null, - 1, '/');
  }
  
  
  
  
  function forumSearch(){
    $search = $this->escapeSearch($_POST['uSearch']);
    $array1 = array(); $array2 = array(); $array = array(); $array3 = array();
    $data1  = $this->query2("select `id` from `forum` where `title` like concat('%',?,'%')", array($search));
    $data2  = $this->query2("select `id` from `forum` where `question` like concat('%',?,'%')", array($search));
    if($data1){
      foreach($data1 as $id){
        $array1[] = $id['id'];
      }
    }
    if($data2){
      foreach($data2 as $id){
        $array2[] = $id['id'];
      }
    }
    $data3  = $this->query2("select `parent` from `answers` where `answer` like concat('%',?,'%')", array($search));
    if($data3){
      foreach($data3 as $id){
        $array3[] = $id['parent'];
      }
    }
    if($array1 || $array2 || $array3){
      $array = array_merge($array1, $array2, $array3);
      
      $array = array_unique($array);
    }
    if($array){
      $str = "<div style='padding: 55px 0 33px 25%;'>";
      foreach($array as $id){
        $data  = $this->query2("select `title` from `forum` where `id`=$id");
        $title = $data[0]['title'];
        $str .= "<div style='padding: 17px 0;'><a target='_blank' style='font-size: 33px; font-style: italic;' href='/forum/question/$id'>$title</a></div>";
      }
      $str .= "</div>";
      echo $str;
    }
  }
  
  
  
  
  
  public function query2($query, array $values = array(
    ), $param = false)
  {
    try
    {
      $stmt       = $this->db->prepare($query);
      $values_len = count($values);

      for($i = 0; $i < $values_len; $i++){
        $value = trim($values[$i]);
        if(preg_match('/^\d+$/', $value)){
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_INT);
        }
        else
        {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_STR);
        }
      }
      $stmt->execute($values);
      if(!$param){
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      }
      else
      {
        return $stmt->rowCount();
      }
      return $stat;
    } catch(\PDOException $err){
      echo 'Ошибка при выборке из БД ' . $err->getMessage(). '<br>
      в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString());
      exit;
    }

  }
  
  
  
  
  
  function setLike2(){
    $id = intval($_POST['id']);
    if(isset($_SESSION['name'])){
      $name = $_SESSION['name'];
    }else{
      exit('3');
    }
    $toWho = $this->escapeStr($_POST['name']);
    if(!$name)echo(3);
    $data = $this->query("select `likes` from `answers` where `id`=?", array($id));
    $likes = $data[0]['likes'];
    if(!preg_match("/$name/", $likes)){
      $likes .= $name.",";
      $this->query("update `answers` set `likes`=? where `id`=?", array($likes, $id), 1);
      $this->query("update `users` set `likes`=`likes`+1 where `name`=?", array($toWho), 1);
      echo(1);
    }else{
      $likes = str_replace($name.",", "", $likes);
      $this->query("update `answers` set `likes`=? where `id`=?", array($likes, $id), 1);
      $this->query("update `users` set `likes`=`likes`-1 where `name`=?", array($toWho), 1);
      echo(2);
    }
  }
  
  
  
  
  function registerUser2()
  {

    $email       = $this->escapeStr($_REQUEST["email"], 55);
    $name        = $this->escapeStr($_REQUEST["name"], 55);
    $pass        = $this->escapeStr($_REQUEST["pass"], 22);
    $pathToAva   = "";
    $isChangeAva = "";

    if(($email && !$pass) || ($name && !$pass) || (!$email && !$name))
    {
      exit("Заполните поляяя");
    }

    $is = $this->query("select * from `users` where `email`=? and `pass`=?", array($email, $pass), 1);
    $is2= $this->query("select * from `users` where `name`=? and `pass`=?", array($name, $pass), 1);
    if($is || $is2){
      $userData = $this->query("select * from `users` where (`name`=? or `email`=?) and `pass`=? and `confirm`=1", array($name, $email, $pass));
      if(!$userData)exit("Вы не подтвердили регистрацию");
      $email = $userData[0]['email'];
      $name  = $_SESSION['name'] = $userData[0]['name'];
      $filename = str_replace("@", "_", $email);

      if($_FILES['image']['tmp_name'])
      {
        $img = glob("./template/studio/users/$filename*");

        if($img){
          foreach($img as $image){
            unlink($image);
          }
        }
        $filename = str_replace("@", "_", $email);
        $pathToAva= $this->uploadFile($filename);

        $this->query("update `users` set `ava`=? where `name`=?", array($pathToAva, $name), 1);
        $_SESSION['ava'] = $pathToAva;
        $isChangeAva = "<br/>Аватар изменён";

      }
      else
      {
        $pathToAva = $userData[0]['ava'];
      }


      setcookie('name', $name, time() + 7777777, "/");
      echo("Вы дома<br/>Выйти уже не получится <img src='/template/studio/smiles/4.gif' alt='' />$isChangeAva pathToAva".$pathToAva);
      $_SESSION['name'] = $name;
      exit;
    }
    else
    {
      if(!($email && $name && $pass))
      {
        exit("Заполните поляяя");
      }
      $hash = md5($email);
      $hash = substr($hash, 0, 32);
      if($_FILES['image']['tmp_name']){
        $filename = str_replace("@", "_", $email);
        $ava      = $pathToAva= $this->uploadFile($filename);

        $_SESSION['ava'] = $pathToAva;
        $pathToAva = "pathToAva".$pathToAva;
      }
      else $ava        = 'lotos.jpg';
      $insertUser = $this->query("insert into `users` (`email`, `name`, `login`, `pass`, `time`, `hash`, `ava`) values (?,?,?,?,?,?,?)", array($email, $name, $name, $pass, time(), $hash, $ava), 1);
      if(!$insertUser)exit( - 1);



      $to      = $email;

      // тема письма
      $subject = 'Приветствую на сайте)';

      // текст письма
      $message = "
      <html>
      <head>
      <title></title>
      </head>
      <body style='background: url(http://waytohome.online/template/studio/img/1.png); height: 234px; background-size: 100% 100%;'>
      <div style='display: inline-block; font-size: 33px; margin: 55px; color: #e4851b;'>$name / $pass<br/><br/>
      <a style='color: #1b630e; font-style: italic;' href='http://waytohome.online/forum/$hash'>Подтвердите регистрацию</a>
      </div>
      </body>
      </html>
      ";

      // Для отправки HTML - письма должен быть установлен заголовок Content - type
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

      $headers .= 'From: Creative*Web <webmaster@waytohome.online>'."\r\n";

      @mail($to, $subject, $message, $headers);
      echo "Потдвердите регистрацию, письмо выслали".$pathToAva;

      exit;
    }

  }

  





  function changeAva(){
    if(isset($_FILES['file'])){
      $name = $_SESSION['name'];
      if(!$name)exit;
      $data = $this->query("select `email` from `users` where `name`=?", array($name));
      $email = $data[0]['email'];
      $filename = str_replace("@", "_", $email);
      $file = $this->uploadFile4($filename);
      
      $this->query("update `users` set `ava`=? where `name`=?", array($file, $name), 1);
      
      echo $file;
    }
  }
  
  
  
  
   function uploadFile4($namefile)
  {
    if(is_uploaded_file($_FILES['file']['tmp_name']))
    {
      $tmp              = $_FILES['file']['tmp_name'];
      $size             = $_FILES['file']['size'];
      $type             = $this->get_mimeType($tmp);
      //echo $type;
      $supportMimeTypes = array(
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/x-ms-bmp",
      );

      if(!in_array($type, $supportMimeTypes) || $size > 5 * 1024 * 1024)
      {
        exit('Файл не катит');
      }

      $info = new SplFileInfo($_FILES['file']['name']);
      $ext  = $info->getExtension();
      $dir  = './template/studio/users';
      $path = $dir.'/'.$namefile.".".$ext;

      if(move_uploaded_file($_FILES['file']['tmp_name'], $path))
      {
        return $namefile.".".$ext;
      }
      else
      {
        exit('Не удалось загрузить файл');
      }
    }
  }



function uploadFile($namefile)
  {
    if(is_uploaded_file($_FILES['image']['tmp_name']))
    {
      $tmp              = $_FILES['image']['tmp_name'];
      $size             = $_FILES['image']['size'];
      $type             = $this->get_mimeType($tmp);
      //echo $type;
      $supportMimeTypes = array(
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/x-ms-bmp",
      );

      if(!in_array($type, $supportMimeTypes) || $size > 5 * 1024 * 1024)
      {
        exit('Файл не катит');
      }

      $info = new SplFileInfo($_FILES['image']['name']);
      $ext  = $info->getExtension();
      $dir  = './template/studio/users';
      $path = $dir.'/'.$namefile.".".$ext;

      if(move_uploaded_file($_FILES['image']['tmp_name'], $path))
      {
        return $namefile.".".$ext;
      }
      else
      {
        exit('Не удалось загрузить файл');
      }
    }
  }



  function updateSig(){
    $name = $_SESSION['name'];
    if(!$name)exit;
    $text = $this->escapeStr2($_POST['text']);
    $done = $this->query("update `users` set `signature`=? where `name`=?", array($text, $name), 1);
    exit($done);
  }

  function updateUserData4(){
    $name = $_SESSION['name'];
    if(!$name)exit;
    $toWho = $this->escapeStr($_POST['toWho']);
    $text = $this->escapeStr2($_POST['text']);
    $text = "<br/><span class='nick'>$name:</span>  $text<br/>";
    $done = $this->query("update `userdata` set `data4`=concat (`data4`, ?) where `name`=?", array($text, $toWho), 1);
    exit($done);
  }

  function updateUserData3(){
    $name = $_SESSION['name'];
    if(!$name)exit;
    $text = $this->escapeStr2($_POST['text']);
    $done = $this->query("update `userdata` set `data3`=? where `name`=?", array($text, $name), 1);
    exit($done);
  }
  
  
  function updateUserData(){
    $name = $_SESSION['name'];
    if(!$name)exit;
    $dataId = $this->escapeStr($_POST['dataId']);
    $text = $this->escapeStr2($_POST['text']);
    $text = trim($text, "3***3");
    $done = $this->query("update `userdata` set `$dataId`=? where `name`=?", array($text, $name), 1);
    exit($done);
  }
  
  
  function updateUserData2(){
    $name = $_SESSION['name'];
    if(!$name)exit;
    $text = $_POST['text'];
    $done = $this->query("update `userdata` set `data2`=? where `name`=?", array($text, $name), 1);
    exit($done);
  }




  function delAnswer()
  {
    $name = $_SESSION['name'];
    $id   = intval($_POST['id']);
    $this->query("update `forum` set `answers`=`answers`-1 where `id`=(select `parent` from `answers` where `id`=?); update `users` set `answers`=`answers`-1 where `name`=?", array($id, $name), 1);
    $data = $this->query("delete from `answers` where `id`=? and `name`=?", array($id, $name), 1);
    exit($data);
  }




  function getPost()
  {
    $name = $_SESSION['name'];
    $id   = intval($_POST['id']);
    $data = $this->query("select `original` from `forum` where `id`=? and `name`=?", array($id, $name));
    if($data){
      exit($data[0]['original']);
    }
  }




  function getAnswer()
  {
    $name = $_SESSION['name'];
    $id   = intval($_POST['id']);
    $data = $this->query("select `original` from `answers` where `id`=? and `name`=?", array($id, $name));
    if($data){
      exit($data[0]['original']);
    }
  }




  function redactAnswer()
  {
    $name = $_SESSION['name'];
    $id   = intval($_POST['id']);
    $data = $this->query("select `id` from `answers` where `id`=? and `name`=?", array($id, $name));
    if($data){
      $file     = "";
      $original = $newText  = $this->escapeStr2($_POST['message_text'], 9999);
      if(isset($_FILES['file2']) && is_uploaded_file($_FILES['file2']['tmp_name'][0])){
        $file = $this->uploadFile3();
      }
      $newText = $this->setCode($newText).$file;
      $time    = time();
      $update  = $this->query("update `answers` set `answer`=?, `original`=?, `change`=? where `id`=?", array($newText, $original, $time, $id), 1);
      if($update)
      {
        $data  = $this->query("select `signature` from `users` where `name`=?", array($name));
        $signature = $data[0]['signature'];
        $newText = "   <span class='signature'>$signature</span><span style='font-size: 22px;'>Обновлен</span> <span class='time'>$time</span><div class='redText'>    ".$newText."</div>".
        "</tr>";
        exit($newText);
      }
    }
  }







  function redactPost()
  {
    $name = $_SESSION['name'];
    $id   = intval($_POST['id']);
    $data = $this->query("select `title` from `forum` where `id`=? and `name`=?", array($id, $name));
    if($data){
      $title    = $data[0]['title'];
      $file     = "";
      $original = $newText  = $this->escapeStr2($_POST['message_text'], 9999);
      if(isset($_FILES['file2']) && is_uploaded_file($_FILES['file2']['tmp_name'][0])){
        $file = $this->uploadFile3();
      }
      $newText = $this->setCode($newText).$file;
      $time    = time();

      $update  = $this->query("update `forum` set `question`=?, `change`=?, `original`=? where `id`=?", array($newText, $time, $original, $id), 1);
      if($update)
      {
        $data  = $this->query("select `signature` from `users` where `name`=?", array($name));
        $signature = $data[0]['signature'];
        $newText = "<h1 id='postH1' style='margin-bottom: 0; padding-bottom: 5px;'>$title</h1>   <span class='signature'>$signature</span><span style='font-size:22px;'>Обновлен </span><span class='time'>$time</span><div class='redText'>    ".$newText."</div>".
        "</tr>";
        exit($newText);
      }
    }
  }





  function setAnswer()
  {
    if(!isset($_SESSION['name'])){
      exit;
    }    
    if(mb_strlen($_POST['message_text']) > 9999){
      exit(2);
    }
    $name     = $this->escapeStr($_POST['name'], 55);
    $parent   = intval($_POST['id']);

    $file     = "";

    $original = $answer   = $this->escapeStr2($_POST['message_text'], 9999);

    if(isset($_FILES['file2']) && is_uploaded_file($_FILES['file2']['tmp_name'][0])){
      $file = $this->uploadFile3();
    }
    $answer = $this->setCode($answer).$file;
    $time   = time();
    
    $insert = $this->query("insert into `answers` (`parent`,`name`, `answer`, `time`, `original`) values (?,?,?,?,?); update `forum` set `answers`=`answers`+1 where `id`=?", array($parent, $name, $answer, $time, $original, $parent), 1, 1);
    $data = $this->query2("select `name` from `forum` where `id`=?", array($parent));
    $name2 = $data[0]['name'];
    if($name != $name2){
      $this->query("update `users` set `answers`=`answers`+1 where `name`=?", array($name), 1);
    }
    
    if($insert)
    {
      $data   = $this->query("select `ava`,`answers`,`likes`, `signature` from `users` where `name`=?", array($name));
      $ava    = $data[0]['ava'];
      $answers= $data[0]['answers'];
      $likes  = $data[0]['likes'];
      $signature = $data[0]['signature'];
      $ava    = "<img src='/template/studio/users/$ava' style='width:90%; margin:5%; height:auto;' />";
      $answer = "<tr data-id='$insert'>".
      "<td><a class='unick' style='color:#FBB64F;' href='/forum/profile/$name'><b>$name</b><br/>$ava</a><div class='pods'><span style='cursor:pointer;' title='Ответов'><a>$answers</a></span> / <span style='cursor:pointer;' title='Полезных ответов'><a>$likes</a></span></div></td>".
      "<td>  <span class='signature'>$signature</span><span class='time'>$time</span><div class='redText'>   ".$answer."</div></td>".
      "</tr>";

      if(isset($_POST['toWho'])){
        $to     = $this->escapeStr($_POST['toWho']);
        $postId = intval($_POST['id']);
        $href   = "<a href='http://waytohome.online/forum/question/$postId' style='color: #549f0f; font-size: 33px;'>http://waytohome.online/forum/question/$postId</a>";
        $data   = $this->query("select `email` from `users` where `name`=?", array($to));
        $email  = $data[0]['email'];


        $to     = $email;

        // тема письма
        $subject= 'Вам ответили в теме форума';

        // текст письма
        $message= "
        <html>
        <head>
        <title></title>
        </head>
        <body style='background: url(http://waytohome.online/template/studio/img/1.png); height: 222px; background-size: 100% 100%;'>
        <div style='display: inline-block; font-size: 33px; margin: 55px;'>$href<br/><br/>

        </div>
        </body>
        </html>
        ";

        // Для отправки HTML - письма должен быть установлен заголовок Content - type
        $headers= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Creative*Web Forum <webmaster@waytohome.online>'."\r\n";
        // Отправляем
        @mail($to, $subject, $message, $headers);
      }
      else
      {
        $toWho = $this->query("select `email` from `users` where `name`=(select `name` from `forum` where `id`=?)", array($parent));
        $postId = intval($_POST['id']);
        $toWho = $toWho[0]['email'];

        $href = "<a href='http://waytohome.online/forum/question/$postId' style='color: #549f0f; font-size: 33px;'>http://waytohome.online/forum/question/$postId</a>";

        $to = $toWho;

        // тема письма
        $subject = 'Вам ответили в теме форума';

        // текст письма
        $message = "
        <html>
        <head>
        <title></title>
        </head>
        <body style='background: url(http://waytohome.online/template/studio/img/1.png); height: 222px; background-size: 100% 100%;'>
        <div style='display: inline-block; font-size: 33px; margin: 55px;'>$href<br/><br/>

        </div>
        </body>
        </html>
        ";

        // Для отправки HTML - письма должен быть установлен заголовок Content - type
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: Creative*Web Forum <webmaster@waytohome.online>'."\r\n";
        // Отправляем
        @mail($to, $subject, $message, $headers);
      }

      exit($answer);
    }

  }






  function setQuestion()
  {

    if(!isset($_SESSION['name'])){
      exit;
    }
    if(mb_strlen($_POST['message_text']) > 9999){
      exit;
    }
    $name     = $this->escapeStr($_POST['name'], 55);
    $title    = $this->escapeStr($_POST['title'], 123);
    $adres    = $this->escapeStr($_POST['category'], 22);
    
    if(!$title || !$_POST['message_text']){
      return;
    }
    
    $file     = "";

    $original = $question = $this->escapeStr2($_POST['message_text'], 9999);
    if(isset($_FILES['file2']) && is_uploaded_file($_FILES['file2']['tmp_name'][0])){
      $file = $this->uploadFile3();
    }
    $question = $this->setCode($question).$file;
    $time     = time();
    $insert   = $this->query("insert into `forum` (`name`, `category`,`title`, `question`, `time`, `original`) values (?,?,?,?,?,?)", array($name, $adres, $title, $question, $time, $original), 1, 1);
    //$_SESSION['time'][$insert] = $time;
    $this->query("update `users` set `posts`=`posts`+1 where `name`=?", array($name), 1);
    exit($insert);
  }




  function uploadFile3()
  {
    if(!isset($_FILES['file2']['tmp_name'][0]))return;

    $total_files = count($_FILES['file2']['name']);
    $str         = ""; $imgs        = "";
    for($key = 0; $key < $total_files; $key++){

      if(is_uploaded_file($_FILES['file2']['tmp_name'][$key]))
      {
        $tmp              = $_FILES['file2']['tmp_name'][$key];
        $size             = $_FILES['file2']['size'][$key];
        $type             = $this->get_mimeType($tmp);
        //echo $type;
        $supportMimeTypes = array(
          "image/jpg",
          "image/jpeg",
          "image/png",
          "image/gif",
          "image/x-ms-bmp",
          "image/vnd.djvu",
          "image/vnd.adobe.photoshop",
          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
          "text/plain",
          "text/rtf",
          "application/pdf",
          "application/msword",
          "application/x-rar",
          "application/zip",
          "application/xml",
          "audio/mpeg"
        );

        if(!in_array($type, $supportMimeTypes) || $size > 10 * 1024 * 1024)
        {
          return("<div style='padding: 20px;'>Файл слишком большой или имеет неподдерживаемый формат</div>");
        }

        $dir      = './template/attachments';
        $namefile = $_FILES['file2']['name'][$key];
        $namefile = mb_convert_encoding($namefile, "UTF-8");
        $namefile = preg_replace('/[^\wа-яё.]/iu', '_', $namefile);
        $namefile = $this->translit($namefile);
        $path     = $dir.'/'.$namefile;

        if(move_uploaded_file($_FILES['file2']['tmp_name'][$key], $path))
        {
          $path = mb_substr($path, 1);
          if(preg_match("/image\/(jpg|jpeg|png|bmp|gif)/",$type))
          {
            $imgs .= "<img src='$path' class='attachImg' alt=''/>";
          }
          elseif(preg_match("/image\/gif/",$type))
          {
            $imgs .= "<img src='$path' class='gif' alt=''/>";
          }
          else
          {
            switch($type)
            {
              case 'application/x-rar': $img = "<img class='filesimg' src='/template/images/filesimg/rar.png' alt=''> ";
              break;
              case 'application/zip': $img = "<img class='filesimg' src='/template/images/filesimg/rar.png' alt=''> ";
              break;
              case 'image/vnd.adobe.photoshop': $img = "<img class='filesimg' src='/template/images/filesimg/psd.png' alt=''> ";
              break;
              case 'application/pdf': $img = "<img class='filesimg' src='/template/images/filesimg/pdf.png' alt=''> ";
              break;
              case 'image/vnd.djvu': $img = "<img class='filesimg' src='/template/images/filesimg/djvu.png' alt=''> ";
              break;
              case 'text/plain': $img = "<img class='filesimg' src='/template/images/filesimg/txt.png' alt=''> ";
              break;
              case 'application/xml': $img = "<img class='filesimg' src='/template/images/filesimg/xml.png' alt=''> ";
              break;
              case 'audio/mpeg': $img = '<audio controls preload="metadata">
              <source src="'.$path.'" type="audio/mpeg">
              </audio>';
              break;
              default: $img = "<img class='filesimg' src='/template/images/filesimg/word.png' alt=''>";
              break;
            }

            $path = $type == "audio/mpeg" ? $img : "<br/><a class='a' href='$path' download>$img $namefile</a><br/>";
            $str .= $path;
          }

        }
        else
        {
          return("<div>Файл слишком большой или имеет неподдерживаемый формат</div>");
        }
      }
      else
      {
        return("<div>Файл слишком большой или имеет неподдерживаемый формат</div>");
      }
    }
    return "<div style='padding:1em 0 0 1em;'>$str <div style='text-align:left;'>$imgs</div></div>";
  }





  function setLike()
  {
    $post = $this->escapeStr($_POST['post'], 33);
    $punct= $this->escapeStr($_POST['punct'], 1);
    echo $this->query("update `posts` set `likes`=`likes` $punct 1 where `href`=?", array($post), 1);
  }


  function getScroll()
  {
    $id = (int)$_POST['id'];
    $count = 12;
    $lastId= $this->query("select `id` from `books` order by `id` desc limit 1");
    $lastId= $lastId[0]['id'];
    if($id >= $lastId){
      exit();
    }
    $result = $this->query("select * from `books` where `id` BETWEEN ? AND ?", array($id + 1, $id + $count - 1));
    exit(json_encode($result));
  }






  function getSelect()
  {
    $names = $_POST['names'];

    if(isset($names['country']) && $names['country'] == 'all')
    {
      $result = $this->query("select distinct `country` from `places` order by `country`");
      exit(json_encode($result));
    }
    else
    {
      $val = $this->escapeStr($names['val']);
      $name= $this->escapeStr($names['name']);
      if($name == 'country'){
        $select = 'city';
      }
      if($name == 'city'){
        $select = 'street';
      }
      $result = $this->query("select distinct `$select` from `places` where `$name`=? order by `$select`", array($val));
      exit(json_encode($result));
    }
  }




  public function query($query, array $values = array(
    ), $param = false, $param2 = false)
  {
    try
    {
      $stmt       = $this->db->prepare($query);
      $values_len = count($values);

      for($i = 0; $i < $values_len; $i++)
      {
        $value = trim($values[$i]);
        if(preg_match('/^\d+$/', $value))
        {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_INT);
        }
        else
        {
          $stmt->bindValue($i + 1, $value, \PDO::PARAM_STR);
        }
      }
      $stmt->execute($values);
      if(!$param)
      {
        return $stmt->fetchAll();
      }
      else
      {
        if($param2){
          return $this->db->lastInsertId();
        }
        else
        {
          return $stmt->rowCount();
        }
      }
      return $stat;
    } catch(\PDOException $err)
    {
      echo 'Ошибка при выборке из БД ' . $err->getMessage(). '<br>
      в файле '.$err->getFile().", строка ".$err->getLine() . "<br><br>Стэк вызовов: " . preg_replace('/#\d+/', '<br>$0', $err->getTraceAsString());
      exit;
    }

  }

  public function escapeStr($str, $size = 0)
  {
    $mat = file_get_contents(__DIR__.'/template/forum/filter/mat.txt');
    $str = trim($str);
    $str = preg_replace("/".$mat."/", '', $str);
    $str = preg_replace('/[`\'\"\(\)\[\]]/', '', $str);
    $str = htmlentities($str, ENT_QUOTES, "UTF-8");
    if($size)$str = mb_substr($str, 0, $size, "UTF-8");
    return $str;
  }


  public function escapeStr2($str, $size = 0)
  {
    $mat = file_get_contents(__DIR__.'/template/forum/filter/mat.txt');
    $str = trim($str);
    $str = preg_replace("/".$mat."/", '', $str);
    $str = htmlentities($str, ENT_QUOTES, "UTF-8");
    if($size)$str = mb_substr($str, 0, $size, "UTF-8");
    return $str;
  }


  public function escapeSearch($str)
  {
    $str = htmlentities($str, ENT_QUOTES, "UTF-8");
    $str = mb_substr($str, 0, 22, "UTF-8");
    return $str;
  }
   

  function registerUser()
  {

    $email       = $this->escapeStr($_REQUEST["email"], 55);
    $name        = $this->escapeStr($_REQUEST["name"], 55);
    $pass        = $this->escapeStr($_REQUEST["pass"], 22);
    $pathToAva   = "";
    $isChangeAva = "";

    if(($email && !$pass) || ($name && !$pass) || (!$email && !$name))
    {
      exit("Заполните поляяя");
    }

    $is = $this->query("select * from `users` where `email`=? and `pass`=?", array($email, $pass), 1);
    $is2= $this->query("select * from `users` where `name`=? and `pass`=?", array($name, $pass), 1);
    if($is || $is2){
      $userData = $this->query("select * from `users` where (`name`=? or `email`=?) and `pass`=?", array($name, $email, $pass));
      $email    = $userData[0]['email'];
      $name     = $userData[0]['name'];
      $filename = str_replace("@", "_", $email);

      $img      = glob("./template/studio/users/$filename*");

      if($img){
        $pathToAva = str_replace("./template/studio/users/", "", $img[0]);
        setcookie('ava', $pathToAva, time() + 7777777, "/");
      }

      if($_FILES['image']['tmp_name'])
      {
        $img = glob("./template/studio/users/$filename*");

        if($img){
          foreach($img as $image){
            unlink($image);
          }
        }
        $filename    = str_replace("@", "_", $email);
        $pathToAva   = $this->uploadFile($filename);
        setcookie('ava', $pathToAva, time() + 7777777, "/");
        $isChangeAva = "<br/>Аватар изменён";
      }


      setcookie('email', $email, time() + 7777777, "/");
      setcookie('name', $name, time() + 7777777, "/");
      echo("Вы дома<br/>Выйти уже не получится <img src='/template/studio/smiles/4.gif' alt='' />$isChangeAva pathToAva".$pathToAva);
      $_SESSION['name'] = $name;
      exit;
    }
    else
    {
      if(!($email && $name && $pass))
      {
        exit("Заполните поляяя");
      }

      $insertUser = $this->query("insert into `users` (`email`, `name`, `login`, `pass`, `time`) values (?,?,?,?,?,?)", array($email, $name, $name, $pass, time()), 1);
      if(!$insertUser)exit( - 1);
      if($_FILES['image']['tmp_name']){
        $filename = str_replace("@", "_", $email);
        $pathToAva= $this->uploadFile($filename);
        setcookie('ava', $pathToAva, time() + 7777777, "/");
        $pathToAva= "pathToAva".$pathToAva;
      }
      setcookie('email', $email, time() + 7777777, "/");
      setcookie('name', $name, time() + 7777777, "/");

      echo "Всё, вы дома".$pathToAva;

      $_SESSION['name'] = $name;

      $to      = $email;

      // тема письма
      $subject = 'Приветствую на сайте)';

      // текст письма
      $message = "
      <html>
      <head>
      <title></title>
      </head>
      <body style='background: url(http://waytohome.online/template/studio/img/1.png); height: 222px; background-size: 100% 100%;'>
      <div style='display: inline-block; font-size: 33px; margin: 55px;'>$name / $pass<br/><br/>
      <a href='http://waytohome.online/forum/$hash'>Подтвердите регистрацию</a>
      </div>
      </body>
      </html>
      ";

      // Для отправки HTML - письма должен быть установлен заголовок Content - type
      $headers = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

      // Дополнительные заголовки
      //$headers .= "To: $name < $email > "."\r\n";
      $headers .= 'From: Creative*Web <webmaster@waytohome.online>'."\r\n";
      //$headers .= 'Cc: webmaster@waytohome.online'."\r\n";
      //$headers .= 'Bcc: webmaster@waytohome.online'."\r\n";

      // Отправляем
      @mail($to, $subject, $message, $headers);

      exit;
    }

  }






  function get_mimeType($filename)
  {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $filename);
    finfo_close($finfo);
    return $mime;
  }






  function search()
  {
    $search = $_REQUEST['poisk'];
    $search = $this->escapeStr($search, 33);
    //echo $search;
    $search = $this->query("select * from `posts` where `title` like concat('%', ?, '%') or `text` like concat('%', ?, '%') or `category` like concat('%', ?, '%') or `description` like concat('%', ?, '%')", array($search, $search, $search, $search));
    $posts  = "";
    foreach($search as $post)
    {
      $title       = $post['title'];
      $category    = $post['category'];
      $description = $post['description'];
      $href        = $post['href'];
      $created_at  = $post['created_at'];
      $posts .= "<div class='grid_box'>
      <h4 class='post_title'>
      <a href='/studio/$category/$href'>$title</a>
      </h4>
      <div class='post_preview'>
      <div class='cat_icon'>
      <img src='/template/studio/img/$category.png' alt=''>
      </div>
      $description
      </div>
      <div class='post_meta'>
      <span class='post_date'>
      $created_at
      </span>
      <span class='post_tags'>
      <a href='/studio/$category' rel='tag'>$category</a>
      </span>
      </div>
      </div>";
    }
    if(!$posts)$posts = "<span style='font-size: 25px;'>Ничего не найдено</span>";
    echo $posts;
  }





  function uploadFile2()
  {
    if(is_uploaded_file($_FILES['file2']['tmp_name']))
    {
      $tmp              = $_FILES['file2']['tmp_name'];
      $size             = $_FILES['file2']['size'];
      $type             = $this->get_mimeType($tmp);
      //echo $type;
      $supportMimeTypes = array(
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/x-ms-bmp",
        "image/vnd.djvu",
        "image/vnd.adobe.photoshop",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
        "text/plain",
        "text/rtf",
        "application/pdf",
        "application/msword",
        "application/x-rar",
        "application/zip",
        "application/xml",
        "audio/mpeg"
      );

      if(!in_array($type, $supportMimeTypes) || $size > 10 * 1024 * 1024)
      {
        return("<div style='height:7px;'></div><div>Файл слишком большой или имеет неподдерживаемый формат</div>");
      }

      $dir      = './template/attachments';
      $namefile = $_FILES['file2']['name'];
      $namefile = mb_convert_encoding($namefile, "UTF-8");
      $namefile = preg_replace('/[^\wа-яё.]/iu', '_', $namefile);
      $namefile = $this->translit($namefile);
      $path     = $dir.'/'.$namefile;

      if(move_uploaded_file($_FILES['file2']['tmp_name'], $path))
      {
        $path = mb_substr($path, 1);
        if(preg_match("/image\/(jpg|jpeg|png|bmp|gif)/",$type))
        {
          $path = "<div style='height:7px;'></div><img src='$path' class='attachImg' alt=''/>";
        }
        elseif(preg_match("/image\/gif/",$type))
        {
          $path = "<div style='height:7px;'></div><img src='$path' class='gif' alt=''/>";
        }
        else
        {
          switch($type)
          {
            case 'application/x-rar': $img = "<img class='filesimg' src='/template/images/filesimg/rar.png' alt=''> ";
            break;
            case 'application/zip': $img = "<img class='filesimg' src='/template/images/filesimg/rar.png' alt=''> ";
            break;
            case 'image/vnd.adobe.photoshop': $img = "<img class='filesimg' src='/template/images/filesimg/psd.png' alt=''> ";
            break;
            case 'application/pdf': $img = "<img class='filesimg' src='/template/images/filesimg/pdf.png' alt=''> ";
            break;
            case 'image/vnd.djvu': $img = "<img class='filesimg' src='/template/images/filesimg/djvu.png' alt=''> ";
            break;
            case 'text/plain': $img = "<img class='filesimg' src='/template/images/filesimg/txt.png' alt=''> ";
            break;
            case 'application/xml': $img = "<img class='filesimg' src='/template/images/filesimg/xml.png' alt=''> ";
            break;
            case 'audio/mpeg': $img = '<audio controls preload="metadata">
            <source src="'.$path.'" type="audio/mpeg">
            </audio>';
            break;
            default: $img = "<img class='filesimg' src='/template/images/filesimg/word.png' alt=''>";
            break;
          }

          $path = $type == "audio/mpeg" ? $img : "<div style='height:7px;'></div><a class='a' href='$path' download>$img $namefile</a>";
        }
        return $path;
      }
      else
      {
        return("<div style='height:7px;'></div><div>Файл слишком большой или имеет неподдерживаемый формат</div>");
      }
    }
    else
    {
      return("<div style='height:7px;'></div><div>Файл слишком большой или имеет неподдерживаемый формат</div>");
    }
  }






  function translit($str)
  {
    $rus = array('А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я','а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я');
    $lat = array('A','B','V','G','D','E','E','Gh','Z','I','Y','K','L','M','N','O','P','R','S','T','U','F','H','C','Ch','Sh','Sch','Y','Y','Y','E','Yu','Ya','a','b','v','g','d','e','e','gh','z','i','y','k','l','m','n','o','p','r','s','t','u','f','h','c','ch','sh','sch','y','y','y','e','yu','ya');
    return str_replace($rus, $lat, $str);
  }






  function setCode($text)
  {
    
    $text = preg_replace('/\[JAVA\]([\S\s]*?)\[\\\\JAVA\]/usi', "<pre><code class='language-java'>$1</code></pre>", $text);
    $text = preg_replace('/\[SQL\]([\S\s]*?)\[\\\\SQL\]/usi', "<pre><code class='language-sql'>$1</code></pre>", $text);
    $text = preg_replace('/\[C\]([\S\s]*?)\[\\\\C\]/usi', "<pre><code class='language-c'>$1</code></pre>", $text);
    $text = preg_replace('/\[C\#\]([\S\s]*?)\[\\\\C\#\]/usi', "<pre><code class='language-csharp'>$1</code></pre>", $text);
    $text = preg_replace('/\[C\+\+\]([\S\s]*?)\[\\\\C\+\+\]/usi', "<pre><code class='language-cpp'>$1</code></pre>", $text);
    $text = preg_replace('/\[PYTHON\]([\S\s]*?)\[\\\\PYTHON\]/usi', "<pre><code class='language-python'>$1</code></pre>", $text);
    $text = preg_replace('/\[JS\]([\S\s]*?)\[\\\\JS\]/usi', "<pre><code class='language-javascript'>$1</code></pre>", $text);
    $text = preg_replace('/\[HTML\]([\S\s]*?)\[\\\\HTML\]/usi', "<pre><code class='language-html'>$1</code></pre>", $text);
    $text = preg_replace('/\[CSS\]([\S\s]*?)\[\\\\CSS\]/usi', "<pre><code class='language-css'>$1</code></pre>", $text);
    $text = preg_replace_callback(
      '#\[PHP\](.+?)\[\\\\PHP\]#uis',
      function ($matches)
      {
        return "<pre><code class='language-php'>".$matches[1]."</code></pre>";
      },
      $text
    );
    
    $text = preg_replace('/\[NICK\]([\S\s]*?)\[\\\\NICK\]/usi', '<a class="nick2">$1</a>', $text);
    $text = preg_replace('/\[QUOTE\]([\S\s]*?)\[\\\\QUOTE\]/usi', "<span style='color: #95dfa4;'>&laquo;$1&raquo;</span>", $text);
    $text = preg_replace('/\[B\]([\S\s]*?)\[\\\\B\]/usi', "<b>$1</b>", $text);
    $text = preg_replace('/\[i\]([\S\s]*?)\[\\\\i\]/usi', "<i style='font-style: italic;'>$1</i>", $text);
    $text = preg_replace('/\[U\]([\S\s]*?)\[\\\\U\]/usi', '<span style="text-decoration: underline;">$1</span>', $text);
    $text = preg_replace('/\[S\]([\S\s]*?)\[\\\\S\]/usi', '<span style="text-decoration: line-through;">$1</span>', $text);

    $text = preg_replace_callback(
      '/\[A\]\b(https?:\/\/[\wа-яё,\/.\?\+%&=#:\-;]+)\[\\\\A\]/uis',
      function ($matches)
      {
        if(preg_match('/https:\/(\/www\.)?youtube\.com\/watch/i', $matches[1]))
        {
          $frame = $matches[1];
          $frame = preg_replace("/watch\?v=/", "embed/", $frame);
          $frame = preg_replace("/&.+$/", "", $frame);
          return "<iframe style='display: block;' width='560' height='315' src='$frame' frameborder='0' allowfullscreen></iframe>";
        }
        else
        {
          $href = $matches[1];
          return "<a class='a' target='_blank' href='$href'>$href</a>";
        }
      },
      $text
    );

    $text = preg_replace_callback('/\[(\d+\.gif)\]/usi',
      function ($matches)
      {
        $match = $matches[1];
        if($match == '2.gif' || $match == '4.gif'){
          return '<img src="/template/images/smiles/'.$match.'" class="textgif3"/>';
        }
        else
        {
          return '<img src="/template/images/smiles/'.$match.'" class="textgif"/>';
        }
      },
      $text
    );

    return $text;
  }






  function setComment()
  {

    $name    = $this->escapeStr($_POST['name'], 55);
    $adres   = $this->escapeStr2($_POST['adres'], 77);

    $file    = "";

    $comment = $this->escapeStr2($_POST['message_text'], 3333);
    if(isset($_FILES['file2']) && is_uploaded_file($_FILES['file2']['tmp_name'])){
      $file = $this->uploadFile2();
    }
    $comment       = $this->setCode($comment).$file;
    $time          = time();
    @$insertComment = $this->query("insert into `comments` (`name`, `comment`, `adres`, `time`) values (?,?,?,?)", array($name, $comment, $adres, $time), 1);
    if($insertComment == 1)
    {
      $comment = "<li class='msg'><a class='nick'>$name</a><br>$comment<span class='time'>$time</span></li>";
      exit($comment);
    }

  }

}
//print_r($_REQUEST);

if(isset($_REQUEST['func']))
{
  $func   = $_REQUEST['func'];
  $worker = new AjaxController;
  $worker->$func();
}

//$worker = new AjaxController;




