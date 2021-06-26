<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
     /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="My API",
     *      description="Inventory",
     *      @OA\Contact(
     *          email="asutarko@hotmail.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API My API"
     * )

     *
     * @OA\Tag(
     *     name="Projects",
     *     description="API Endpoints of Projects"
     * )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
