<?php

namespace Theme\Models\Term;

use Illuminate\Database\Eloquent\Model;
use Theme\Models\Post;

class Relationships extends Model
{
	protected $table = 'term_relationships';
	protected $primaryKey = 'term_taxonomy_id';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function posts()
	{
		return $this->belongsTo(Post::class, 'ID', 'object_id');
	}

}
