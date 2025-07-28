<?php

namespace App\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Reservation API",
 *     description="Creating Swagger doc for my project"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Localhost server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

class SwaggerInfo
{
    // Added empty class because L5-Swagger doesn't recognize annotations file without class
}
