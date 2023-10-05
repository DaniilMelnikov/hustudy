<?php


class My_Walker_Nav_Menu extends Walker_Nav_Menu {

	/**
	 * Starts the element output.
	 *
	 * @since 3.0.0
	 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
	 *
	 * @see Walker::start_el()
	 *
	 * @param string   $output Passed by reference. Used to append additional content.
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */

    // add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = NULL ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
		$display_depth = ( $depth + 1); // because it counts the first submenu as 0
		$classes = array(
			'submenu',
			( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
			( $display_depth >=2 ? 'sub-sub-menu' : '' ),
			'menu-depth-' . $display_depth
		);
		$class_names = implode( ' ', $classes );

		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		global $wp_query;

		// Restores the more descriptive, specific name for use within this method.
		$item = $data_object;

		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'has-dropdown with-megamenu has-menu-child-item position-static menu-item-open' : 'has-dropdown' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );

		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';

		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}


function getArrayCat($arrExclude=array(15,16,18)) {
	$categories = get_categories(array(
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 0,
		'exclude'      => $arrExclude,
		'include'      => '',
	));
	return $categories;
}

//Быстрая сортировка
function quickSort(array $arr) {
    $count= count($arr);
    if ($count <= 1) {
        return $arr;
    }
 
    $first_val = $arr[0][1];
	$first_arr = $arr[0];
    $left_arr = array();
    $right_arr = array();
 
    for ($i = 1; $i < $count; $i++) {
        if ($arr[$i][1] >= $first_val) {
            $left_arr[] = $arr[$i];
        } else {
            $right_arr[] = $arr[$i];
        }
    }
 
    $left_arr = quickSort($left_arr);
    $right_arr = quickSort($right_arr);
 
    return array_merge($left_arr, array($first_arr), $right_arr);
}


function get_rate($filterArr=[]){
	$arg_cat = array(
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 0,
        'include'      => array(15),
    );
	$categories = get_categories( $arg_cat )[0];
	$my_posts = get_posts(array(
		'category'     => $categories->term_id,
	));

	$arrayPostsRate = [];
	foreach( $my_posts as $post ){
		$rate = get_field('rate', $post->ID);
		$course = get_field('rewiews_course_rel', $post->ID);
		if(!in_array($course,$filterArr)&&$filterArr){continue;}
		if(array_key_exists($course, $arrayPostsRate)){
			$arrayPostsRate[$course][2] += 1;
			$arrayPostsRate[$course][1][] = $rate;
		} else {
			$arrayPostsRate[$course] = array($course, array($rate), 1);
		}
			
	}

	$newArrPost = [];
	foreach($arrayPostsRate as $key=>$course){
		$rateArray = $course[1];
		$count = count($rateArray);
		$num = 0;
		for ($i = 0; $i < $count; $i++) {
			$num += $rateArray[$i];
		}
		$arrayPostsRate[$key][1] = round($num/$count, 1);
		$newArrPost[$key] = $arrayPostsRate[$key];
	}

	$arrayPostsRate = $newArrPost;
	unset($newArrPost);
	return $arrayPostsRate;
}

function get_teacher_course($id){
	$teachers = get_posts(array(
		'category'  => 18,
	));
	foreach($teachers as $teacher){
		$courses = get_field('course_teacher', $teacher->ID);
		if($courses){
			foreach($courses as $course){
				if($course==$id){
					return $teacher;
				}
			}
		}
	}
	return 0;
}



add_action( 'init', 'register_remote_scripts' );

function register_remote_scripts(){
	wp_register_script( 'histudyScript-js', 'http://kursy.existparts.ru/wp-content/themes/histudy/assets/js/vendor/jquery.js' , '', '', true );
}


// Подключаем локализацию в самом конце подключаемых к выводу скриптов, чтобы скрипт
// 'twentyfifteen-script', к которому мы подключаемся, точно был добавлен в очередь на вывод.
// Заметка: код можно вставить в любое место functions.php темы
add_action( 'wp_enqueue_scripts', 'myajax_data', 99 );
function myajax_data(){

	// Первый параметр 'twentyfifteen-script' означает, что код будет прикреплен к скрипту с ID 'twentyfifteen-script'
	// 'twentyfifteen-script' должен быть добавлен в очередь на вывод, иначе WP не поймет куда вставлять код локализации
	// Заметка: обычно этот код нужно добавлять в functions.php в том месте где подключаются скрипты, после указанного скрипта
	wp_localize_script( 'histudyScript-js', 'myajax',
		array(
			'url' => admin_url('admin-ajax.php')
		)
	);

}


add_action( 'wp_ajax_ajax_menu_catalog_mobile', 'ajax_menu_catalog_mobile_callback' );
add_action( 'wp_ajax_nopriv_ajax_menu_catalog_mobile', 'ajax_menu_catalog_mobile_callback' );
function ajax_menu_catalog_mobile_callback() {
	$arrayMenu = wp_get_nav_menu_items('header-menu');
	//print_r($arrayMenu);
	$result = '';
    if($arrayMenu) {
		foreach($arrayMenu as $cat){
			if ($cat->menu_item_parent == 0) {
				$idParent = $cat->ID;

				$element = '';							
				foreach($arrayMenu as $catParent){
					if ($catParent->menu_item_parent == $idParent) {
						$element .=
						'<!-- Start Single Demo  -->' .
						'<div class="col-lg-12 col-xl-2 col-xxl-2 col-md-12 col-sm-12 col-12 single-mega-item">' .
							'<div class="demo-single">' .
								'<div class="inner">' .
									'<div class="thumbnail">' .
										'<a href="'. $catParent->url .'"><img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/splash/demo/h1.jpg" alt="Demo Images"></a>' .
									'</div>' .
									'<div class="content">' .
										'<h4 class="title"><a href="'. $catParent->url .'">'. $catParent->title .' <span class="btn-icon"><i class="feather-arrow-right"></i></span></a></h4>' .
									'</div>' .
								'</div>' .
							'</div>' .
						'</div>' .
						'<!-- End Single Demo  -->';
					}
				}
				if($element==''){
					$result .= 
					'<li>' .
						'<a href="' . $cat->url .'">' . $cat->title .' <i class="feather-chevron-down"></i></a>' .
					'</li>';
					continue;
				}
				//echo $idParent;
				$result .= 
				'<li class="with-megamenu has-menu-child-item position-static">' .
					'<a href="' . $cat->url .'" class="">' . $cat->title .' <i class="feather-chevron-down"></i></a>' .
					'<!-- Start Mega Menu  -->' .
					'<div class="rbt-megamenu menu-skin-dark" style="display: none;">' .
						'<div class="wrapper">' .
							'<div class="row row--15 home-plesentation-wrapper single-dropdown-menu-presentation">';

				
				$result .= $element;
				$result .= 
							'</div>' .

							'<div class="load-demo-btn text-center">' .
								'<a class="rbt-btn-link color-white" href="#">Scroll to view more <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down-up" viewBox="0 0 16 16">' .
										'<path fill-rule="evenodd" d="M11.5 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L11 2.707V14.5a.5.5 0 0 0 .5.5zm-7-14a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L4 13.293V1.5a.5.5 0 0 1 .5-.5z"></path>' .
									'</svg></a>' .
							'</div>' .
						'</div>' .
					'</div>' .
					'<!-- End Mega Menu  -->' .
				'</li>';
			}
		}
	}
	echo substr($result, 0, -1);
}



