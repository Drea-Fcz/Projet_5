<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>/favicon.ico"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= URL; ?>/public/assets/css/style.css">

    <title><?= SITENAME; ?></title>
</head>
<body class="admin">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= URL; ?>"><span class="color" style="font-size: 32px">A</span>F.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav text-white ms-auto">
                <li class="nav-item"><a class="nav-link" href="<?= URL ?>/main">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= URL ?>/admin">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= URL ?>/admin/user">Setting Users</a></li>

                <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id']) !== null) : ?>
                    <li class="nav-item"><a class="nav-link" href="<?= URL ?>/users/logout">Logout</a></li>
                <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="<?= URL ?>/users/login">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= URL ?>/users/register">Register</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<?php if (!empty($_SESSION['error'])) :?>
    <div class="d-flex justify-content-end">
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
<?php if (!empty($_SESSION['message'])) :?>
    <div class="d-flex justify-content-end mt-2">
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?php echo $_SESSION['message']; unset($_SESSION['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
<div class="container">
    <?= $content ?>
</div>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<!--<script src=<?php /*echo URL; */ ?>/public/assets/js/main.js"></script>-->
</body>
</html>
