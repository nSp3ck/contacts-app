<?php
  //Muestra datos del servidor
  // var_dump($_SERVER);
  // die();
  require "db.php";

  session_start();


  if(!isset($_SESSION["user"])){
    header("Location: login.php");
    return;
  }

  
  $error = null;
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    // var_dump($_POST); //Array asociativo
    //Las variables, con camelCase
    
    if(empty($_POST["name"]) || empty($_POST["phone_number"]) || empty($_POST["address"])){
      $error = "Please complete all the fields.";
    } else if(strlen($_POST["phone_number"]) < 9){
      $error = "Phone number must be at last 9 numbers";
    } else {
      $name = $_POST["name"];
      $phoneNumber = $_POST["phone_number"];
      $statement = $conn -> prepare("INSERT INTO contacts (user_id, name,phone_number,address) VALUES ({$_SESSION['user']['id']},:name, :phone_number, :address)");
      $statement->bindParam(":name", $_POST["name"]);
      $statement->bindParam(":phone_number", $_POST["phone_number"]);
      $statement->bindParam(":address", $_POST["address"]);
      $statement->execute();

      $_SESSION["flash"] = ["message" => "Contact {$_POST['name']} added."];

      header("Location: home.php");
      return;
    }
  }
?>

<?php require "partials/head.php"?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if($error):?>
            <p class="text-danger"><?= $error ?></p>
          <?php endif ?>
          <form method="POST" action="add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number" required autocomplete="phone_number" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Address</label>

              <div class="col-md-6">
                <input id="address" type="tel" class="form-control" name="address" required autocomplete="address" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require "partials/footer.php"?>
