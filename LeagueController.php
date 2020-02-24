<?php

namespace App\Http\Controllers;
use App\League;
use App\Http\Resources\LeaguesCollection;

use Illuminate\Http\Request;

class LeagueController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/auth/leagues",
     *     tags={"Leagues"},
     *     summary="Returns list of countries",
     *     description="Leagues",
     *     operationId="index",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index() : LeaguesCollection
    {
      return new LeaguesCollection(League::all());
    }
}
