<?php
declare(strict_types=1);
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GlagolCloud\Modules\User\User;
use GlagolCloud\Modules\User\Values\Email;
use GlagolCloud\Modules\User\Values\PlainPassword;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SignUpController extends Controller
{
    /**
     * @param Request $request
     * @param Hasher $hasher
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function signUp(Request $request, Hasher $hasher): JsonResponse
    {
        $this->validate($request, $this->rules(), $this->validationMessages());

        $email = new Email($request->input('email'));
        $password = new PlainPassword($request->input('password'));

        $user = User::newUser($email, $password, $hasher);
        $user->save();

        return response()->json(['message' => 'User created'], JsonResponse::HTTP_CREATED);
    }

    public function validationMessages(): array
    {
        return [
            'email.required' => 'Input required',
            'email.email' => 'Please enter a valid e-mail address',
            'email.unique' => 'This email address has already been used',
            'password.required' => 'Input required',
            'password.min' => 'Password has to be at least 6 characters long',
        ];
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ];
    }
}
