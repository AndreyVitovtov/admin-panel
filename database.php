<?php

use App\Core\Database;

require_once 'vendor/autoload.php';

$admin = [
	'login' => 'admin',
	'password' => '12345678'
];

if (!isset($_REQUEST['confirm'])) {
	exit('This will delete all admin and role data! (If there are any) ' . br() . 'Do you confirm? 
		<form><input type="hidden" name="confirm" value="ok"><input type="submit" value="I confirm"></form>');
}

$dbh = Database::instance()->getDbh();

try {
	$dbh->beginTransaction();

	echo 'roles ....';
	$stmt = $dbh->prepare("
		CREATE TABLE IF NOT EXISTS `roles` (
		    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
		    `title` VARCHAR(255) UNIQUE
        )
	");
	$stmt->execute();
	echo '.... ok' . br();

	echo 'admins ....';
	$stmt = $dbh->prepare("
		CREATE TABLE IF NOT EXISTS `admins` (
		    `id` INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
		    `login` VARCHAR(255) UNIQUE,
		    `password` VARCHAR(255),
		    `name` TEXT,
		    `role` INT UNSIGNED,
		    `avatar` TEXT,
		    FOREIGN KEY (`role`) REFERENCES `roles`(`id`) ON UPDATE CASCADE ON DELETE CASCADE 
        )
	");
	$stmt->execute();
	echo '.... ok' . br();

	/* DELETE */
	$stmt = $dbh->prepare("
		DELETE FROM admins;
	");
	$stmt->execute();
	$stmt = $dbh->prepare("
		DELETE FROM roles;
	");
	$stmt->execute();
	/* ***** */

	echo 'add role admin ....';
	$stmt = $dbh->prepare("
		INSERT INTO `roles` (`title`) 
		VALUES ('superadmin');
	");
	$stmt->execute();
	echo '.... ok' . br();

	echo 'add admin ....';
	$stmt = $dbh->prepare("
		INSERT INTO `admins` (`login`, `password`, `name`, `role`) 
		VALUES (:login, MD5(:password), 'admin', LAST_INSERT_ID());
	");
	$stmt->execute([
		'login' => $admin['login'],
		'password' => $admin['password']
	]);
	echo '.... ok' . br();

	echo 'add other roles ....';
	$stmt = $dbh->prepare("
		INSERT INTO `roles` (`title`) 
		VALUES ('admin'), ('guest'), ('manager');
	");
	$stmt->execute();
	echo '.... ok' . br(3);

	$dbh->commit();
	echo 'login: ' . $admin['login'] . br() . 'password: ' . $admin['password'] . br(2) .
		'! After logging in, change your password !' . br() .
		'! Remove the database.php file from the project !';
} catch (PDOException $e) {
	$dbh->rollBack();
	dd($e->getMessage());
}
