<?php

namespace Theme\Models\Term;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model {
    protected $table = 'term_meta';
    protected $fillable = ['meta_key', 'meta_value'];
    protected $primaryKey = 'meta_id';
}
