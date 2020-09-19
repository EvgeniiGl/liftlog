<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
/**
 * @SWG\Swagger(
 *   schemes={"http"},
 *   host="liftlog",
 *   basePath="/",
 *   @SWG\Info(
 *     title="Blog posts API",
 *     version="1.0.0"
 *   )
 * )
 */
class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
