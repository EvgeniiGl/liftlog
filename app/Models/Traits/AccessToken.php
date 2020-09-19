<?php

namespace App\Models\Traits;

use App\User;
use Illuminate\Http\Request;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\Token;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

trait AccessToken
{
    /**
     * Get personal access token for user.
     *
     * @return \Laravel\Passport\Token|null
     */
    public function getToken(): ?Token
    {
        return app(TokenRepository::class)->findValidToken(
            \Auth::user(),
            app(ClientRepository::class)->personalAccessClient()
        );
    }

    /**
     * @param string $token
     * @return User user
     */
    static function getUserByToken(string $token)
    {
        $tokenguard = new TokenGuard(
            \App::make(ResourceServer::class),
            \Auth::createUserProvider('users'),
            \App::make(TokenRepository::class),
            \App::make(ClientRepository::class),
            \App::make('encrypter')
        );
        $request    = Request::create('/');
        $request->headers->set('Authorization', 'Bearer ' . $token);
        return $tokenguard->user($request);
    }
}
