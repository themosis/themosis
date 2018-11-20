<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model {
    protected $table      = 'links';
    protected $primaryKey = 'link_id';
    public $timestamps    = false;
}
