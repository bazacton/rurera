<?php

use App\Mixins\Financial\MultiCurrency;
use App\Models\UserAssignedTopics;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use App\Models\Quiz;
use App\Models\QuizAttemptLogs;
use App\Models\QuizzAttempts;
use App\Models\QuizzesResult;
use App\Models\BooksPagesInfoLinks;
use App\Models\SubChapters;
use App\Models\WebinarChapterItem;
use Illuminate\Support\Facades\File;

function getObjectsProperty_bk($object_slug = ''){
	$default = array(
		'resize' => true,
		'rotate' => true,
		'drag' => true
	);
	$objects_array = array(
		'infolinks'	=> array(
			'check_it_makes_sense' => array(
				'path' => 'default/check_it_makes_sense.svg',
				'title' => 'Check it makes sense',
				'slug' => 'check_it_makes_sense',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/check_it_makes_sense.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'facts' => array(
				'path' => 'default/facts.svg',
				'title' => 'Facts',
				'slug' => 'facts',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/facts.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'look_for_clues' => array(
				'path' => 'default/look_for_clues.svg',
				'title' => 'Look for clues',
				'slug' => 'look_for_clues',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/look_for_clues.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'picture_in_your_mind' => array(
				'path' => 'default/picture_in_your_mind.svg',
				'title' => 'Picture in your mind',
				'slug' => 'picture_in_your_mind',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/picture_in_your_mind.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'quiz' => array(
				'path' => 'default/quiz.svg',
				'title' => 'Quiz',
				'slug' => 'quiz',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/quiz.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'think_and_remember' => array(
				'path' => 'default/think_and_remember.svg',
				'title' => 'Think and remember',
				'slug' => 'think_and_remember',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/think_and_remember.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
			'try_do_it_yourself' => array(
				'path' => 'default/try_do_it_yourself.svg',
				'title' => 'Try do it Yourself',
				'slug' => 'try_do_it_yourself',
				'svg_code' => file_get_contents('assets/books-editor/infolinks/default/try_do_it_yourself.svg'),
				'resize' => false,
				'rotate' => true,
				'drag' => true
			),
		),
		'objects'	=> array(
			'animal' => array(
				'path' => 'default/animal.svg',
				'title' => 'Animal',
				'slug' => 'animal',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/animal.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'bear' => array(
				'path' => 'default/bear.svg',
				'title' => 'Bear',
				'slug' => 'bear',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/bear.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'butterfly' => array(
				'path' => 'default/butterfly.svg',
				'title' => 'Butterfly',
				'slug' => 'butterfly',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/butterfly.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'fire' => array(
				'path' => 'default/fire.svg',
				'title' => 'Fire',
				'slug' => 'fire',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/fire.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'flate_earth' => array(
				'path' => 'default/flate_earth.svg',
				'title' => 'Flate Earth',
				'slug' => 'flate_earth',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/flate_earth.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'grass' => array(
				'path' => 'default/grass.svg',
				'title' => 'Grass',
				'slug' => 'grass',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/grass.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'home' => array(
				'path' => 'default/home.svg',
				'title' => 'Home',
				'slug' => 'home',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/home.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'map' => array(
				'path' => 'default/map.svg',
				'title' => 'Map',
				'slug' => 'map',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/map.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'mashroom' => array(
				'path' => 'default/mashroom.svg',
				'title' => 'Mashroom',
				'slug' => 'mashroom',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/mashroom.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'pool' => array(
				'path' => 'default/pool.svg',
				'title' => 'Pool',
				'slug' => 'pool',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/pool.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stone_1' => array(
				'path' => 'default/stone_1.svg',
				'title' => 'Stone',
				'slug' => 'stone_1',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stone_1.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stone_2' => array(
				'path' => 'default/stone_2.svg',
				'title' => 'Stone 2',
				'slug' => 'stone_2',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stone_2.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stone_earth' => array(
				'path' => 'default/stone_earth.svg',
				'title' => 'Stone Earth',
				'slug' => 'stone_earth',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stone_earth.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stone_grass' => array(
				'path' => 'default/stone_grass.svg',
				'title' => 'Stone Grass',
				'slug' => 'stone_grass',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stone_grass.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stones' => array(
				'path' => 'default/stones.svg',
				'title' => 'Stones',
				'slug' => 'stones',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stones.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'stop' => array(
				'path' => 'default/stop.svg',
				'title' => 'Stop',
				'slug' => 'stop',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/stop.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'table' => array(
				'path' => 'default/table.svg',
				'title' => 'Table',
				'slug' => 'table',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/table.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree' => array(
				'path' => 'default/tree.svg',
				'title' => 'Tree',
				'slug' => 'tree',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_2' => array(
				'path' => 'default/tree_2.svg',
				'title' => 'Tree 2',
				'slug' => 'tree_2',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_2.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_3' => array(
				'path' => 'default/tree_3.svg',
				'title' => 'Tree 3',
				'slug' => 'tree_3',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_3.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_4' => array(
				'path' => 'default/tree_4.svg',
				'title' => 'Tree 4',
				'slug' => 'tree_4',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_4.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_5' => array(
				'path' => 'default/tree_5.svg',
				'title' => 'Tree 5',
				'slug' => 'tree_5',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_5.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_6' => array(
				'path' => 'default/tree_6.svg',
				'title' => 'Tree 6',
				'slug' => 'tree_6',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_6.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_7' => array(
				'path' => 'default/tree_7.svg',
				'title' => 'Tree 7',
				'slug' => 'tree_7',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_7.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'tree_8' => array(
				'path' => 'default/tree_8.svg',
				'title' => 'Tree 8',
				'slug' => 'tree_8',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/tree_8.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
			'water' => array(
				'path' => 'default/water.svg',
				'title' => 'Water',
				'slug' => 'water',
				'svg_code' => file_get_contents('assets/books-editor/objects/default/water.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
		),
		'misc'	=> array(
			'highlighter' => array(
				'path' => 'default/highlighter.svg',
				'title' => 'Highlighter',
				'slug' => 'highlighter',
				'svg_code' => file_get_contents('assets/books-editor/misc/default/highlighter.svg'),
				'resize' => true,
				'rotate' => true,
				'drag' => true
			),
		),
	);
	
	$response = $objects_array;
	
	if( $object_slug != ''){
		$response = isset( $objects_array[$object_slug] )? $objects_array[$object_slug] : $default;
	}
	return $response;
}