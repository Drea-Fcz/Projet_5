<div class="container-fluid">
    <div class="d-flex justify-content-end">
        <a href="<?= URL ?>/posts/add" class="btn a-tag btn-sm color">
            <i class="fa fa-pen fa-sm"></i> add post</a>
    </div>
</div>
<?php if (!empty($_SESSION['message'])) :?>
    <div class="d-flex justify-content-end">
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            <?php echo $_SESSION['message']; unset($_SESSION['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>
<div class="container my-3">
    <div class="row">
        <?php foreach ($posts as $post) : ?>
            <div class="col-sm-12 col-md-4 mb-3">
                <div class="bg-dark post card">
                    <div class="ps-4 pt-2">
                        <h6 class="card-title text-secondary text-uppercase"><?= $post->chapo ?></h6>
                    </div>
                    <img src="assets/upload/<?= $post->img ?>" alt="photo"
                         class="card-img-top d-flex align-item-center img-post p-2">
                    <div class="card-body text-white">
                        <h4 class="card-title"><?= $post->title ?></h4>
                        <div class="color small mb-3">
                            written by <?= $post->name ?> <?= $post->postCreated ?>
                        </div>
                        <p class="card-text scrollable pb-4">
                            <?= substr($post->body, 0, 249) ?> ...
                        </p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="posts/show/<?= $post->postId ?>"
                           class="btn btn-card m-4">Read more</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
