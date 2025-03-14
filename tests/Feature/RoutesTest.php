<?php

use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;

test('testing route', function ($route) {
    get(route($route))->assertOK();
})->with([
    'blv.index',
]);

test('the default url can be changed', function () {
    config()->set('log-viewer.route_path', 'new-log-route');

    reloadRoutes();

    expect(route('blv.index'))->toContain('new-log-route');

    get(route('blv.index'))->assertOK();
});

/*
|--------------------------------------------------------------------------
| HELPERS
|--------------------------------------------------------------------------
*/

function reloadRoutes(): void
{
    $router = Route::getFacadeRoot();
    $router->setRoutes((new RouteCollection()));

    Route::middleware('web')
        ->namespace('App\Http\Controllers')
        ->group('routes/web.php');
}