add_action( 'wp_ajax_ajax_menu_catalog', 'ajax_menu_catalog_callback' );
add_action( 'wp_ajax_nopriv_ajax_menu_catalog', 'ajax_menu_catalog_callback' );
function ajax_menu_catalog_callback() {
    $categories = getArrayCat();
	$result = '';
    if($categories) {
		$element = 
        '<div class="rbt-vertical-nav">' .
            '<ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">';
        foreach( $categories as $cat ) {
            if ($cat->parent == 0) {
				$element .= 
                '<li class="vertical-nav-item">' .
                    '<a href="#tab' . $cat->term_id . '">' . $cat->name .'</a>' .
                '</li>';
            }
		}
		$element .=
            '</ul>' .
        '</div>';
	}
	$result .= $element;

    $result .= '<div class="rbt-vertical-nav-content">';
	

	foreach( $categories as $cat ){
		if ($cat->parent == 0){
			$countEl = 0;
			$arg_cat = array(
				'orderby'      => 'name',
				'order'        => 'ASC',
				'child_of'     => $cat->term_id,
				'hide_empty'   => 0,
				'exclude'      => '',
				'include'      => '',
			);
			$categoriesParent = get_categories( $arg_cat );
			$arrCat = [];
			$currentCat = false;
			if (count($categoriesParent) > 4){
				foreach( $categoriesParent as $cat ){
					if ($countEl==4){
						$countEl = 0;
						$arrCat[] = $arrDouble;
						$arrDouble = [];
					}
					$arrDouble[] = $cat;
					$countEl++;
				}
				$categoriesParent = $arrCat;
				$currentCat = true;
				unset($arrDouble, $arrCat);
			}

			$element = '';
			$blockEl = '';
			if($currentCat){
				for($i=0;$i<count($categoriesParent);$i++){
					foreach($categoriesParent[$i] as $cat_){
						$element .= '<li><a href="/'. $cat_->slug .'/">'. $cat_->name .'</a></li>';
					}
					$blockEl .= 
					'<div class="col-lg-6 col-sm-6 col-6">' .
						'<div class="vartical-nav-content-menu">' .
							'<h3 class="rbt-short-title">Course Title</h3>' .
							'<ul class="rbt-vertical-nav-list-wrapper">' . 
							$element .
							'</ul>' .
						'</div>' .
					'</div>';
				}
			} else {
				foreach($categoriesParent as $cat_){
					$element .= '<li><a href="/'. $cat_->slug .'/">'. $cat_->name .'</a></li>';
				}
				$blockEl .= 
				'<div class="col-lg-6 col-sm-6 col-6">' .
					'<div class="vartical-nav-content-menu">' .
						'<h3 class="rbt-short-title">Course Title</h3>' .
						'<ul class="rbt-vertical-nav-list-wrapper">' . 
						$element .
						'</ul>' .
					'</div>' .
				'</div>';
			}

			$result .= 
					'<div class="rbt-vertical-inner tab-content" id="tab' . $cat->term_id . '" style="display: none; opacity: 1;">' .
						'<div class="rbt-vertical-single">' .
							'<div class="row">' .
							$blockEl .
							'</div>' .
						'</div>' .
					'</div>';
		}
    }

    $result .= '</div>';

	echo substr($result, 0, -1);
}



add_action( 'wp_ajax_top_categories', 'top_categories_callback' );
add_action( 'wp_ajax_nopriv_top_categories', 'top_categories_callback' );
function top_categories_callback() {
	$tag_ = strval($_POST['tag_']);
	if($tag_==''){
		$tags = get_tags(array(
			'hide_empty' => false,
			'exclude'    => array(13),
			));
	} else {
		$tags = get_tags(array(
			'hide_empty' => false,
			'name'       => $tag_,
			));
	}
	
	$categories = get_categories( array(
			'orderby'      => 'name',
			'order'        => 'ASC',
			'hide_empty'   => 0,
			'exclude'      => '',
			'include'      => '',
		));
	$counterTag = 1;
	
	foreach( $tags as $tag ){
		$arrayCat = [];
		$counterCat = 0;
		foreach( $categories as $cat ){
			$my_posts = get_posts( array(
				'tag'       => $tag->slug,
				'category'  => $cat->term_id,
			) );

			if($my_posts && $cat->parent != 0){
				$arrayCat[$cat->name] = $cat;
			} else if(!$tag){
				$arrayCat[$cat->name] = $cat;
			}
		}
	}

	$result = '';
	foreach($arrayCat as $cat){
		$element =
		'<div class="col-lg-3 col-md-6 col-sm-6 col-12">' .
			'<div class="rbt-cat-box rbt-cat-box-1 variation-3 text-center">' .
				'<div class="inner">' .
					'<div class="thumbnail">' .
						'<a href="'. $cat->slug .'/">'.
							'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/category/image/personal-development.jpg" alt="'. $cat->name .'">' .
							'<div class="read-more-btn">' .
								'<span class="rbt-btn btn-sm btn-white radius-round">'. $cat->count .' Courses</span>' .
							'</div>' .
						'</a>' .
					'</div>' .
					'<div class="content">' .
						'<h5 class="title"><a href="'. $cat->slug .'/">'. $cat->name .'</a></h5>' .
						'<p class="description">'. $cat->description .'</p>'.
					'</div>' .
				'</div>' .
			'</div>' .
		'</div>';
		$result .= $element;
	}
	echo $result;

	// выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
	wp_die();
}

