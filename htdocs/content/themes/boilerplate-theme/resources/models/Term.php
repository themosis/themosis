<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Theme\Models\Term\Meta;
use Theme\Models\Term\Relationships as TermRelationships;
use Theme\Models\Traits\HasMeta;

class Term extends Model
{
	use HasMeta;

	/** @var string */
	protected $table = 'terms';
	/** @var string */
	protected $primaryKey = 'term_id';

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function meta()
	{
		return $this->hasMany(Meta::class, 'term_id')
			->select(['term_id', 'meta_key', 'meta_value']);
	}

	/**
	 * @param string $postModel
	 * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
	 */
	public function posts(string $postModel = Post::class)
	{
		return $this->hasManyThrough($postModel,
			TermRelationships::class,
			'term_taxonomy_id',
			'ID',
			'',
			'object_id'
		);//->where('posts.post_status', 'publish');
	}

	/**
	 * @param $query
	 * @param $slug
	 * @return mixed
	 */
	public function scopeSlug($query, $slug)
	{
		return $query->where('slug', $slug);
	}
}
