<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Themosis\Facades\PostType;
use Themosis\Metabox\Meta;
use Theme\Models\Post\Meta as PostMeta;
use Theme\Models\Term\Taxonomy as TermTaxonomy;
use Theme\Models\Term\Relationships as TermRelationships;
use WP_Query;
use Theme\Models\Traits\HasMeta;

/**
 * Class Post.
 * Help you retrieve data from your $prefix_posts table.
 *
 * @package Theme\Models
 */
class Post extends Model
{
	use HasMeta;

	/** @var string */
	protected $table = 'posts';
	/** @var string */
	protected $primaryKey = 'ID';
	/** @var bool */
	public $timestamps = false;

	/** @var string|bool null */
	protected $postType = null;
	/** @var string|null */
	protected $postTypeLabelPlural = null;
	/** @var string|null */
	protected $postTypeLabelSingle = null;
	/** @var array|null */
	protected $postTypeOptions = [
		'public' => true,
		'has_archive' => true,
		'menu_icon' => 'dashicons-admin-page',
		'supports' => ['title', 'thumbnail'],
		'rewrite' => [
			// This must be repeated if you still
			// want it when you overwrite 'rewrite'
			'with_front' => false
		]
	];
	/** @var bool */
	protected $postTypeOptionsPage = true;

	/**
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope('postType', function (Builder $builder) {
			($instance = new static)->postType ? $builder->where('post_type', $instance->postType) : null;
		});
	}

	/**
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function scopePublished(Builder $query)
	{
		return $query->status('publish');
	}

	/**
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function scopeMenuOrder(Builder $query)
	{
		return $query->orderBy('menu_order');
	}

	/**
	 * @param $termID
	 * @param string $taxonomy
	 * @return array
	 */
	public static function inTerm($termID, $taxonomy = 'category')
	{
		$query = new WP_Query([
			'post_type' => (new static)->postType,
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'terms' => $termID,
					'operator' => 'IN'
				],
			]
		]);

		return collect($query->get_posts());
	}

	/**
	 * Create new custom post type if set
	 * @return Post
	 */
	public static function createPostType()
	{
		$instance = new static;

		if ($instance->postType) {
			$postType = PostType::make(
				$instance->postType,
				$instance->postTypeLabelPlural ?: $instance->postType,
				$instance->postTypeLabelSingle ?: $instance->postType
			);

			$postType->set($instance->postTypeOptions);

			if (function_exists('acf_add_options_page') && $instance->postTypeOptionsPage) {
				acf_add_options_page(array(
					'page_title' => 'Options - ' . $instance->postTypeLabelSingle,
					'menu_title' => 'Options - ' . $instance->postTypeLabelSingle,
					'menu_slug' => 'options-' . $instance->postType,
					'post_id' => 'options-' . $instance->postType,
					'capability' => 'edit_posts',
					'parent_slug' => 'edit.php?post_type=' . $instance->postType,
					'position' => false,
					'icon_url' => 'dashicons-images-alt2',
					'redirect' => false,
				));
			}
		}

		return $instance;
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getField($key)
	{
		return function_exists('get_field') ?
			$value = get_field($key, $this->ID) : Meta::get($this->ID, $key, true);
	}

	/**
	 * @param array|null $queryVars
	 * @param bool $leaveName
	 *
	 * @return string
	 */
	public function permalink(array $queryVars = null, $leaveName = false)
	{

		$queryString = null;

		if ($queryVars) {
			$queryString = http_build_query($queryVars);
		}

		return get_permalink($this->ID, $leaveName) . (@$queryString ? '?' . $queryString : '');
	}

	/**
	 * @param string $size
	 *
	 * @return false|string
	 */
	public function featuredImage($size = '')
	{
		return get_the_post_thumbnail_url($this->ID, $size);
	}


	/**
	 * ----
	 * WP Eloquent - copied and adapted
	 * ----
	 */


	const CREATED_AT = 'post_date';
	const UPDATED_AT = 'post_modified';

	public function newQuery() {
		$query = parent::newQuery();
		if($this->post_type) {
			return $this->scopeType($query, $this->post_type);
		}
		return $query;
	}

	public function author () {
		return $this->hasOne(User::class, 'ID', 'post_author');
	}

	public function meta () {
		return $this->hasMany(PostMeta::class, 'post_id')
			->select(['post_id', 'meta_key', 'meta_value']);
	}

	public function terms () {
		return $this->hasManyThrough(
			TermTaxonomy::class,
			TermRelationships::class,
			'object_id',
			'term_taxonomy_id'
		)->with('term');
	}

	public function categories () {
		return $this->terms()->where('taxonomy', 'category');
	}

	public function attachments () {
		return $this->hasMany(Attachment::class, 'post_parent', 'ID')->where('post_type', 'attachment');
	}

	public function tags () {
		return $this->terms()->where('taxonomy', 'post_tag');
	}

	public function comments () {
		return $this->hasMany(Comment::class, 'comment_post_ID');
	}

	public function scopeStatus ($query, $status = 'publish') {
		return $query->where('post_status', $status);
	}

	public function scopeType ($query, $type = 'post') {
		return $query->where('post_type', $type);
	}
}