add_action( 'wp_ajax_top_courses', 'top_courses_callback' );
add_action( 'wp_ajax_nopriv_top_courses', 'top_courses_callback' );
function top_courses_callback() {
	
	$tags = get_tags(array(
		'hide_empty' => false,
		'include'    => array(13),
	));

	$arrayPostsRate = [];
	foreach( $tags as $tag ){

		$my_posts = get_posts(array(
			'tag'     => $tag->slug,
		));

		foreach( $my_posts as $post ){
			$rate = get_field('rate', $post->ID);
			$course = get_field('rewiews_course_rel', $post->ID);
			if(array_key_exists($course, $arrayPostsRate)){
				$arrayPostsRate[$course][2] += 1;
				$arrayPostsRate[$course][1][] = $rate;
			} else {
				$arrayPostsRate[$course] = array($course, array($rate), 1);
			}
			
		}
		
	}

	$newArrPost = [];
	foreach( $arrayPostsRate as $key => $course ){
		$rateArray = $course[1];
		$count = count($rateArray);
		$num = 0;
		for ($i = 0; $i < $count; $i++) {
			$num += $rateArray[$i];
		}
		$arrayPostsRate[$key][1] = round($num / $count, 1);
		$newArrPost[] = $arrayPostsRate[$key];
	}

	$arrayPostsRate = quickSort($newArrPost);
	unset($newArrPost);

	$result = '';
	$count = 0;
	foreach( $arrayPostsRate as $post ){
		$ID = $post[0];
		$RATE = round($post[1]);
		$COUNT_REVIEW = $post[2];
		$STUDENT = get_field('students', $ID);
		$LESSON = get_field('lesson', $ID);

		$teacher = get_teacher_course($ID);
		$NAME_TEACHER = get_the_title($teacher->ID);
		$SKILL_TEACHER = get_field('skill', $teacher->ID);

		$SALE = get_field('sale', $ID);
		$PRICE = get_field('price', $ID);
		$OLD_PRICE = get_field('old_price', $ID);
		$CURRENCY = get_field('currency', $ID);
		$featured_img_url = get_the_post_thumbnail_url($ID,'full');

		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($ID) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/classic-lms-01.jpg" alt="'. get_the_title($ID) .'">';
		}

		$star = '';
		for($i = 0; $i < $RATE; $i++){
			$star .= '<i class="fas fa-star"></i>';
		}

		for($i = 0; $i < 5-$RATE; $i++){
			$star .= '<i class="off fas fa-star"></i>';
		}

		$saleText = '';
		if($SALE){
			$saleText =
			'<div class="rbt-badge-3 bg-white">' .
				'<span>-'. $SALE .'%</span>' .
				'<span>Off</span>' .
			'</div>';
		}

		$teachetText = '';
		if($NAME_TEACHER){
			$teachetText =
			'<div class="rbt-author-meta mb--10">' .
				'<div class="rbt-avater">' .
					'<a href="#">' .
						'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
					'</a>' .
				'</div>' .
				'<div class="rbt-author-info">' .
					'By <a href="'. get_permalink($ID) .'">'. $NAME_TEACHER .'</a> In <a href="#">'. $SKILL_TEACHER .'</a>' .
				'</div>' .
			'</div>';
		}

		$oldPriceText = '';
		if($OLD_PRICE){
			$oldPriceText = '<span class="off-price">$'. $CURRENCY . $OLD_PRICE .'</span>';
		}

		$lessonText = '';
		if($LESSON){
			$lessonText = '<li><i class="feather-book"></i>'. $LESSON .' Lessons</li>';
							
		}

		$studentText = '';
		if($STUDENT){
			$studentText = '<li><i class="feather-users"></i>'. $STUDENT .' Students</li>';
		}

		if($count==3){
			break;
		}
		$element = 	
			'<!-- Start Single Course  -->' .
			'<div class="col-lg-4 col-md-6 col-sm-12 col-12 sal-animate" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">' .
				'<div class="rbt-card variation-01 rbt-hover">' .
					'<div class="rbt-card-img">' .
						'<a href="'. get_permalink($ID) .'">' .
							$imgText .
							$saleText .
						'</a>' .
					'</div>' .
					'<div class="rbt-card-body">' .
						'<div class="rbt-card-top">' .
							'<div class="rbt-review">' .
								'<div class="rating">' .
									$star .
								'</div>' .
								'<span class="rating-count"> ('. $COUNT_REVIEW .' Reviews)</span>' .
							'</div>' .
							'<div class="rbt-bookmark-btn">' .
								'<a class="rbt-round-btn" title="Bookmark" href="#"><i class="feather-bookmark"></i></a>' .
							'</div>' .
						'</div>' .
						'<h4 class="rbt-card-title"><a href="'. get_permalink($ID) .'">'. get_the_title($ID) .'</a>' .
						'</h4>' .
						'<ul class="rbt-meta">' .
							$lessonText .
							$studentText .
						'</ul>' .
						'<p class="rbt-card-text">'. get_the_excerpt($ID) .'</p>' .
						$teachetText .
						'<div class="rbt-card-bottom">' .
							'<div class="rbt-price">' .
								'<span class="current-price">'. $CURRENCY . $PRICE .'</span>' .
								$oldPriceText .
							'</div>' .
							'<a class="rbt-btn-link" href="'. get_permalink($ID) .'">Learn More<i class="feather-arrow-right"></i></a>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>' .
			'<!-- End Single Course  -->';
		$result .= $element;
		$count++;
	}
	echo substr($result, 0, -1);

}




