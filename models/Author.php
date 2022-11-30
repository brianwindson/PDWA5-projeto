<?php
  class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $name;
    public $email;
    public $created_at;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 'SELECT
        id,
        name,
        email,
        created_at
      FROM
        ' . $this->table . '
      ORDER BY
        created_at DESC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

  public function read_single(){
    $query = 'SELECT
          id,
          name,
          email
        FROM
          ' . $this->table . '
      WHERE id = ?
      LIMIT 0,1';

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->id);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->name = $row['name'];
      $this->email = $row['email'];
  }

  public function create() {
    $query = 'INSERT INTO ' .
      $this->table . '
    SET
      name = :name,
      email = :email';

  $stmt = $this->conn->prepare($query);

  $this->name = htmlspecialchars(strip_tags($this->name));
  $this->email = htmlspecialchars(strip_tags($this->email));


  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':email', $this->email);


  if($stmt->execute()) {
    return true;
  }

  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  public function update() {
    $query = 'UPDATE ' .
      $this->table . '
    SET
      name = :name,
      email = :email
      WHERE
      id = :id';

  $stmt = $this->conn->prepare($query);

  $this->name = htmlspecialchars(strip_tags($this->name));
  $this->id = htmlspecialchars(strip_tags($this->id));

  $stmt-> bindParam(':name', $this->name);
  $stmt-> bindParam(':email', $this->email);
  $stmt-> bindParam(':id', $this->id);

  if($stmt->execute()) {
    return true;
  }

  printf("Error: $s.\n", $stmt->error);

  return false;
  }

  public function delete() {
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));

    $stmt-> bindParam(':id', $this->id);

    if($stmt->execute()) {
      return true;
    }

    printf("Error: $s.\n", $stmt->error);

    return false;
    }
  }
