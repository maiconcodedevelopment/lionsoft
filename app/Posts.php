<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{

    protected $primaryKey = "id";

    protected $fillable = [
        "title", "description", "id_user"
    ];

    public function users()
    {
        return $this->belongsTo("App\User");
    }

}