add_action( 'wp_ajax_top_courses_header', 'top_courses_header_callback' );
add_action( 'wp_ajax_nopriv_top_courses_header', 'top_courses_header_callback' );
function top_courses_header_callback() {
	
	$tags = get_tags(array(
		'hide_empty' => false,
		'include'    => array(13),
	));

	$arrayPostsRate = [];
	foreach( $tags as $tag ){

		$my_posts = get_posts(array(
			'tag'     => $tag->slug,
		));

		foreach( $my_posts as $post ){
			$rate = get_field('rate', $post->ID);
			$course = get_field('rewiews_course_rel', $post->ID);
			if(array_key_exists($course, $arrayPostsRate)){
				$arrayPostsRate[$course][2] += 1;
				$arrayPostsRate[$course][1][] = $rate;
			} else {
				$arrayPostsRate[$course] = array($course, array($rate), 1);
			}
			
		}
		
	}

	$newArrPost = [];
	foreach( $arrayPostsRate as $key => $course ){
		$rateArray = $course[1];
		$count = count($rateArray);
		$num = 0;
		for ($i = 0; $i < $count; $i++) {
			$num += $rateArray[$i];
		}
		$arrayPostsRate[$key][1] = round($num / $count, 1);
		$newArrPost[] = $arrayPostsRate[$key];
	}

	$arrayPostsRate = quickSort($newArrPost);
	unset($newArrPost);

	$result = '';
	$count = 0;
	foreach( $arrayPostsRate as $post ){
		$ID = $post[0];
		$RATE = round($post[1]);
		$COUNT_REVIEW = $post[2];
		$STUDENT = get_field('students', $ID);
		$LESSON = get_field('lesson', $ID);

		$teacher = get_teacher_course($ID);
		$NAME_TEACHER = get_the_title($teacher->ID);
		$SKILL_TEACHER = get_field('skill', $teacher->ID);

		$SALE = get_field('sale', $ID);
		$PRICE = get_field('price', $ID);
		$OLD_PRICE = get_field('old_price', $ID);
		$CURRENCY = get_field('currency', $ID);
		$featured_img_url = get_the_post_thumbnail_url($ID,'full');

		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($ID) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/course-online-01.jpg" alt="'. get_the_title($ID) .'">';
		}

		$star = '';
		for($i = 0; $i < $RATE; $i++){
			$star .= '<i class="fas fa-star"></i>';
		}

		for($i = 0; $i < 5-$RATE; $i++){
			$star .= '<i class="off fas fa-star"></i>';
		}

		$saleText = '';
		if($SALE){
			$saleText =
			'<div class="rbt-badge-3 bg-white">' .
				'<span>-'. $SALE .'%</span>' .
				'<span>Off</span>' .
			'</div>';
		}

		$teachetText = '';
		if($NAME_TEACHER){
			$teachetText =
			'<div class="rbt-author-meta mb--10">' .
				'<div class="rbt-avater">' .
					'<a href="#">' .
						'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
					'</a>' .
				'</div>' .
				'<div class="rbt-author-info">' .
					'By <a href="'. get_permalink($ID) .'">'. $NAME_TEACHER .'</a> In <a href="#">'. $SKILL_TEACHER .'</a>' .
				'</div>' .
			'</div>';
		}

		$oldPriceText = '';
		if($OLD_PRICE){
			$oldPriceText = '<span class="off-price">$'. $CURRENCY . $OLD_PRICE .'</span>';
		}

		$lessonText = '';
		if($LESSON){
			$lessonText = '<li><i class="feather-book"></i>'. $LESSON .' Lessons</li>';
							
		}

		$studentText = '';
		if($STUDENT){
			$studentText = '<li><i class="feather-users"></i>'. $STUDENT .' Students</li>';
		}

		if($count==4){
			break;
		}
		$element = 	
			'<!-- Start Single Course  -->' .
			'<div class="col-lg-3 col-md-4 col-sm-6 col-12">' .
				'<div class="rbt-card variation-01 rbt-hover">' .
					'<div class="rbt-card-img">' .
						'<a href="'. get_permalink($ID) .'">' .
							$imgText .
							$saleText .
						'</a>' .
					'</div>' .
					'<div class="rbt-card-body">' .
						'<h5 class="rbt-card-title"><a href="'. get_permalink($ID) .'">'. get_the_title($ID) .'</a></h5>' .
						'<div class="rbt-review">' .
                            '<div class="rating">' .
								$star .
                            '</div>' .
                            '<span class="rating-count"> ('. $COUNT_REVIEW .' Reviews)</span>' .
                        '</div>' .
                        '<div class="rbt-card-bottom">' .
                            '<div class="rbt-price">' .
                                '<span class="current-price">'. $CURRENCY . $PRICE .'</span>' .
                                $oldPriceText .
                            '</div>' .
                        '</div>' .
					'</div>' .
				'</div>' .
			'</div>' .
			'<!-- End Single Course  -->';
		$result .= $element;
		$count++;
	}
	echo substr($result, 0, -1);

}



add_action( 'wp_ajax_feedback', 'feedback_callback' );
add_action( 'wp_ajax_nopriv_feedback', 'feedback_callback' );
function feedback_callback() {
	$tag = get_tags(array(
		'hide_empty' => false,
		'include'    => array(13),
	))[0];

	$my_posts = get_posts(array(
		'tag'     => $tag->slug,
		'orderby' => 'date',
	));
	$count = round(9 / count($my_posts));

	$result = '';
	for($i=0;$i<$count;$i++){
		foreach($my_posts as $post) {
			$POSITION = get_field('position', $post->ID);
			if($POSITION){
				$positionText = '<span>' . $POSITION . '</span>';
			}
			$element =
			'<!-- Start Single Testimonial  -->' .
				'<div class="single-column-20">' .
					'<div class="rbt-testimonial-box">' .
						'<div class="inner">' .
							'<div class="clint-info-wrapper">' .
								'<div class="thumb">' .
									'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/testimonial/client-01.png" alt="Clint Images">' .
								'</div>' .
								'<div class="client-info">' .
									'<h5 class="title">'.  get_the_title($post) .'</h5>' .
									$positionText .
								'</div>' .
							'</div>' .
							'<div class="description">' .
								'<p class="subtitle-3">'. get_the_content( null, false, $post ) .'</p>' .
								//'<a class="rbt-btn-link" href="#">Read Project Case Study<i class="feather-arrow-right"></i></a>' .
							'</div>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'<!-- End Single Testimonial  -->';
			$result .= $element;
		}
	}

	echo $result;

	
}


add_action( 'wp_ajax_top_news', 'top_news_callback' );
add_action( 'wp_ajax_nopriv_top_news', 'top_news_callback' );
function top_news_callback() {
	$tag = get_tags(array(
		'hide_empty' => false,
		'include'    => array(17),
	))[0];

	$my_posts = get_posts(array(
		'tag'     => $tag->slug,
		'orderby' => 'date',
	));
	$countNews = 0;
	$result = '';
	

	foreach($my_posts as $post) {
		$featured_img_url = get_the_post_thumbnail_url($post,'full');

		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($ID) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/classic-lms-01.jpg" alt="'. get_the_title($ID) .'">';
		}
		if($countNews < 3){
			$result .=
			'<!-- Start Single Card  -->' .
			'<div class="col-lg-4 col-md-6 col-sm-12 col-12">' .
				'<div class="rbt-card variation-02 rbt-hover">' .
					'<div class="rbt-card-img">' .
						'<a href="'. get_permalink($ID) .'">' .
							$imgText . '</a>' .
					'</div>' .
					'<div class="rbt-card-body">' .
						'<h5 class="rbt-card-title"><a href="'. get_permalink($post) .'">'.  get_the_title($post) .'</a></h5>' .
						' <p class="rbt-card-text">'. get_the_excerpt($post) .'</p>' .
						'<div class="rbt-card-bottom">' .
							'<a class="transparent-button" href="'. get_permalink($post) .'">Learn More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"></path><path stroke-linecap="square" d="M.663 5.572h14.594"></path></g></svg></i></a>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>' .
			'<!-- End Single Card  -->';
			$countNews++;
		} else {
			break;
		}
		
	}
	echo substr($result, 0, -1);
}


