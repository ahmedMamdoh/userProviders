<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class UserProvider extends Model
{
    use Filterable;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_providers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['balance', 'currency', 'email', 'status', 'registeration_date', 'identification', 'provider'];
}
