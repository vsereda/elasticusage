<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//use Laravel\Scout\Searchable;
use ElasticScoutDriverPlus\Searchable;
use App\Models\QueryBuilders\UserFormQueryBuilder;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable
        , Searchable
//        , CustomSearch

;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public static function searchForm(string $name): SearchRequestBuilder
    {
        return new SearchRequestBuilder(new UserFormQueryBuilder($name), new static());
    }
}
