<div class="add">
    <div class="card bg-dark">
        <div class="card-body">
            <div class="p-3">
                <h2 class="color">Edit Article</h2>
                <p class="card-title text-white">Please edit your article</p>
            </div>
            <hr>
            <div class="mb-2">
                <form action="<?php echo URL; ?>/posts/edit/<?= $data['id'] ?>" method="post"
                      class="form-signup text-white px-3"
                      enctype="multipart/form-data">
                    <div class="form-group mb-3">
                        <label for="chapo" class="mb-1">Chapo: <sup>*</sup></label>
                        <input type="text" name="chapo"
                               class="form-control form-control-lg <?php echo (!empty($data['chapo_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['chapo']; ?>" placeholder="Chapo">
                        <span class="invalid-feedback"><?php echo $data['chapo_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="title" class="mb-1">Title: <sup>*</sup></label>
                        <input type="text" name="title"
                               class="form-control  form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>"
                               value="<?php echo $data['title']; ?>" placeholder="Title">
                        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                    </div>
                    <div class="form-group mb-3">
                        <label for="body" class="mb-1">Article: <sup>*</sup></label>
                        <textarea name="body" class="form-control form-control-lg
                            <?php echo (!empty($data['body_err'])) ? 'is-invalid' : ''; ?>"
                                  placeholder="Enter your article"><?php echo $data['body']; ?></textarea>

                    </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end">
                <a href="<?= URL ?>/posts" class="btn btn-outline-cancel me-3">Cancel</a>
                <input type="submit" value="Submit" class="btn btn-outline-success">
            </div>
            </form>
        </div>
    </div>
</div>
