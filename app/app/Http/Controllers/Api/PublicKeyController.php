<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GlagolCloud\Modules\User\AuthenticatedUser;
use GlagolCloud\Modules\User\PublicKey;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PublicKeyController extends Controller
{
    public function index(AuthenticatedUser $user): JsonResponse
    {
        return response()->json($user->publicKeys);
    }

    public function store(Request $request, AuthenticatedUser $user): Response
    {
        $publicKey = PublicKey::newFromKeyAndUser($request->input('key'), $user);
        $publicKey->save();

        return response(null, Response::HTTP_CREATED);
    }
}