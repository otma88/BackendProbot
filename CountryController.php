<?php

namespace App\Http\Controllers;
use App\Country;
use App\Http\Resources\CountryCollection;

use Illuminate\Http\Request;

class CountryController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/auth/countries",
     *     tags={"Countries"},
     *     summary="Returns list of countries",
     *     description="Countries",
     *     operationId="index",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() : CountryCollection
    {
      return new CountryCollection(Country::all());
    }

}
