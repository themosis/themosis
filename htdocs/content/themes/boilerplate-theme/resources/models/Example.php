<?php

namespace Theme\Models;

use Theme\Models\Post as BasePost;

/**
 * Class Post.
 * Help you retrieve data from your $prefix_posts table.
 *
 * @package Theme\Models
 */
class Example extends BasePost {

	/** @var string|bool null */
	protected $postType = 'example';
	/** @var string|null */
	protected $postTypeLabelPlural = 'Examples';
	/** @var string|null */
	protected $postTypeLabelSingle = 'Example';

}
