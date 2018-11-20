<?php

namespace Theme\Models\Term;

use Illuminate\Database\Eloquent\Model;
use Theme\Models\Term;


class Taxonomy extends Model
{
	/** @var string  */
	protected $table = 'term_taxonomy';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function term()
	{
		return $this->belongsTo(Term::class, 'term_id', 'term_id');
	}
}
