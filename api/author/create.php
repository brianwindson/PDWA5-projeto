<?php
  header('Access-Control-Allow-Origin: *');
  header("content-type: text/html; charset=UTF-8");
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';
  $database = new Database();
  $db = $database->connect();

  $author = new Author($db);

  $data = json_decode(file_get_contents("php://input"));

  $author->name = $data->name;
  $author->email = $data->email;

  if($author->create()) {
    echo json_encode(
      array('message' => 'Autor criado')
    );
  } else {
    echo json_encode(
      array('message' => 'Falha ao criar autor')
    );
  }
