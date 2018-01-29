<?php
/**
 * Enqueue main script and main style from `bento` manifest
 */
$manifest = container("bento.manifest");

$manifest->add_main_style();
$manifest->add_main_script();
