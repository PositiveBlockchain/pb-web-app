<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SdgGoal extends Model {

    protected $fillable = [
        'goal_number',
        'goal_name',
        'goal_icon_path',
        'description',
    ];
}
