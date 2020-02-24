<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ClubsCollection;
use App\Club;

class ClubController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/auth/clubs/league/{league_id}",
     *     tags={"Clubs"},
     *     summary="Returns list of clubs in league",
     *     description="Clubs",
     *     operationId="index",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *     name="league_id",
     *     in="path",
     *     description="ID of league",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         format="int64",
     *     )
     *   ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
  public function index($league_id) : ClubsCollection
  {
    return new ClubsCollection(Club::where('league_id', $league_id)->get());
  }
}
