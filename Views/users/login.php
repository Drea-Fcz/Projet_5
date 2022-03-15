<?php if (!empty($_SESSION['error'])) :?>
<div class="d-flex justify-content-end">
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <?php echo $_SESSION['error']; unset($_SESSION['error']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>
<div class="grid">
    <div class="card-register bg-dark p-5">
        <h2 class="color">Login</h2>
        <p class="card-title text-muted">Please fill in your credentials to log in</p>
        <hr>
        <div class="">
            <?= $loginForm ?>
        </div>
    </div>
</div>
