<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function generateTokenResponse($request)
    {
        $tokenResult = $this->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(52);
        }

        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ];

        return array_merge($response, $this->toResponseArray());;
    }

    public function toResponseArray()
    {
        $response = $this->toArray();

        return ['usuario' => $response];
    }

    public function updateValues($values)
    {
        $this->nombre = $values['nombre'];
        $this->apellido_paterno = $values['apellido_paterno'];
        $this->apellido_materno = $values['apellido_materno'];
        $this->email = $values['email'];
        $this->save();
    }
}
