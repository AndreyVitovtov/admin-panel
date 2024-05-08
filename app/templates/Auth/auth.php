<div class="container">
    <div class="row justify-content-center login-container">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-white">
                    <h5 class="card-title">
						<?= PROJECT_NAME ?>
                    </h5>
                </div>
                <div class="card-body">
					<?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
					<?php endif; ?>
                    <form action="auth/login" method="post">
                        <div class="mb-3">
                            <label for="login" class="form-label"><?= __('login') ?>:</label>
                            <input type="text" class="form-control" id="login" name="login" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><?= __('password') ?>:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <input type="checkbox" name="remember" value="1" id="remember-me">
                            <label for="remember-me"><?= __('remember me') ?></label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary"><?= __('sign in') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>