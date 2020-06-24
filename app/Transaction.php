<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  /**
  * The user that this transaction belongs to
  */
  public function user()
  {
    return $this->belongsTo('App\User');
  }
}
