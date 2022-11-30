<?php 
  header('Access-Control-Allow-Origin: *');
  header("content-type: text/html; charset=UTF-8");


  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  //conecta db
  $database = new Database();
  $db = $database->connect();

  
  $post = new Post($db);

  $result = $post->read();
  $num = $result->rowCount();

  if($num > 0) {
    $posts_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => $body,
        'author' => $author_name,
        'email' => $email,
        'category_id' => $category_id,
        'category_name' => $category_name
      );

      array_push($posts_arr, $post_item);
    }

    // Transforma em Json e devolve
    echo json_encode($posts_arr);

  } else {
    echo json_encode(
      array('message' => 'Nenhuma postagem encontrada')
    );
  }
