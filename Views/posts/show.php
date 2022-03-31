<div class="d-flex justify-content-between m-3">
    <a href="<?= URL ?>/posts" class="btn color">&larr; Back</a>
</div>
<div class="container text-white">
    <div class="card bg-dark p-4">
        <div class="container">
            <div class="d-flex justify-content-center mx-5">
                <img src="../../public/assets/upload/<?= htmlspecialchars_decode($post->img) ?>" alt="gravity" class="img-fluid p-2">
            </div>
            <div class="show-content">
                <div class="d-flex justify-content-between">
                    <h1><?= $post->title ?></h1>

                        <div class="d-flex flex-row">
                            <a href="<?= URL ?>/posts/edit/<?= htmlspecialchars_decode($idPost) ?>" class="btn a-tag color">

                                <i class="fa fa-pencil" aria-hidden="true"></i></a>

                            <form action="<?= URL ?>/posts/delete/<?= $idPost ?>" method="POST">
                                <button type="submit" value="" class="btn red a-red-tag">
                                    <i class="fa fa-trash " aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>

                </div>
                <p>
                    <?= $post->body ?>
                </p>
                <h6 class="text-uppercase">Comments : </h6>

                    <div class="form-group">
                        <form  method="post">
                            <div class="d-flex justify-content-between">
                                <?= $form ?>
                            </div>
                        </form>
                    </div>
                <hr>
                <?php foreach ($comments as $comment) : ?>
                        <div class="card comment_dark mb-3">
                            <div class="container mt-1">
                                <div class="d-flex justify-content-between px-1">
                                    <b class="color text-capitalize small"><?= $comment->name ?> </b>
                                    <i class="ms-3 small">created at <?= $comment->comment_date ?></i>
                                </div>
                                <div class="container mt-3">
                                    <p class="d-flex justify-content-start">
                                        <?= $comment->comment ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
