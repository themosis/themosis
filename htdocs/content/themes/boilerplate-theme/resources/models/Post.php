<?php

namespace Theme\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Themosis\Facades\PostType;
use Themosis\Metabox\Meta;

/**
 * Class Post.
 * Help you retrieve data from your $prefix_posts table.
 *
 * @package Theme\Models
 */
class Post extends Model {
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
		'public'      => true,
		'has_archive' => true,
		'menu_icon'   => 'dashicons-admin-page',
		'supports'    => [ 'title', 'thumbnail' ]
	];
	/** @var bool  */
	protected $postTypeOptionsPage = true;

	/**
	 * @return void
	 */
	protected static function boot() {
		parent::boot();

		static::addGlobalScope( 'postType', function ( Builder $builder ) {
			( $instance = new static )->postType ? $builder->where( 'post_type', $instance->postType ) : null;
		} );
	}

	/**
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function scopePublished( Builder $query ) {
		return $query->where( 'post_status', 'publish' );
	}

	/**
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function scopeMenuOrder( Builder $query ) {
		return $query->orderBy( 'menu_order' );
	}

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

			$postType->set( $instance->postTypeOptions );

			if (function_exists('acf_add_options_page') && $instance->postTypeOptionsPage) {
				acf_add_options_page(array(
					'page_title' => 'Options - ' . $instance->postTypeLabelSingle,
					'menu_title' => 'Options - ' . $instance->postTypeLabelSingle,
					'menu_slug' => 'options-' . $instance->postType,
					'capability' => 'edit_posts',
					'parent_slug' => 'edit.php?post_type=' . $instance->postType,
					'position' => false,
					'icon_url' => 'dashicons-images-alt2',
					'redirect' => false,
				));
			}
		}
	}

	/**
	 * @param $key
	 *
	 * @return mixed
	 */
	public function getField( $key ) {
		return Meta::get( $this->ID, $key, true );
	}

	/**
	 * @param array|null $queryVars
	 * @param bool $leaveName
	 *
	 * @return string
	 */
	public function permalink( array $queryVars = null, $leaveName = false ) {

		$queryString = null;

		if ( $queryVars ) {
			$queryString = http_build_query( $queryVars );
		}

		return get_permalink( $this->ID, $leaveName ) . (@$queryString ? '?' . $queryString : '');
	}

	/**
	 * @param string $size
	 *
	 * @return false|string
	 */
	public function featuredImage( $size = '' ) {
		return get_the_post_thumbnail_url( $this->ID, $size );
	}
}
