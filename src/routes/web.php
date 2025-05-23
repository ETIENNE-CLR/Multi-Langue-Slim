<?php

use Controllers\SiteController;

// Routages - CRUD
$app->get('/create[/]', [SiteController::class, 'createView']);
$app->post('/create[/]', [SiteController::class, 'create']);

$app->get('/create-activity[/]', [SiteController::class, 'createActivity']);

$app->get('/[read]', [SiteController::class, 'read']);
$app->get('/read/{id}[/]', [SiteController::class, 'detail']);

$app->get('/update/{id}[/]', [SiteController::class, 'updateView']);
$app->post('/update/{id}[/]', [SiteController::class, 'update']);

$app->get('/delete/{id}[/]', [SiteController::class, 'delete']);

