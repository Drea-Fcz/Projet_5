<div class="container-fluid">
    <h1 class="my-3">Bonjour <?= $_SESSION['user']['name'] ?> ☀️!</h1>

    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="card">
                    <div class="ps-4 pt-2">
                        <h6 class="card-title text-secondary text-uppercase"><?= $post['post']->chapo ?></h6>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title"><?= $post['post']->title ?></h4>
                        <hr>
                            <p class="d-flex justify-content-between">Comments pending <span class="badge rounded-pill bg-dark text-white ml-auto"><?= $post['comments'] ?></span></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="admin/comments/<?= $post['post']->postId ?>"
                           class="btn btn-card m-4">Validate</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


</div>
