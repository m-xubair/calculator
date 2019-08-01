<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    protected $fillable = ['first_operand', 'second_operand', 'operator', 'result'];
}
