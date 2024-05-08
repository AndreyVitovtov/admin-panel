<form action="/administrators/save" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">*<?= __('name') ?>:</label>
        <input type="text" name="name" value="<?= $name ?? '' ?>" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="login" class="form-label">*<?= __('login') ?>:</label>
        <input type="text" name="login" value="<?= $login ?? '' ?>" id="login" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">*<?= __('password') ?>:</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="repeat-password" class="form-label">*<?= __('repeat password') ?>:</label>
        <input type="password" name="repeatPassword" id="repeat-password" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">*<?= __('role') ?>:</label>
        <select name="role" id="role" class="form-control" required>
			<?php foreach ($roles ?? [] as $role): ?>
                <option value="<?= $role['id'] ?>"><?= $role['title'] ?></option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>