add_action( 'wp_ajax_view_courses', 'view_courses_callback' );
add_action( 'wp_ajax_nopriv_view_courses', 'view_courses_callback' );
function view_courses_callback() {
	$categories_ =  $_POST['categories_'] ? $_POST['categories_'] : array();
	$rate_ = strval($_POST['rate_']);
	$teacher_ = $_POST['teacher_'] ? $_POST['teacher_'] : array();
	$price_ = $_POST['price_'] ? $_POST['price_'] : array();
	$levels_ = $_POST['levels_'] ? $_POST['levels_'] : array();

	$short_ = $_POST['short_'] ? $_POST['short_'] : array();
	
	if($rate_){
		$resulrArr = [];
		$rateArr = get_rate();
		foreach($rateArr as $rate){
			if($rate[1]==$rate_){
				$resulrArr[] = $rate[0];
			}
		}
		$rate_ = $resulrArr;
		if(!$rate_){
			return ;
		}
		unset($resulrArr);
	}

	$arrProp = [];

	if($categories_){
		$arrProp['category'] = $categories_;
	}else{
		$categories = getArrayCat();
		$idArr = array();
		foreach($categories as $cat){
			if($cat->parent){
				$idArr[] = $cat->term_id;
			}
		}
		$arrProp['category'] = $idArr;
	}

	if($rate_){
		$arrProp['include'] = $rate_;
	}


	$arrPosts = [];
	
	$teacherField = 0;
	$priceField = 0;
	$levelField = 0;
	
	$my_posts = get_posts($arrProp);

	foreach($my_posts as $post){
		if($teacher_){		
			$teacher = get_teacher_course($post->ID);
			if(!$teacher){continue;}
		}
			
		$arrPosts[$post->ID] = $post;
	}

	foreach($my_posts as $post){
		if($price_){
			$priceField = get_field('price_filter', $post->ID);
			if($priceField==$price_){continue;}
		}
			
		$arrPosts[$post->ID] = $post;
	}

	foreach($my_posts as $post){
		if($levels_){
			$levelField = get_field('level_filter', $post->ID);
			if($levelField==$levels_) {continue;} 
		}
			
		$arrPosts[$post->ID] = $post;
	}

	$arrayPostsRate = get_rate();

	if($short_=='Latest'){
		$arrPosts = array_reverse($arrPosts, $preserve_keys=true);
	} elseif(
		$short_=='Price: low to high'||$short_=='Price: high to low'
		) {
		$arrPrice = [];
		$arrResult = [];
		foreach($arrPosts as $id=>$course_post){
			$PRICE = get_field('price', $id);
			if(!$PRICE){$PRICE=0;}
			$arrPrice[$id] = $PRICE;
		}
		unset($PRICE);
		if($short_=='Price: low to high'){
			asort($arrPrice);
		} else {
			arsort($arrPrice);
		}
		foreach($arrPrice as $id=>$value){
			$arrResult[$id] = $arrPosts[$id];
		}
		$arrPosts = $arrResult;
		unset($arrResult);

	} elseif($short_='Popularity'){
		$arrRate = [];
		$arrResult = [];
		foreach($arrPosts as $id=>$course_post){
			$RATE = 0;
			if(key_exists($id,$arrayPostsRate)){
				$RATE = $arrayPostsRate[$id][2];
			}
			$arrRate[$id] = $RATE;
		}
		arsort($arrRate);
		unset($RATE);
		foreach($arrRate as $id=>$value){
			$arrResult[$id] = $arrPosts[$id];
		}
		$arrPosts = $arrResult;
		unset($arrResult);
	} elseif($short_='Trending'){
		$arrRate = [];
		$arrResult = [];
		foreach($arrPosts as $id=>$course_post){
			$RATE = 0;
			if(key_exists($id,$arrayPostsRate)){
				$RATE = $arrayPostsRate[$id][1];
			}
			$arrRate[$id] = $RATE;
		}
		arsort($arrRate);
		unset($RATE);
		foreach($arrRate as $id=>$value){
			$arrResult[$id] = $arrPosts[$id];
		}
		$arrPosts = $arrResult;
		unset($arrResult);
	}

	$result = '';
	foreach($arrPosts as $id=>$course_post){
		$RATE = 0;
		$COUNT_REVIEW = 0;
		if(key_exists($id,$arrayPostsRate)){
			$RATE = $arrayPostsRate[$id][1];
			$COUNT_REVIEW = $arrayPostsRate[$id][2];
		}

		$STUDENT = get_field('students', $id);
		
		$LESSON = get_field('lesson', $id);

		$teacher = get_teacher_course($id);
		$NAME_TEACHER = 0;
		$SKILL_TEACHER = 0;
		if($teacher){
			$NAME_TEACHER = get_the_title($teacher->ID);
			$SKILL_TEACHER = get_field('skill', $teacher->ID);
		}

		$SALE = get_field('sale', $id);
		$PRICE = get_field('price', $id);
		$OLD_PRICE = get_field('old_price', $id);
		$CURRENCY = get_field('currency', $id);
		$featured_img_url = get_the_post_thumbnail_url($id,'full');

		$imgText='';
		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($id) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/classic-lms-01.jpg" alt="'. get_the_title($id) .'">';
		}
	
		$star = '';
		for($i = 0; $i < $RATE; $i++){
			$star .= '<i class="fas fa-star"></i>';
		}
	
		for($i = 0; $i < 5-$RATE; $i++){
			$star .= '<i class="off fas fa-star"></i>';
			}
		$saleText='';
		if($SALE){
			$saleText =
				'<div class="rbt-badge-3 bg-white">' .
					'<span>-'. $SALE .'%</span>' .
					'<span>Off</span>' .
				'</div>';
		}
		$teachetText='';
		if($NAME_TEACHER){
			$teachetText =
				'<div class="rbt-author-meta mb--10">' .
					'<div class="rbt-avater">' .
						'<a href="#">' .
							'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
						'</a>' .
					'</div>' .
					'<div class="rbt-author-info">' .
						'By <a href="profile.html">'. $NAME_TEACHER .'</a> In <a href="#">'. $SKILL_TEACHER .'</a>' .
					'</div>' .
				'</div>';
		}
		$oldPriceText='';
		if($OLD_PRICE){
			$oldPriceText = '<span class="off-price">$'. $CURRENCY . $OLD_PRICE .'</span>';
		}
		$lessonText='';
		if($LESSON){
			$lessonText = '<li><i class="feather-book"></i>'. $LESSON .' Lessons</li>';
								
		}
		$studentText='';
		if($STUDENT){
			$studentText = '<li><i class="feather-users"></i>'. $STUDENT .' Students</li>';
		}


		$element =
			'<!-- Start Single Card  -->' .
			'<div class="course-grid-3">' .
				'<div class="rbt-card variation-01 rbt-hover">' .
					'<div class="rbt-card-img">' .
						'<a href="'. get_permalink($course_post) .'">' .
							$imgText .
							$saleText .
						'</a>' .
					'</div>' .
					'<div class="rbt-card-body">' .
						'<div class="rbt-card-top">' .
							'<div class="rbt-review">' .
								'<div class="rating">' .
									$star .
								'</div>' .
								'<span class="rating-count"> ('. $COUNT_REVIEW .' Reviews)</span>' .
							'</div>' .
							'<div class="rbt-bookmark-btn">' .
								'<a class="rbt-round-btn" title="Bookmark" href="#"><i class="feather-bookmark"></i></a>' .
							'</div>' .
						'</div>' .

						'<h4 class="rbt-card-title"><a href="'. get_permalink($course_post) .'">'. get_the_title($course_post) .'</a></h4>' .

						'<ul class="rbt-meta">' .
							$lessonText .
							$studentText .
						'</ul>' .

						'<p class="rbt-card-text">'. get_the_excerpt($course_post) .'</p>' .
							$teachetText .
						'<div class="rbt-card-bottom">' .
							'<div class="rbt-price">' .
								'<span class="current-price">'. $CURRENCY . $PRICE .'</span>' .
								$oldPriceText .
							'</div>' .
							'<a class="rbt-btn-link" href="'. get_permalink($course_post) .'">Learn More<i class="feather-arrow-right"></i></a>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>' .
			'<!-- End Single Card  -->|';
		$result .= $element;
	}

	echo substr($result, 0, -2);
}


