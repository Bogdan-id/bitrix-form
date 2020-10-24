<?php

namespace App\Models\OnlineModels;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationResult extends Model
{
    use HasFactory;

     /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'mysql_online';

    protected $table = 'calculation_result';

    public $timestamp = true;
}
