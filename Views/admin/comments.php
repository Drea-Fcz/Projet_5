<div class="container">
    <h2 class="mt-3"><?= $post->title ?></h2>
</div>
<h6 class="text-uppercase mt-5">Comments list: </h6>
<hr>
<?php foreach ($comments as $comment) : ?>
    <div class="card comment mb-2">
        <div class="container mt-1">
            <div class="row px-1">
                <div class="col-md-10">
                    <p><?= date("d/m/Y H:i", strtotime($comment->comment_date)); ?></p>
                    <p>
                        <?= $comment->comment ?>
                    </p>
                </div>
                <div class="col-md-2 align-self-center ">
                    <div class="d-flex flex-row-reverse">
                        <form action="<?= URL ?>/admin/delete/<?= $comment->id ?>" method="POST">
                            <button type="submit" value="" class="btn red a-red-tag">
                                <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                            </button>
                        </form>
                        <form action="<?= URL ?>/admin/validComment/<?= $comment->id ?>" method="POST">
                            <button type="submit" value="" class="btn color a-tag">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
