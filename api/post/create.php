<?php 
  header('Access-Control-Allow-Origin: *');
  
  header('Access-Control-Allow-Methods: POST');
  header("Content-type: text/html; charset=utf-8");

  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Post.php';

  $database = new Database();
  $db = $database->connect();

  $post = new Post($db);

  $data = json_decode(file_get_contents("php://input"));

  $post->title = $data->title;
  $post->body = $data->body;
  $post->author_id = $data->author_id;
  $post->category_id = $data->category_id;

  if($post->create()) {
    echo json_encode(
      array('message' => 'Postagem publicada')
    );
  } else {
    echo json_encode(
      array('message' => 'Postagem nao publicada')
    );
  }

