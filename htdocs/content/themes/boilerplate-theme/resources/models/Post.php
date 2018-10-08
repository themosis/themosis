<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Themosis\Facades\PostType;
use Themosis\Metabox\Meta;

/**
 * Class Post.
 * Help you retrieve data from your $prefix_posts table.
 *
 * @package Theme\Models
 */
class Post extends Model
{
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
	/** @var string|null */
	protected $postTypeDashicon = null;
	/** @var array|null */
	protected $postTypeSupports = null;
	/** @var string|null */
	protected $postTypeSlug = null;

	/**
	 * Create new custom post type if set
	 */
	public static function createPostType() {
		$instance = new static;

		if ( $instance->postType ) {
			$postType = PostType::make(
				$instance->postType,
				$instance->postTypeLabelPlural ?: $instance->postType,
				$instance->postTypeLabelSingle ?: $instance->postType
			);

			$postType->set( [
				'public'      => true,
				'has_archive' => true,
				'menu_icon'   => $instance->postTypeDashicon ?: 'dashicons-calendar',
				'supports'    => $instance->postTypeSupports ?: [ 'title', 'thumbnail' ]
			] );

			if ( $instance->postTypeSlug ) {
				$postType->set( [
					'rewrite' => [
						'slug' => $instance->postTypeSlug
					]
				] );
			}
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public static function published()
	{
		$instance = new static;

		$query = $instance->newQuery()->where('post_status', 'publish');

		$instance->postType ? $query = $query->where('post_type', $instance->postType) : null;

		return $query;
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	public function metaField($key)
	{
		return Meta::get($this->ID, $key, true);
	}

	/**
	 * @param string $size
	 * @return false|string
	 */
	public function featuredImage($size = '')
	{
		return get_the_post_thumbnail_url($this->ID, $size);
	}
}