add_action( 'wp_ajax_view_courses_list', 'view_courses_list_callback' );
add_action( 'wp_ajax_nopriv_view_courses_list', 'view_courses_list_callback' );
function view_courses_list_callback() {
	$array_ =  $_POST['array_'] ? $_POST['array_'] : array();
	$result = 
	'<div class="rbt-course-feature-inner">' .
        '<div class="section-title">' .
            '<h4 class="rbt-title-style-3">Course Content</h4>' .
        '</div>' .
        '<div class="rbt-accordion-style rbt-accordion-02 accordion">' .
            '<div class="accordion" id="accordionExampleb2">';
	foreach($array_ as $nameCourse=>$point){
		$count=0;
		foreach($point as $namePoint=>$arrPoint){
			$count = $count + $arrPoint[0];
		}
		$hour = round(($count / 60) - 0.5);
		$hourStr = '';
		if($hour){
			$hourStr = $hour . 'hr';
		}
		
		$minut = $count - ($hour*60);
		$minutStr = '';
		if($minut){
			$minutStr = $minut . 'min';
		}
		$array_[$nameCourse]['time'] = $hourStr . ' ' . $minutStr;
	}

	
	$count = 1;
	foreach($array_ as $nameCourse=>$point){
		$result .=
		'<div class="accordion-item card">' .
		'<h2 class="accordion-header card-header" id="headingTwo'. $count .'">' .
			'<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo'. $count .'" aria-expanded="false" aria-controls="collapseTwo'. $count .'">' .
				$nameCourse . '<span class="rbt-badge-5 ml--10">'. $array_[$nameCourse]['time'] .'</span>' .
			'</button>' .
		'</h2>';
		$result .=
				'<div id="collapseTwo'. $count .'" class="accordion-collapse collapse" aria-labelledby="headingTwo'. $count .'" data-bs-parent="#accordionExampleb'. $count+2 .'">' .
					'<div class="accordion-body card-body pr--0">' .
						'<ul class="rbt-course-main-content liststyle">';
		foreach($point as $namePoint=>$arrPoint){
			if($namePoint=='time'){continue;}
			if($arrPoint[1]){
				$result .=
				'<li>' .
					'<a href="'. $arrPoint[2] .'">' .
						'<div class="course-content-left">' .
							'<i class="feather-play-circle"></i> <span' .
								'class="text">'. $namePoint .'</span>' .
						'</div>' .
						'<div class="course-content-right">' .
							'<span class="min-lable">'. $arrPoint[0] .' min</span>' .
							'<span class="rbt-badge variation-03 bg-primary-opacity"><i class="feather-eye"></i> Preview</span>' .
						'</div>' .
					'</a>' .
				'</li>';
			} else {
				$result .=
				'<li>' .
					'<a href="#">' .
						'<div class="course-content-left">' .
							'<i class="feather-play-circle"></i> <span' .
								'class="text">'. $namePoint .'</span>' .
						'</div>' .
						'<div class="course-content-right">' .
							'<span class="course-lock"><i class="feather-lock"></i></span>' .
						'</div>' .
					'</a>' .
				'</li>';
			}
		}
		$count++;
		$result .= '</ul></div></div></div>';
	}
	echo substr($result, 0, -1);
}


add_action( 'wp_ajax_view_requirements_list', 'view_requirements_list_callback' );
add_action( 'wp_ajax_nopriv_view_requirements_list', 'view_requirements_list_callback' );
function view_requirements_list_callback() {
	$array_ =  $_POST['array_'] ? $_POST['array_'] : array();
	$result = 
	'<!-- Start Feture Box  -->' .
	'<div class="col-lg-6">' .
		'<div class="section-title">' .
			'<h4 class="rbt-title-style-3 mb--20">Requirements</h4>' .
		'</div>' .
		'<ul class="rbt-list-style-1">';

	foreach($array_[0] as $el){
		$result .= '<li><i class="feather-check"></i>'. $el .'</li>';
	}

	$result .= 
		'</ul>' .
	'</div>' .
	'<!-- End Feture Box  -->' .
	'<!-- Start Feture Box  -->' .
	'<div class="col-lg-6">' .
		'<div class="section-title">' .
			'<h4 class="rbt-title-style-3 mb--20">Description</h4>' .
		'</div>' .
		'<ul class="rbt-list-style-1">';

	foreach($array_[1] as $el){
		$result .=  '<li><i class="feather-check"></i>'. $el .'</li>';
	}

	$result .=
		'</ul>' .
	'</div>' .
	'<!-- End Feture Box  -->';

	echo substr($result, 0, -1);
}


