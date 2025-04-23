<?php include 'library.php'; ?>
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <title><?= $title ?></title>

   <!-- favicon -->
   <link rel="shortcut icon" href="./asset/img/logo.jpeg" type="image/x-icon">

   <!-- Bootstrap core CSS -->
   <link href="./asset/css/style.css" rel="stylesheet">

   <!-- fontawesome core CSS -->
   <link href="./asset/css/fontawesome-free-5.11.2/css/all.min.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="./asset/css/login.css" rel="stylesheet">
</head>

<body>
   <form class="form-signin" action="app/login.php" method="POST">
      <div class="text-center mb-4">
         <img class="mb-4" src="./asset/img/logo.png"  width="200">
         <h2 class="mb-3 fw-bold">
            <?= $title ?>
         </h2>
      </div>

      <div class="form-label-group">
         <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>
         <label for="inputEmail">Username</label>
      </div>

      <div class="form-label-group">
         <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
         <label for="inputPassword">Password</label>
      </div>

      <button class="btn btn-lg btn-primary w-100" type="submit">
         <i class="fa fa-unlock-alt"></i> &nbsp; Masuk
      </button>
      <p class="mt-5 mb-3 text-muted text-center">
         Powered by <strong class="text-primary"><?= $copyright ?></strong> &copy; <?= date('Y') ?>
      </p>
   </form>
</body>

</html>