<?php

namespace Theme\Models\Traits;

use Theme\Models\Helpers\Helpers;

trait HasMeta
{

	/**
	 * @param bool $meta_key
	 * @return mixed|string
	 */
	public function getMeta($meta_key = false)
	{
		$meta_value = '';

		if ($meta_key) {
			$meta_value = $this->meta()->where('meta_key', $meta_key)->pluck('meta_value')->first();

			if (Helpers::isSerialized($meta_value)) {
				$meta_value = unserialize($meta_value);
			}

		}

		return $meta_value;
	}

	/**
	 * @param $key
	 * @param $value
	 * @return $this
	 */
	public function setMeta($key, $value)
	{
		$value = is_array($value) ? serialize($value) : $value;
		$meta = $this->meta()->firstOrCreate(['meta_key' => $key]);
		$meta = $this->meta()->where(['meta_key' => $key])->update(['meta_value' => $value]);

		return $this;
	}

	/**
	 * Deletes all meta for this object with given key
	 */
	public function deleteMeta($meta_key = false)
	{
		if ($meta_key) {
			$this->meta()->where('meta_key', $meta_key)->delete();
		}
	}
}
