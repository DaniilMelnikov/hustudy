<?php
/*
Template Name: Шаблон Категории курсов
*/
?>

<? get_header(); ?>

    <div class="rbt-page-banner-wrapper">
        <!-- Start Banner BG Image  -->
        <div class="rbt-banner-image"></div>
        <!-- End Banner BG Image  -->
        <div class="rbt-banner-content">
            <!-- Start Banner Content Top  -->
            <div class="rbt-banner-content-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start Breadcrumb Area  -->
                            <ul class="page-list">
                                <li class="rbt-breadcrumb-item"><a href="index.html">Home</a></li>
                                <li>
                                    <div class="icon-right"><i class="feather-chevron-right"></i></div>
                                </li>
                                <li class="rbt-breadcrumb-item active">All Courses</li>
                            </ul>
                            <!-- End Breadcrumb Area  -->

                            <div class=" title-wrapper">
                                <h1 class="title mb--0">All Courses</h1>
                                <a href="#" class="rbt-badge-2">
                                    <div class="image">🎉</div> 50 Courses
                                </a>
                            </div>

                            <p class="description">Courses that help beginner designers become true unicorns. </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Banner Content Top  -->
            <!-- Start Course Top  -->
            <div class="rbt-course-top-wrapper mt--40">
                <div class="container">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-5 col-md-12">
                            <div class="rbt-sorting-list d-flex flex-wrap align-items-center">
                                <div class="rbt-short-item switch-layout-container">
                                    <ul class="course-switch-layout">
                                        <li class="course-switch-item"><button class="rbt-grid-view active" title="Grid Layout"><i class="feather-grid"></i> <span class="text">Grid</span></button></li>
                                        <li class="course-switch-item"><button class="rbt-list-view" title="List Layout"><i class="feather-list"></i> <span class="text">List</span></button></li>
                                    </ul>
                                </div>
                                <div class="rbt-short-item">
                                    <span class="course-index">Showing 1-9 of <span id="count-all-courses">0</span> results</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-12">
                            <div class="rbt-sorting-list d-flex flex-wrap align-items-center justify-content-start justify-content-lg-end">
                                <div class="rbt-short-item">
                                    <div class="filter-select">
                                        <span class="select-label d-block">Short By</span>
                                        <div class="filter-select rbt-modern-select search-by-category">
                                            <div class="dropdown bootstrap-select">
                                                <select data-size="7" class="" tabindex="null">
                                                    <option>Default</option>
                                                    <option>Latest</option>
                                                    <option>Popularity</option>
                                                    <option>Trending</option>
                                                    <option>Price: low to high</option>
                                                    <option>Price: high to low</option>
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Course Top  -->
        </div>
    </div>

    <div class="rbt-section-overlayping-top rbt-section-gapBottom">
        <div class="container">
            <div class="row row--30 gy-5">
                <div class="col-lg-3 order-2 order-lg-1">
                    <aside class="rbt-sidebar-widget-wrapper">

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-search">
                            <div class="inner">
                                <form action="#" class="rbt-search-style-1">
                                    <input type="text" placeholder="Search Courses">
                                    <button class="search-btn"><i class="feather-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <!-- End Widget Area  -->

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-categories has-show-more">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Categories</h4>
                                <ul class="rbt-sidebar-list-wrapper categories-list-check has-show-more-inner-content">
                                <script>
                                    let arrayCatFilter = [];
                                    let rate_ = '';
                                    let teacher_ = [];
                                    let price_ = [];
                                    let levels_ = [];
                                    function addFilter(arr, element){
                                        id = arr.indexOf(element);
                                        if(id==-1){
                                            arr.push(element);
                                        } else {
                                            arr.splice(id, 1);
                                        }
                                        return arr;
                                    }
                                    
                                </script>
                                    <?
                                        $categories = get_categories( array(
                                            'orderby'      => 'name',
                                            'order'        => 'ASC',
                                            'hide_empty'   => 0,
                                            'exclude'      => array(15, 16, 18),
                                            'include'      => '',
                                        ));
                                        $count = 1;
                                        foreach( $categories as $cat ){
                                            if($cat->parent != 0):?>
                                                <li class="rbt-check-group">
                                                    <input id="cat-list-<?=$count?>" type="checkbox" name="cat-list-<?=$count?>">
                                                    <label for="cat-list-<?=$count?>" onclick="arrayCatFilter=addFilter(arrayCatFilter, <?=$cat->term_id?>);ViewCourses();"><?=$cat->name?><span class="rbt-lable count"><?=$cat->count?></span></label>
                                                </li>
                                                <?$count++;?>
                                            <?endif;?>
                                        <?}?>
                                </ul>
                            </div>
                            <div class="rbt-show-more-btn">Show More</div>
                        </div>
                        <!-- End Widget Area  -->

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-rating">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Ratings</h4>
                                <ul class="rbt-sidebar-list-wrapper rating-list-check">
                                    <li class="rbt-check-group">
                                        <input id="cat-radio-1" type="radio" name="rbt-radio">
                                        <label for="cat-radio-1" onclick="rate_=5;ViewCourses();">
                                            <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                                            <span class="rbt-lable count">5</span>
                                        </label>
                                    </li>
                                    <li class="rbt-check-group">
                                        <input id="cat-radio-2" type="radio" name="rbt-radio">
                                        <label for="cat-radio-2" onclick="rate_=4;ViewCourses();">
                                            <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                        </span>
                                            <span class="rbt-lable count">4</span>
                                        </label>
                                    </li>
                                    <li class="rbt-check-group">
                                        <input id="cat-radio-3" type="radio" name="rbt-radio">
                                        <label for="cat-radio-3" onclick="rate_=3;ViewCourses();">
                                            <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                        </span>
                                            <span class="rbt-lable count">3</span>
                                        </label>
                                    </li>
                                    <li class="rbt-check-group">
                                        <input id="cat-radio-4" type="radio" name="rbt-radio">
                                        <label for="cat-radio-4" onclick="rate_=2;ViewCourses();">
                                            <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                        </span>
                                            <span class="rbt-lable count">2</span>
                                        </label>
                                    </li>

                                    <li class="rbt-check-group">
                                        <input id="cat-radio-5" type="radio" name="rbt-radio">
                                        <label for="cat-radio-5" onclick="rate_=1;ViewCourses();">
                                            <span class="rating">
                            <i class="fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                            <i class="off fas fa-star"></i>
                        </span>
                                            <span class="rbt-lable count">1</span>
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Widget Area  -->

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-instructor">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Instructors</h4>
                                <ul class="rbt-sidebar-list-wrapper instructor-list-check">
                                    <?
                                        $categories = get_categories( array(
                                            'orderby'      => 'name',
                                            'order'        => 'ASC',
                                            'hide_empty'   => 0,
                                            'exclude'      => array(15, 16, 18),
                                            'include'      => '',
                                        ));
                                        $arrayTeacher = [];
                                        foreach($categories as $cat){
                                            $my_posts = get_posts( array(
                                                'category' => $cat->ID,
                                            ) );
                                            $cerrentArr = [];
                                            foreach($my_posts as $post){
                                                $teacherName = get_field('name_teacher', $post->ID);
                                                if($teacherName==''){continue;}
                                                if (array_key_exists($teacherName, $arrayTeacher)){
                                                    $arrayTeacher[$teacherName] = $arrayTeacher[$teacherName] + 1;
                                                } else {
                                                    
                                                    $arrayTeacher[$teacherName] = 1;
                                                }
                                            }
                                        }
                                        $count = 1;
                                        foreach($arrayTeacher as $key=>$value){?>
                                            <li class="rbt-check-group">
                                                <input id="ins-list-<?=$count?>" type="checkbox" name="ins-list-<?=$count?>">
                                                <label for="ins-list-<?=$count?>" onclick="teacher_=addFilter(teacher_, '<?=$key?>');ViewCourses();"><?=$key?> <span class="rbt-lable count"><?=$value?></span></label>
                                            </li>
                                            <?$count++;?>
                                        <?}?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Widget Area  -->

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-prices">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Prices</h4>
                                <ul class="rbt-sidebar-list-wrapper prices-list-check">
                                    <?
                                        $arrFilter = array(
                                            'Free' => 0,
                                            'Paid' => 0,
                                        );
                                        $categories = get_categories( array(
                                            'orderby'      => 'name',
                                            'order'        => 'ASC',
                                            'hide_empty'   => 0,
                                            'exclude'      => array(15, 16, 18),
                                            'include'      => '',
                                        ));
                                        foreach($categories as $cat){
                                            $my_posts = get_posts( array(
                                                'category' => $cat->ID,
                                            ) );
                                            foreach($my_posts as $post){
                                                $priceFilter = get_field('filter_price', $post->ID);
                                                if($priceFilter==''){continue;}
                                                if (array_key_exists($priceFilter, $arrFilter)){
                                                    $arrFilter[$priceFilter] = $arrFilter[$priceFilter] + 1;
                                                }
                                            }
                                        }
                                        $count = 1;
                                    ?>
                                    <li class="rbt-check-group">
                                        <input id="prices-list-<?=$count;?>" type="checkbox" name="prices-list-<?=$count;?>">
                                        <label for="prices-list-<?=$count;?>" onclick="price_=addFilter(price_, 'All');ViewCourses();">All <span id="all-filter-price" class="rbt-lable count">0</span></label>
                                    </li>
                                    <?$count++;?>
                                    <?foreach ($arrFilter as $key => $value):?>
                                        <li class="rbt-check-group">
                                            <input id="prices-list-<?=$count;?>" type="checkbox" name="prices-list-<?=$count;?>">
                                            <label for="prices-list-<?=$count;?>" onclick="price_=addFilter(price_, '<?=$key?>');ViewCourses();"><?=$key?> <span class="rbt-lable count"><?=$value;?></span></label>
                                        </li>
                                        <?$count++;?>
                                    <?endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Widget Area  -->

                        <!-- Start Widget Area  -->
                        <div class="rbt-single-widget rbt-widget-lavels">
                            <div class="inner">
                                <h4 class="rbt-widget-title">Levels</h4>
                                <ul class="rbt-sidebar-list-wrapper lavels-list-check">
                                <?
                                        $arrFilter = array(
                                            'Beginner' => 0,
                                            'Intermediate' => 0,
                                            'Expert' => 0,
                                        );
                                        $tags = get_tags(array(
                                            'hide_empty' => false,
                                            'exclude'    => array(13, 17),
                                        ));
                                        foreach($tags as $tag){
                                            $my_posts = get_posts( array(
                                                'tag' => $tag->slug,
                                            ) );
                                            foreach($my_posts as $post){
                                                $levelFilter = get_field('level_filter', $post->ID);
                                                if($levelFilter==''){continue;}
                                                if (array_key_exists($levelFilter, $arrFilter)){
                                                    $arrFilter[$levelFilter] = $arrFilter[$levelFilter] + 1;
                                                }
                                            }
                                        }
                                        $count = 1;
                                    ?>
                                    <li class="rbt-check-group">
                                        <input id="lavels-list-<?=$count;?>" type="checkbox" name="lavels-list-<?=$count;?>">
                                        <label for="lavels-list-<?=$count;?>" onclick="levels_=addFilter(levels_, 'All Levels');ViewCourses();">All Levels<span id="all-filter-levels" class="rbt-lable count">0</span></label>
                                    </li>
                                    <?$count++;?>
                                    <?foreach ($arrFilter as $key => $value):?>
                                        <li class="rbt-check-group">
                                            <input id="lavels-list-<?=$count;?>" type="checkbox" name="lavels-list-<?=$count;?>">
                                            <label for="lavels-list-<?=$count;?>" onclick="levels_=addFilter(levels_, '<?=$key?>');ViewCourses();"><?=$key?><span class="rbt-lable count"><?=$value;?></span></label>
                                        </li>
                                        <?$count++;?>
                                    <?endforeach;?>
                                </ul>
                            </div>
                        </div>
                        <!-- End Widget Area  -->

                    </aside>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div id="ajax-view-courses" class="rbt-course-grid-column active-grid-view">
                    
                    </div>
                    <script>
                        let pageCount = 0;
                        let pageNow = 1;
                        let pageLast = 0;
                        let lengthArrResponse = 0;
                        let cacheLast = 0;
                        let arrResponse = [];
                        function ViewCourses(tag=''){
                            $.ajax({
                                type: "POST",
                                url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                data: {
                                    action : 'view_courses',
                                    categories_: arrayCatFilter,
                                    rate_: rate_,
                                    teacher_: teacher_,
                                    price_: price_,
                                    levels_: levels_,
                                    tag_: tag
                                },
                                success: function (response) {
                                    arrResponse = response.split('|');
                                    lengthArrResponse = arrResponse.length;
                                    
                                    for(let i=1, count=lengthArrResponse;count>0;i++){
                                        pageLast=i;
                                        count = count - 9;
                                    }
                                    cacheLast = pageLast;
                                    let string = '';
                                    for(let i=0;i<9;i++){
                                        if (arrResponse[i]==undefined){break;}
                                        string += arrResponse[i];
                                    }
                                    if(string!="0"){
                                        $("#count-all-courses").html(lengthArrResponse);
                                        $("#all-filter-levels").html(lengthArrResponse);
                                        $("#all-filter-price").html(lengthArrResponse);
                                        $("#ajax-view-courses").html(string);
                                        $("#paginator-gene").html(paginatorGenerate());
                                    }else{
                                        $("#count-all-courses").html(0);
                                        $("#ajax-view-courses").html('No data available');
                                        $("#paginator-gene").html('');
                                    }
                                }
                            });
                        }
                        ViewCourses();
                    </script>
                    <div class="row">
                        <div class="col-lg-12 mt--60">
                            <nav>
                                <ul id="paginator-gene" class="rbt-pagination">
                                    <script>
                                        function generatePagePaginator(page){
                                            let arr = arrResponse.slice((page-1)*9, page*9);
                                            let string = '';
                                            for(let i=0;i<9;i++){
                                                if (arr[i]==undefined){break;}
                                                string += arr[i];
                                            }
                                            $("#ajax-view-courses").html(string);
                                            let pagiantion = document.querySelectorAll("#paginator-gene li");
                                            let pagiantionLen = pagiantion.length;
                                            for(let i=0;i<pagiantionLen;i++){
                                                pagiantion[i].className = ''
                                            }
                                            document.querySelector('#page-'+page).className = 'active';
                                        }

                                        function movePaginator(move){
                                            pageNow += move;
                                            if(cacheLast>pageLast){
                                                pageLast += move;
                                            }
                                            
                                            return pageNow, pageLast
                                        }

                                        function paginatorGenerate(){
                                            let textResult = '';
                                            if (pageNow!=1){
                                                textResult += '<li><a href="##" onclick="generatePagePaginator('+pageNow+');movePaginator(-1);paginatorGenerate();" aria-label="Previous"><i class="feather-chevron-left"></i></a></li>';
                                            }
                                            textResult += '<li id="page-'+ pageNow +'" class="active"><a href="##" onclick="generatePagePaginator('+ pageNow +');">' + pageNow + '</a></li>';
                                            for(let i=pageNow+1;i<pageNow+3;i++){
                                                if(pageLast<pageNow+1){
                                                    break;
                                                }
                                                textResult += '<li id="page-'+ i +'"><a href="##" onclick="generatePagePaginator('+ i +');">' + i + '</a></li>';
                                            }

                                            if (pageLast>3&&pageNow+2<cacheLast){
                                                textResult += '<li><a href="##" onclick="generatePagePaginator('+pageNow+');movePaginator(1);paginatorGenerate();" aria-label="Next"><i class="feather-chevron-right"></i></a></li>';
                                            }
                                            $("#paginator-gene").html(textResult);
                                        }
                                    </script>
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let clickEventCount = true;
            $('.btn.dropdown-toggle.btn-light').on("click", function(){
                if(clickEventCount){
                    $(".dropdown-item").on( "click", function() {
                        setTimeout(() => {  
                            let short = document.querySelector(
                                    '.dropdown-item.active.selected'
                                ).querySelector('.text').innerHTML;
                            $.ajax({
                                    type: "POST",
                                    url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                    data: {
                                        action : 'view_courses',
                                        short_: short,
                                    },
                                    success: function (response) {
                                        arrResponse = response.split('|');
                                        lengthArrResponse = arrResponse.length;
                                        
                                        for(let i=1, count=lengthArrResponse;count>0;i++){
                                            pageLast=i;
                                            count = count - 9;
                                        }
                                        cacheLast = pageLast;
                                        let string = '';
                                        for(let i=0;i<9;i++){
                                            if (arrResponse[i]==undefined){break;}
                                            string += arrResponse[i];
                                        }
                                        if(string!="0"){
                                            $("#count-all-courses").html(lengthArrResponse);
                                            $("#all-filter-levels").html(lengthArrResponse);
                                            $("#all-filter-price").html(lengthArrResponse);
                                            $("#ajax-view-courses").html(string);
                                            $("#paginator-gene").html(paginatorGenerate());
                                        }else{
                                            $("#count-all-courses").html(0);
                                            $("#ajax-view-courses").html('No data available');
                                            $("#paginator-gene").html('');
                                        }
                                    }
                            });
                        }, 1000);
                    });
                }
                clickEventCount = false;
            })
        })
    </script>
<?
the_content();

get_footer();

?>