add_action( 'wp_ajax_view_featured_review_list', 'view_featured_review_list_callback' );
add_action( 'wp_ajax_nopriv_view_featured_review_list', 'view_featured_review_list_callback' );
function view_featured_review_list_callback() {
	$idPost =  $_POST['idPost'] ? $_POST['idPost'] : '';

	$arg_cat = array(
        'orderby'      => 'name',
        'order'        => 'ASC',
        'hide_empty'   => 0,
        'include'      => array(15),
    );
	$categories = get_categories( $arg_cat )[0];
	$my_posts = get_posts(array(
		'category'     => $categories->term_id,
	));

	$arrayPostsRate = [];
	$result = '';
	foreach( $my_posts as $post ){
		$rate = get_field('rate', $post->ID);
		$course = get_field('rewiews_course_rel', $post->ID);
			
		$star = '';
		for($i = 0; $i < $rate; $i++){
			$star .= '<a href="#"><i class="fas fa-star"></i></a>';
		}
	
		for($i = 0; $i < 5-$rate; $i++){
			$star .= '<a href="#"><i class="off fas fa-star"></i></a>';
		}
		$featured_img_url = get_the_post_thumbnail_url($post->ID,'full');

		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($id) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/testimonial/testimonial-3.jpg" alt="'. get_the_title($id) .'">';
		}
		if($course==""||$course!=$idPost){continue;}
		$result .=
			'<div class="rbt-course-review about-author">' .
				'<div class="media">' .
					'<div class="thumbnail">' .
						'<a href="#">' .
							$imgText .
						'</a>' .
					'</div>' .
					'<div class="media-body">' .
						'<div class="author-info">' .
							'<h5 class="title">' .
								'<a class="hover-flip-item-wrapper" href="#">' .
									get_the_title($post) .
								'</a>' .
							'</h5>'.
							'<div class="rating">'.
								$star .
							'</div>' .
						'</div>' .
						'<div class="content">' .
							'<p class="description">'. get_the_content( null, false, $post ) .'</p>' .
							'<ul class="social-icon social-default transparent-with-border justify-content-start">' .
								'<li><a href="#">' .
										'<i class="feather-thumbs-up"></i>' .
									'</a>' .
								'</li>' .
								'<li><a href="#">' .
										'<i class="feather-thumbs-down"></i>' .
									'</a>' .
								'</li>' .
							'</ul>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>';
	}
	echo substr($result, 0, -1);
}


add_action( 'wp_ajax_view_course_teacher_list', 'view_course_teacher_list_callback' );
add_action( 'wp_ajax_nopriv_view_course_teacher_list', 'view_course_teacher_list_callback' );
function view_course_teacher_list_callback() {
	$TEACHER = $_POST['teacher'] ? $_POST['teacher'] : '';
	$idPost = $_POST['id_'] ? $_POST['id_'] : '';

	if(!$TEACHER){
		return 0;
	}

	$arrayPostsRate = get_rate();
	
	$categories = get_categories( array(
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => 0,
	));
	
	$result = '';
	foreach($categories as $cat){
		if($cat->parent){
			$posts = get_posts(
				array(
					'category'  => $cat->term_id,
					'exclude'      => $idPost,
				)
			);
			foreach($posts as $post){
				$teacher = get_teacher_course($post->ID);
				$teachOperand = get_the_title($teacher->ID);
				$id = $post->ID;
				$SKILL_TEACHER = get_field('skill', $teacher->ID);
				if($TEACHER==$teachOperand){
					if(!array_key_exists($post->ID, $arrayPostsRate)){
						$RATE = 0;
						$COUNT_REVIEW = 0;
					} else {
						$RATE = round($arrayPostsRate[$post->ID][1]);
						$COUNT_REVIEW = $arrayPostsRate[$post->ID][2];
					}

					$STUDENT = get_field('students', $id);
					$LESSON = get_field('lesson', $id);
					$NAME_TEACHER = $teachOperand;
					$SKILL_TEACHER = get_field('skill', $teacher->ID);
					$SALE = get_field('sale', $id);
					$PRICE = get_field('price', $id);
					$OLD_PRICE = get_field('old_price', $id);
					$CURRENCY = get_field('currency', $id);
					$featured_img_url = get_the_post_thumbnail_url($id,'full');
			
					if($featured_img_url){
						$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($id) .'">';
					} else {
						$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/classic-lms-01.jpg" alt="'. get_the_title($id) .'">';
					}
				
					$star = '';
					for($i = 0; $i < $RATE; $i++){
						$star .= '<i class="fas fa-star"></i>';
					}
				
					for($i = 0; $i < 5-$RATE; $i++){
						$star .= '<i class="off fas fa-star"></i>';
					}
				
					$saleText = '';
					if($SALE){
						$saleText =
						'<div class="rbt-badge-3 bg-white">' .
							'<span>-'. $SALE .'%</span>' .
							'<span>Off</span>' .
						'</div>';
					}
				
					$teachetText = '';
					if($NAME_TEACHER){
						$teachetText =
							'<div class="rbt-author-meta mb--10">' .
								'<div class="rbt-avater">' .
									'<a href="#">' .
										'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
									'</a>' .
								'</div>' .
								'<div class="rbt-author-info">' .
									'By <a href="profile.html">'. $NAME_TEACHER .'</a> In <a href="#">'. $SKILL_TEACHER .'</a>' .
								'</div>' .
							'</div>';
					}
				
					$oldPriceText = '';
					if($OLD_PRICE){
						$oldPriceText = '<span class="off-price">$'. $CURRENCY . $OLD_PRICE .'</span>';
					}
				
					$lessonText = '';
					if($LESSON){
						$lessonText = '<li><i class="feather-book"></i>'. $LESSON .' Lessons</li>';							
					}
				
					$studentText = '';
					if($STUDENT){
						$studentText = '<li><i class="feather-users"></i>'. $STUDENT .' Students</li>';
					}

					$result .=
					'<!-- Start Single Card  -->' .
					'<div class="col-lg-6 col-md-6 col-sm-6 col-12" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">' .
						'<div class="rbt-card variation-01 rbt-hover">' .
							'<div class="rbt-card-img">' .
								'<a href="course-details.html">' .
									'<img src="http://kursy.existparts.ru/assets/images/course/course-online-01.jpg" alt="Card image">' .
									$saleText .
								'</a>' .
							'</div>' .
							'<div class="rbt-card-body">' .
								'<div class="rbt-card-top">' .
									'<div class="rbt-review">' .
										'<div class="rating">' .
											$star .
										'</div>' .
										'<span class="rating-count"> ('. $COUNT_REVIEW .' Reviews)</span>' .
									'</div>' .
									'<div class="rbt-bookmark-btn">' .
										'<a class="rbt-round-btn" title="Bookmark" href="#"><i' .
												'class="feather-bookmark"></i></a>' .
									'</div>' .
								'</div>' .

								'<h4 class="rbt-card-title"><a href="'. get_permalink($post) .'">'. get_the_title($post) .'</a>' .
								'</h4>' .

								'<ul class="rbt-meta">' .
									$lessonText .
									$studentText .
								'</ul>' .

								'<p class="rbt-card-text">'. get_the_excerpt($post) .'</p>' .
								$teachetText .
								'<div class="rbt-card-bottom">' .
									'<div class="rbt-price">' .
										'<span class="current-price">'. $CURRENCY . $PRICE .'</span>' .
										$oldPriceText .
									'</div>' .
									'<a class="rbt-btn-link" href="'. get_permalink($post) .'">Learn' .
										'More<i class="feather-arrow-right"></i></a>' .
								'</div>' .
							'</div>' .
						'</div>' .
					'</div>' .
					'<!-- End Single Card  -->';
				}
			}
		}
	}
	echo substr($result, 0, -1);
	
}


