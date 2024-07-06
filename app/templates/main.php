<?php use app\utility\Request; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '' ?> | <?= PROJECT_NAME ?></title>
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/fontello/fontello.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/' . theme() . '.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/main.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/media.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= assets('images/favicon.png') ?>">
    <script src="<?= assets('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= assets('js/jquery-3.7.1.min.js') ?>"></script>
    <script src="<?= assets('js/main.js') ?>"></script>
	<?php
	if (isset($assets['css'])) {
		echo implode("\n", array_map(function ($v) {
			return '<link rel="stylesheet" href="' . assets('css/' . $v) . '">';
		}, (is_array($assets['css']) ? $assets['css'] : [$assets['css']])));
	}

	if (isset($assets['js'])) {
		echo implode("\n", array_map(function ($v) {
			return '<script src="' . assets('js/' . $v) . '"></script>';
		}, (is_array($assets['js']) ? $assets['js'] : [$assets['js']])));
	}
	?>
</head>
<body>
<?php if (isAuth()): ?>
    <div class="flex">
        <div class="menu desk">
			<?php require 'menu.php' ?>
        </div>
        <div class="menu mob animate-left">
			<?php require 'menu.php' ?>
        </div>
        <div class="content">
			<?php if (!empty($error) || !empty(Request::get('error'))): ?>
                <div class="alert alert-danger position-absolute alert-message" role="alert">
					<?= $error ?? Request::get('error') ?>
                </div>
			<?php endif;
			if (!empty($message) || !empty(Request::get('message'))): ?>
                <div class="alert alert-success position-absolute alert-message" role="alert">
					<?= $message ?? Request::get('message') ?>
                </div>
			<?php endif; ?>
            <div class="header flex-between">
                <div class="menu-button btn desk">
                    <i class="icon-cancel"></i>
                </div>
                <div class="menu-button btn mob">
                    <i class="icon-menu"></i>
                </div>
                <div class="user flex-between">
                    <div class="dropdown search">
                        <div class="dropdown-toggle" type="button" id="search" data-bs-toggle="dropdown">
                            <i class="icon-search"></i>
                        </div>
                        <div class="dropdown-menu w-auto dropdown-menu-search" aria-labelledby="search">
                            <form action="/search" method="GET">
                                <div class="flex">
                                    <label>
                                        <input type="search" name="search" placeholder="<?= __('search') ?>">
                                    </label>
                                    <button><i class="icon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <a href="/theme/change/<?= (theme() == 'dark' ? 'light' : 'dark') ?>/<?= getCurrentUrl(true) ?>">
                        <div class="theme <?= theme() ?>">
                            <div><i class="icon-sun"></i></div>
                            <div><i class="icon-moon"></i></div>
                            <div class="theme-switcher"></div>
                        </div>
                    </a>
                    <div class="dropdown language">
                        <div class="dropdown-toggle flex-between" type="button" id="language" data-bs-toggle="dropdown">
                            <img src="<?= assets('images/' . getLanguage('image')) ?>"
                                 alt="<?= getLanguage('title') ?>"> &nbsp;<span
                                    class="desk"><?= getLanguage('title') ?></span>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-language" aria-labelledby="language">
							<?= implode("\n", array_map(function ($v) {
								return '<li>
                                    <a class="dropdown-item" href="/language/change/' . $v . '/' . getCurrentUrl(true) . '">
                                        <img src="' . assets('images/' . $v . '.png') . '" alt="' . getLanguage('title', $v) . '"> 
                                        <span class="desk">' . getLanguage('title', $v) . '</span>
                                    </a>
                                </li>';
							}, array_filter(array_keys(LANGUAGES), function ($k) {
								return getCurrentLang() != $k;
							}))) ?>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <div class="dropdown-toggle dropdown-admin flex-between" type="button" id="user"
                             data-bs-toggle="dropdown">
                            <div class="avatar"
                                 style="background-image: url('<?= assets('images/avatars/' . user('avatar', 'avatar.png')) ?>')">
                            </div>
                            <span class="desk">
                                <?= ucfirst(user('name')) ?>
                            </span>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-user" aria-labelledby="user">
                            <li>
                                <a class="dropdown-item" href="/admin/settings">
                                    <i class="icon-cogs"></i> <?= __('settings') ?>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/auth/logout">
                                    <i class="icon-logout-1"></i> <?= __('logout') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="page-title">
				<?= $pageTitle ?? '' ?>
            </div>
            <div class="main-content">
				<?php if (!empty($template)) require_once $template . '.php'; ?>
            </div>
            <div class="footer">
                <div class="copyright"><?= VERSION ?> © 2024</div>
            </div>
        </div>
    </div>
<?php elseif (!empty($template)): require_once $template . '.php'; endif;
require_once 'modal.php'; ?>
</body>
</html>