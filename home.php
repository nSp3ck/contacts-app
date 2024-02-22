<?php
  // if(file_exists("contacts.json")){
  //   $contacts = json_decode(file_get_contents("contacts.json"),true);
  // } else{
  //   $contacts = [];
  // }
  session_start();
  
  if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
  }
  
  require "db.php";
  $contacts = $conn -> query("SELECT * FROM contacts WHERE user_id = {$_SESSION['user']['id']}");
?>
<?php require "partials/head.php"?>
<div class="container pt-4 p-3">
  <div class="row">
    <?php if($contacts -> rowCount() == 0): ?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="add.php">Add One!</a>
        </div>
      </div>
    <?php endif ?>
    <?php foreach($contacts as $contact):?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contact['name'] ?></h3>
            <p class="m-2"><?= $contact['phone_number'] ?></p>
            <p class="m-2"><?= $contact['address'] ?></p>
            <a href="edit.php?id=<?= $contact["id"] ?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <a href="delete.php?id=<?= $contact["id"] ?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php require "partials/footer.php"?>