add_action( 'wp_ajax_view_related_courses_list', 'view_related_courses_list_callback' );
add_action( 'wp_ajax_nopriv_view_related_courses_list', 'view_related_courses_list_callback' );
function view_related_courses_list_callback() {
	$idPost = $_POST['id_'] ? $_POST['id_'] : '';
	$RELATED_COURSES = get_field('related_courses', $idPost);
	if(!$RELATED_COURSES){
		return '';
	}

	$arrayPostsRate = get_rate();
	$result = '';
	$count = 0;
	foreach($RELATED_COURSES as $course){
		$ID = $course->ID;
		$RATE = 0;
		$COUNT_REVIEW = 0;
		foreach($arrayPostsRate as $post){
			if(in_array($ID,$arrayPostsRate)){
				$RATE = round($post[1]);
				$COUNT_REVIEW = $post[2];
			}
		}
		
		$STUDENT = get_field('students', $ID);
		$LESSON = get_field('lesson', $ID);

		$teacher = get_teacher_course($post->ID);
		$NAME_TEACHER = get_the_title($teacher->ID);
		$SKILL_TEACHER = get_field('skill', $teacher->ID);

		$SALE = get_field('sale', $ID);
		$PRICE = get_field('price', $ID);
		$OLD_PRICE = get_field('old_price', $ID);
		$CURRENCY = get_field('currency', $ID);
		$featured_img_url = get_the_post_thumbnail_url($ID,'full');

		
		if($featured_img_url){
			$imgText = '<img src="'. $featured_img_url .'" alt="'. get_the_title($ID) .'">';
		} else {
			$imgText = '<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/classic-lms-01.jpg" alt="'. get_the_title($ID) .'">';
		}

		$star = '';
		for($i = 0; $i < $RATE; $i++){
			$star .= '<i class="fas fa-star"></i>';
		}

		for($i = 0; $i < 5-$RATE; $i++){
			$star .= '<i class="off fas fa-star"></i>';
		}

		$saleText = '';
		if($SALE){
			$saleText =
			'<div class="rbt-badge-3 bg-white">' .
				'<span>-'. $SALE .'%</span>' .
				'<span>Off</span>' .
			'</div>';
		}

		$teachetText = '';
		if($NAME_TEACHER){
			$teachetText =
			'<div class="rbt-author-meta mb--10">' .
				'<div class="rbt-avater">' .
					'<a href="#">' .
						'<img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
					'</a>' .
				'</div>' .
				'<div class="rbt-author-info">' .
					'By <a href="profile.html">'. $NAME_TEACHER .'</a> In <a href="#">'. $SKILL_TEACHER .'</a>' .
				'</div>' .
			'</div>';
		}

		$oldPriceText = '';
		if($OLD_PRICE){
			$oldPriceText = '<span class="off-price">$'. $CURRENCY . $OLD_PRICE .'</span>';
		}

		$lessonText = '';
		if($LESSON){
			$lessonText = '<li><i class="feather-book"></i>'. $LESSON .' Lessons</li>';
							
		}

		$studentText = '';
		if($STUDENT){
			$studentText = '<li><i class="feather-users"></i>'. $STUDENT .' Students</li>';
		}

		if($count==3){
			break;
		}

		$element = 	
			'<!-- Start Single Course  -->' .
			'<div class="col-lg-4 col-md-6 col-sm-12 col-12 sal-animate" data-sal-delay="150" data-sal="slide-up" data-sal-duration="800">' .
				'<div class="rbt-card variation-01 rbt-hover">' .
					'<div class="rbt-card-img">' .
						'<a href="'. get_permalink($ID) .'">' .
							$imgText .
							$saleText .
						'</a>' .
					'</div>' .
					'<div class="rbt-card-body">' .
						'<div class="rbt-card-top">' .
							'<div class="rbt-review">' .
								'<div class="rating">' .
									$star .
								'</div>' .
								'<span class="rating-count"> ('. $COUNT_REVIEW .' Reviews)</span>' .
							'</div>' .
							'<div class="rbt-bookmark-btn">' .
								'<a class="rbt-round-btn" title="Bookmark" href="#"><i class="feather-bookmark"></i></a>' .
							'</div>' .
						'</div>' .
						'<h4 class="rbt-card-title"><a href="'. get_permalink($ID) .'">'. get_the_title($ID) .'</a>' .
						'</h4>' .
						'<ul class="rbt-meta">' .
							$lessonText .
							$studentText .
						'</ul>' .
						'<p class="rbt-card-text">'. get_the_excerpt($ID) .'</p>' .
						$teachetText .
						'<div class="rbt-card-bottom">' .
							'<div class="rbt-price">' .
								'<span class="current-price">'. $CURRENCY . $PRICE .'</span>' .
								$oldPriceText .
							'</div>' .
							'<a class="rbt-btn-link" href="'. get_permalink($ID) .'">Learn More<i class="feather-arrow-right"></i></a>' .
						'</div>' .
					'</div>' .
				'</div>' .
			'</div>' .
			'<!-- End Single Course  -->';
		$result .= $element;
		$count++;
	}
	echo substr($result, 0, -1);
}


add_action( 'wp_head','hook_javascript' );
function hook_javascript() {
	//wp_enqueue_script( 'histudyScript-js' );
}


add_theme_support('post-thumbnails');
set_post_thumbnail_size(360, 500, true);
?>