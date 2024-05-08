<form action="/admin/save" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">
            *<?= __('name') ?>:
        </label>
        <input type="text" name="name" value="<?= user('name') ?>" class="form-control" id="name" required>
    </div>
    <div class="mb-3">
        <label for="login" class="form-label">
            *<?= __('login') ?>:
        </label>
        <input type="text" name="login" value="<?= user('login') ?>" class="form-control" id="login" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">
			<?= __('password') ?>:
        </label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <div class="mb-3">
        <label for="repeat-password" class="form-label">
			<?= __('repeat password') ?>:
        </label>
        <input type="password" name="repeatPassword" class="form-control" id="repeat-password">
    </div>
    <div class="mb-3">
        <label for="avatar" class="form-label">
			<?= __('avatar') ?>:
        </label>
        <input type="file" name="avatar" class="form-control" id="avatar">
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>