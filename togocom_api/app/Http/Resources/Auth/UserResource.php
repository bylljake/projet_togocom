<?php

namespace App\Http\Resources\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Generate token for the user.
 * @Category UserResource Class
 */
class UserResource extends JsonResource
{
    use HasRoles;

    #region Constructor
    /**
     * @ Constructor
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    #endregion

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $token = $this->token($request);
        $user = User::find(auth()->user()->id);
        $role = $this->roles($user);
        $permissions = $user->getAllPermissions();

        if (empty($role) || $permissions->isEmpty()) {
            return [
                'status' => 302,
                'redirectTo' => 'api/auth/login',
                'message' => 'Veuillez contacter l\'administrateur'
            ];
        }

        // Verification before user connexion
        if (is_null($user->email_verified_at)) {
            Auth::logout();
            return [
                'status' => 403,
                'message' => 'Echec de connexion. Votre e-mail n\'est pas vérifié. Veuillez cliquer sur le lien de vérification qui a été envoyé dans votre boîte mail',
            ];
        }

        if ($user->status == 0) {
            return [
                'status' => 401,
                'message' => 'Impossible de se connecter. Votre compte est désactivé.',
            ];
        }

        // // Verify if two-factor authentication is activated
        // if ($user->google2fa_enabled == 1) {
        //     return [
        //         'status' => 302,
        //         'redirectTo' => 'page verification code',
        //     ];
        // }

        return [
            'status' => [
                'status' => 200,
                'message'  => "Vous êtes connecté"
            ],
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'expires_in' => auth()->factory()->getTTL(), // 120 minutes in jwt config
            'user' => auth()->user(),
            'roles' => $role,
            'permissions' => $permissions->pluck('name'),
        ];
    }

    /**
     * Get the token array structure.
     * @param object array $request
     * @return string|null
     */
    private function token($request)
    {
        return auth()->attempt($request->only('email', 'password'));
    }

    private function roles($user)
    {
        $roles = [];
        foreach ($user->roles as $role) {
            $roles[] = [
                'id' => $role->id,
                'name' => $role->name,
            ];
        }

        return $roles;
    }
}
