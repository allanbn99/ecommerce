<?php

use \Project\PageAdmin;
use \Project\Model\User;

$app->get('/admin', function() {

	User::verifyLogin();

	$page = new PageAdmin([
		"data"=>[
			"user"=>$_SESSION["User"]["deslogin"]
		]
	]);

	$page->setTpl("index");

});

$app->get('/admin/login', function() {

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("login");

});

$app->post('/admin/login', function() {

	User::login($_POST["deslogin"], $_POST["despassword"]);

	header("Location: /admin");
	exit;

});

$app->get('/admin/logout', function() {

	User::logout();

	header("Location: /admin/login");
	exit;

});