<?php

/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Route;

use app\admin\controller\System\Article;
use app\admin\controller\Auth;
use app\admin\controller\System\Menu;
use app\admin\controller\System\Action;
use app\admin\controller\System\Dept;
use app\admin\controller\System\Role;
use app\admin\controller\System\User;
use app\admin\controller\System\ArticleCategory;
use app\Auth as AppAuth;
use app\middleware\AccessControl;
use app\middleware\JwtAuth;
use Psr\Container\ContainerInterface;
use support\Request;
use Webman\Container;

Route::group('/admin/auth', function () {
    Route::post('/login', [Auth::class, 'login']);
    // Route::post('/logout', [Auth::class, 'logout']);
    // Route::get('/refresh_token', [Auth::class, 'refreshToken']);
});

Route::group('/admin/menu', function () {
    Route::add(['GET', 'OPTIONS'], '/', [Menu::class, 'index']);
    Route::get('/{id:\d+}', [Menu::class, 'all']);
    Route::add(['GET', 'OPTIONS'], '/tree', [Menu::class, 'tree']);
    Route::post('/', [Menu::class, 'create']);
    Route::put('/{id:\d+}', [Menu::class, 'update']);
    Route::delete('/{id:\d+}', [Menu::class, 'delete']);
})->middleware(JwtAuth::class);

Route::group('/admin/action', function () {
    Route::add(['POST', 'OPTIONS'], '', [Action::class, 'create']);
    Route::add(['PUT', 'OPTIONS'], '/{id}', [Action::class, 'update']);
    Route::delete('/{id:\d+}', [Action::class, 'delete']);
})->middleware(JwtAuth::class);

Route::group('/admin/dept', function () {
    Route::add(['GET', 'OPTIONS'], '', [Dept::class, 'tree']);
    Route::add(['POST'], '', [Dept::class, 'create']);
    Route::add(['PUT'], '/{id:\d+}', [Dept::class, 'update']);
    Route::add(['DELETE', 'OPTIONS'], '/{id:\d+}', [Dept::class, 'delete']);
})->middleware(JwtAuth::class);

Route::group('/admin/role', function () {
    Route::add(['GET', 'OPTIONS'], '', [Role::class, 'index']);
    Route::add(['GET', 'OPTIONS'], '/{id:\d+}', [Role::class, 'info']);
    Route::add(['POST'], '', [Role::class, 'create']);
    Route::add(['PUT'], '/{id:\d+}', [Role::class, 'update']);
    Route::add(['DELETE'], '/{id:\d+}', [Role::class, 'delete']);
    Route::add(['GET', 'OPTIONS'], '/all', [Role::class, 'all']);
    Route::add(['GET'], '/config', [Role::class, 'config']);
})->middleware(JwtAuth::class);

// 用户
Route::group('/admin/user', function () {
    Route::add(['GET', 'OPTIONS'], '/data', [User::class, 'data']);
    Route::add(['GET', 'OPTIONS'], '/menus', [User::class, 'menus']);
    Route::add(['GET', 'OPTIONS'], '/info', [User::class, 'info']);
    Route::add(['GET', 'OPTIONS'], '/permission', [User::class, 'permission']);
    Route::add(['GET'], '/current', [User::class, 'current']);
    Route::add(['PUT'], '/current', [User::class, 'updateCurrent']);
    Route::add(['POST'], '/avatar', [User::class, 'avatar']);
    Route::add(['PUT'], '/reset-password', [User::class, 'resetPassword']);
    Route::add(['GET', 'OPTIONS'], '', [User::class, 'index']);
    Route::add(['POST'], '', [User::class, 'create']);
    Route::add(['PUT'], '/{id:\d+}', [User::class, 'update']);
    Route::add(['DELETE', 'OPTIONS'], '/{id:\d+}', [User::class, 'delete']);
    Route::add(['GET'], '/{id:\d+}', [User::class, 'view']);
})->middleware(JwtAuth::class);

// Route::group('/admin/article', function () {
//     Route::get('/', [Article::class, 'index']);
//     Route::post('/', [Article::class, 'create']);
//     Route::get('/{id}', [Article::class, 'info']);
//     Route::put('/{id}', [Article::class, 'update']);
//     Route::delete('/{id}', [Article::class, 'delete']);

//     Route::get('/category', [ArticleCategory::class, 'tree']);
//     Route::post('/category', [ArticleCategory::class, 'create']);
//     Route::put('/category/{id}', [ArticleCategory::class, 'update']);
//     Route::delete('/category/{id}', [ArticleCategory::class, 'delete']);
// })->middleware(Jwt::class);


Route::fallback(function (Request $request) {
    var_dump('未找到' . $request->method() . $request->path());
});
