<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PlayersCollection;
use App\Player;

class PlayerController extends Controller
{

    /**
     * @OA\GET(
     *     path="/api/auth/players/club/{club_id}",
     *     tags={"Players in club"},
     *     summary="Returns list of players in Club",
     *     description="Players",
     *     operationId="index",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *     name="club_id",
     *     in="path",
     *     description="ID of club",
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
  public function index($club_id) : PlayersCollection
  {
    return new PlayersCollection(Player::where('club_id', $club_id)->get());
  }
}
