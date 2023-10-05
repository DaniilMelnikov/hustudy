<?php
/*
Template Name: Шаблон Детальная страница курса
Template Post Type: post
*/
?>

<? get_header(); ?>


    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default rbt-breadcrumb-style-3">
        <div class="breadcrumb-inner">
            <img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/bg/bg-image-10.jpg" alt="Education Images">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <?$id_post = the_ID();?>
                    <?$postData = get_post($id=the_ID());?>
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="http://kursy.existparts.ru/">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                        
                            <li class="rbt-breadcrumb-item active"><?=$postData->post_title;?></li>
                        </ul>
                        <h2 class="title"><?=$postData->post_title;?></h2>
                        <p class="description"><?=$postData->post_excerpt;?></p>

                        <div class="d-flex align-items-center mb--20 flex-wrap rbt-course-details-feature">

                            <div class="feature-sin best-seller-badge">
                                <span class="rbt-badge-2">
                                    <span class="image"><img src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/icons/card-icon-1.png"
                                            alt="Best Seller Icon"></span> Bestseller
                                </span>
                            </div>

                            <div class="feature-sin rating">
                                <?
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
                                        if($course==""){continue;}
                                        if(array_key_exists($course, $arrayPostsRate)){
                                            $arrayPostsRate[$course][2] = $arrayPostsRate[$course][2] + 1;
                                            $arrayPostsRate[$course][1][] = $rate;
                                        } else {
                                            $arrayPostsRate[$course] = array($course, array($rate), 1);
                                        }
                                    }
                                }
                                $courseTrue = false;
                                if(array_key_exists($postData->ID, $arrayPostsRate)){
                                    $courseTrue = $arrayPostsRate[$postData->ID];
                                }
                                
                                if($courseTrue){
                                    $rateArray = $courseTrue[1];
                                    $count = count($rateArray);
                                    $num = 0;
                                    for ($i = 0; $i < $count; $i++) {
                                        $num += $rateArray[$i];
                                    }
                                    $courseTrue[] = round($num / $count, 1);
                                }

                                if(!$courseTrue){
                                    $RATE_STAT = 0;
                                    $RATE = 0;
                                    $COUNT_REVIEW = 0;
                                } else {
                                    $RATE_STAT = $courseTrue[3];
                                    $RATE = round($courseTrue[3]);
                                    $COUNT_REVIEW = $courseTrue[2];
                                }
                                
                                $STUDENT = get_field('students', $postData->ID);
                                $LESSON = get_field('lesson', $postData->ID);
                                $teacher = get_teacher_course($postData->ID);
                                $NAME_TEACHER='';
                                $SKILL_TEACHER='';
                                if($teacher){
                                    $NAME_TEACHER = get_the_title($teacher->ID);
                                    $SKILL_TEACHER = get_field('skill', $teacher->ID);
                                }
                                $SALE = get_field('sale', $postData->ID);
                                $PRICE = get_field('price', $postData->ID);
                                $OLD_PRICE = get_field('old_price', $postData->ID);
                                $CURRENCY = get_field('currency', $postData->ID);
                                $featured_img_url = get_the_post_thumbnail_url($postData->ID,'full');

                                if($featured_img_url){
                                    $imgText = '<img class="w-100" src="'. $featured_img_url .'" alt="'. get_the_title($id) .'">';
                                } else {
                                    $imgText = '<img class="w-100" src="http://kursy.existparts.ru/wp-content/themes/histudy/assets/images/course/course-01.jpg" alt="'. get_the_title($id) .'">';
                                    
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
                                    '<div class="rbt-author-meta mb--20">' .
                                        '<div class="rbt-avater">' .
                                            '<a href="#">' .
                                                '<img src="wp-content/themes/histudy/assets/images/client/avatar-02.png" alt="'. $NAME_TEACHER .'">' .
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

                                $star = '';
                                for($i = 0; $i < $RATE; $i++){
                                    $star .= '<a href="#"><i class="fas fa-star"></i></a>';
                                }
                        
                                for($i = 0; $i < 5-$RATE; $i++){
                                    $star .= '<a href="#"><i class="off fas fa-star"></i></a>';
                                }
                                ?>
                                <a href="#"><?=$RATE_STAT?></a>
                                <?=$star;?>
                            </div>

                            <div class="feature-sin total-rating">
                                <a class="rbt-badge-4" href="#"><?=$COUNT_REVIEW?> rating</a>
                            </div>

                            <div class="feature-sin total-student">
                                <span><?=$STUDENT?> students</span>
                            </div>

                        </div>
                        <? $arrDate = explode('-', explode(' ', $postData->post_date)[0]); ?>
                        <?=$teachetText?>
                        <ul class="rbt-meta">
                            <li><i class="feather-calendar"></i>Last updated <?=$arrDate[1]?>/<?=$arrDate[0]?></li>
                            <li><i class="feather-globe"></i><?=get_field('certificate', $postData->ID);?></li>
                            <?if(get_field('certificate', $postData->ID)):?>
                            <li><i class="feather-award"></i>Certified Course</li>
                            <?endif;?>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->
    <div class="rbt-course-details-area ptb--60">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-8">
                    <div class="course-details-content">
                        <div class="rbt-course-feature-box rbt-shadow-box thuumbnail">
                            <?=$imgText;?>
                        </div>

                        <div class="rbt-inner-onepage-navigation sticky-top mt--30">
                            <nav class="mainmenu-nav onepagenav">
                                <ul class="mainmenu">
                                    <li class="current">
                                        <a href="#overview">Overview</a>
                                    </li>
                                    <li>
                                        <a href="#coursecontent">Course Content</a>
                                    </li>
                                    <li>
                                        <a href="#details">Details</a>
                                    </li>
                                    <li>
                                        <a href="#intructor">Intructor</a>
                                    </li>
                                    <li>
                                        <a href="#review">Review</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Start Course Feature Box  -->
                        <div class="rbt-course-feature-box overview-wrapper rbt-shadow-box mt--30 has-show-more" id="overview">
                            <div class="rbt-course-feature-inner has-show-more-inner-content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">What you'll learn</h4>
                                </div>
                                <?=$postData->post_content;?>
                            </div>
                            <div class="rbt-show-more-btn">Show More</div>
                        </div>
                        <!-- End Course Feature Box  -->

                        <!-- Start Course Content  -->
                        <script>
                            if(arrCourses){
                                function ViewCoursesList(){
                                    $.ajax({
                                        type: "POST",
                                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                        data: {
                                            action : 'view_courses_list',
                                            array_: arrCourses,
                                        },
                                        success: function (response) {
                                            $("#coursecontent").html(response);
                                        }
                                    });
                                }
                                ViewCoursesList();
                            }
                        </script>
                        <div class="course-content rbt-shadow-box coursecontent-wrapper mt--30" id="coursecontent">
                            
                        </div>
                        <!-- End Course Content  -->
                        
                        <!-- Start Course Feature Box  -->
                        <script>
                            if(arrRequirements){
                                function ViewRequirementsList(){
                                    $.ajax({
                                        type: "POST",
                                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                        data: {
                                            action : 'view_requirements_list',
                                            array_: arrRequirements,
                                        },
                                        success: function (response) {
                                            $("#requirments-list").html(response);
                                        }
                                    });
                                }
                                ViewRequirementsList();
                            }
                        </script>
                        <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30" id="details">
                            <div id="requirments-list" class="row g-5">
                                
                            </div>
                        </div>
                        <!-- End Course Feature Box  -->
                        <?if($teacher):?>
                        <!-- Start Intructor Area  -->
                        <div class="rbt-instructor rbt-shadow-box intructor-wrapper mt--30" id="intructor">
                            <div class="about-author border-0 pb--0 pt--0">
                                <div class="section-title mb--30">
                                    <h4 class="rbt-title-style-3">Instructor</h4>
                                </div>
                                <div class="media align-items-center">
                                    <div class="thumbnail">
                                        <a href="#">
                                            <img src="assets/images/testimonial/testimonial-7.jpg" alt="Author Images">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="author-info">
                                            <h5 class="title">
                                                <a class="hover-flip-item-wrapper" href="author.html"><?=$NAME_TEACHER?></a>
                                            </h5>
                                            <span class="b3 subtitle"><?=$SKILL_TEACHER?></span>
                                            <ul class="rbt-meta mb--20 mt--10">
                                                <li><i class="fa fa-star color-warning"></i>75,237 Reviews <span class="rbt-badge-5 ml--5">4.4 Rating</span></li>
                                                <li><i class="feather-users"></i>912,970 Students</li>
                                                <li><a href="#"><i class="feather-video"></i>16 Courses</a></li>
                                            </ul>
                                        </div>
                                        <div class="content">
                                            <p class="description">John is a brilliant educator, whose life was spent
                                                for computer science and love of nature.</p>

                                            <ul class="social-icon social-default icon-naked justify-content-start">
                                                <li><a href="https://www.facebook.com/">
                                                        <i class="feather-facebook"></i>
                                                    </a>
                                                </li>
                                                <li><a href="https://www.twitter.com">
                                                        <i class="feather-twitter"></i>
                                                    </a>
                                                </li>
                                                <li><a href="https://www.instagram.com/">
                                                        <i class="feather-instagram"></i>
                                                    </a>
                                                </li>
                                                <li><a href="https://www.linkdin.com/">
                                                        <i class="feather-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Intructor Area  -->
                        <?endif;?>

                        <!-- Start Edu Review List  -->
                        <div class="rbt-review-wrapper rbt-shadow-box review-wrapper mt--30" id="review">
                            <div class="course-content">
                                <div class="section-title">
                                    <h4 class="rbt-title-style-3">Review</h4>
                                </div>
                                <?
                                $rateArrCurrent = Array(0, 0, 0, 0, 0);
                                if(!$courseTrue){
                                    $courseTrue = Array(0, Array(0));
                                }
                                foreach($courseTrue[1] as $rateNum){
                                    if($rateNum==5){
                                        $rateArrCurrent[0]=$rateArrCurrent[0]+1; 
                                    } else if($rateNum==4){
                                        $rateArrCurrent[1]=$rateArrCurrent[1]+1; 
                                    } else if($rateNum==3){
                                        $rateArrCurrent[2]=$rateArrCurrent[2]+1; 
                                    } else if($rateNum==2){
                                        $rateArrCurrent[3]=$rateArrCurrent[3]+1; 
                                    } else if($rateNum==1){
                                        $rateArrCurrent[4]=$rateArrCurrent[4]+1; 
                                    }
                                }
                                if(!$COUNT_REVIEW){
                                    $COUNT_REVIEW = 1;
                                }
                                
                                ?>
                                
                                <div class="row g-5 align-items-center">
                                    <div class="col-lg-3">
                                        <div class="rating-box">
                                            <div class="rating-number"><?=$RATE?></div>
                                            <div class="rating">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                </svg>
                                            </div>
                                            <span class="sub-title">Course Rating</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="review-wrapper">
                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <?
                                                        $operand = $rateArrCurrent[0] / $COUNT_REVIEW;
                                                    ?>
                                                    <?$percent = $operand * 100;?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$percent?>%" aria-valuenow="63" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text"><?=$percent?>%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <?
                                                        $operand = $rateArrCurrent[1] / $COUNT_REVIEW;
                                                    ?>
                                                    <?$percent = $operand * 100;?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$percent?>%" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text"><?=$percent?>%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <?
                                                        $operand = $rateArrCurrent[2] / $COUNT_REVIEW;
                                                    ?>
                                                    <?$percent = $operand * 100;?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$percent?>%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text"><?=$percent?>%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <?
                                                        $operand = $rateArrCurrent[3] / $COUNT_REVIEW;
                                                    ?>
                                                    <?$percent = $operand * 100;?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$percent?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text"><?=$percent?>%</span>
                                            </div>

                                            <div class="single-progress-bar">
                                                <div class="rating-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                                                        <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z" />
                                                    </svg>
                                                </div>
                                                <div class="progress">
                                                    <?

                                                        $operand = $rateArrCurrent[4] / $COUNT_REVIEW;
      
                                                    ?>
                                                    <?$percent = $operand * 100;?>
                                                    <div class="progress-bar" role="progressbar" style="width: <?=$percent?>%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="value-text"><?=$percent?>%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Edu Review List  -->

                        <div id="featured-review" class="about-author-list rbt-shadow-box featured-wrapper mt--30 has-show-more" style="display:none;">
                            <div class="section-title">
                                <h4 class="rbt-title-style-3">Featured review</h4>
                            </div>
                            <script>
                                    function ViewFeaturedReviewList(){
                                        $.ajax({
                                            type: "POST",
                                            url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                            data: {
                                                action : 'view_featured_review_list',
                                                idPost: <?=$postData->ID?>,
                                            },
                                            success: function (response) {
                                                if(response!='0'){
                                                    $("#featured-review-ajax").html(response);
                                                    document.querySelector('#featured-review').style = '';
                                                }
                                                
                                            }
                                        });
                                    }
                                    ViewFeaturedReviewList();
                            </script>
                            <div id="featured-review-ajax" class="has-show-more-inner-content rbt-featured-review-list-wrapper">
                                
                            </div>
                            <div class="rbt-show-more-btn">Show More</div>
                        </div>
                    </div>
                    <?if($NAME_TEACHER):?>
                    <div id="related-course-teacher" class="related-course mt--60" style="display:none;">
                        <div class="row g-5 align-items-end mb--40">
                            <div class="col-lg-8 col-md-8 col-12">
                                <div class="section-title">
                                    <span class="subtitle bg-pink-opacity">Top Course</span>
                                    <h4 class="title">More Course By <strong class="color-primary"><?=$NAME_TEACHER?></strong></h4>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="read-more-btn text-start text-md-end">
                                    <a class="rbt-btn rbt-switch-btn btn-border btn-sm" href="#">
                                        <span data-text="View All Course">View All Course</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <script>
                                function ViewCourseTeacherList(){
                                    $.ajax({
                                        type: "POST",
                                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                        data: {
                                            action : 'view_course_teacher_list',
                                            teacher: '<?=$NAME_TEACHER?>',
                                            id_: <?=$postData->ID?>,
                                        },
                                        success: function (response) {
                                            if(response){
                                                $("#ajax-course-teacher").html(response);
                                                document.querySelector('#related-course-teacher').style = '';
                                            }
                                            
                                        }
                                    });
                                }
                                ViewCourseTeacherList();
                        </script>
                        <div id="ajax-course-teacher" class="row g-5">
                            
                        </div>
                    </div>
                    <?endif;?>
                </div>

                <div class="col-lg-4">
                    <div class="course-sidebar sticky-top rbt-shadow-box course-sidebar-top rbt-gradient-border">
                        <div class="inner">
                            <?$video=get_field('video',$postData->ID);?>
                            <?if($video):?>
                            <!-- Start Viedo Wrapper  -->
                            <a class="video-popup-with-text video-popup-wrapper text-center popup-video sidebar-video-hidden mb--15" href="<?=$video?>">
                                <div class="video-content">
                                    <img class="w-100 rbt-radius" src="assets/images/others/video-01.jpg" alt="Video Images">
                                    <div class="position-to-top">
                                        <span class="rbt-btn rounded-player-2 with-animation">
                                            <span class="play-icon"></span>
                                        </span>
                                    </div>
                                    <span class="play-view-text d-block color-white"><i class="feather-eye"></i> Preview this course</span>
                                </div>
                            </a>
                            <!-- End Viedo Wrapper  -->
                            <?endif;?>
                            <?
                            $PRICE = get_field('price', $postData->ID);
                            $OLD_PRICE = get_field('old_price', $postData->ID);
                            $CURRENCY = get_field('currency', $postData->ID);
                            ?>
                            <div class="content-item-content">
                                <div class="rbt-price-wrapper d-flex flex-wrap align-items-center justify-content-between">
                                    <div class="rbt-price">
                                        <?if($PRICE):?>
                                        <span class="current-price"><?=$CURRENCY?><?=$PRICE?></span>
                                        <?if($OLD_PRICE):?>
                                        <span class="off-price"><?=$CURRENCY?><?=$OLD_PRICE?></span>
                                        <?endif;?>
                                        <?endif;?>
                                    </div>
                                    <?$date = get_field('start_date', $postData->ID);
                                    $dateRes = 0;
                                    if($date){
                                        $now = time(); // or your date as well
                                        $your_date = strtotime(explode(' ', $date)[0]);
                                        $datediff = $your_date - $now;
                                        $dateRes = round($datediff / (60 * 60 * 24));
                                    }
                                    
                                    ?>
                                    <?if($dateRes>0):?>
                                    <div class="discount-time">
                                        <span class="rbt-badge color-danger bg-color-danger-opacity"><i
                                                class="feather-clock"></i> <?=$dateRes?> days left!</span>
                                    </div>
                                    <?endif;?>
                                    <?if($dateRes=0):?>
                                        <div class="discount-time">
                                        <span class="rbt-badge color-danger bg-color-danger-opacity"><i
                                                class="feather-clock"></i> Today!</span>
                                    </div>
                                    <?endif;?>
                                </div>

                                <div class="add-to-card-button mt--15">
                                    <a class="rbt-btn btn-gradient icon-hover w-100 d-block text-center" href="#">
                                        <span class="btn-text">Add to Cart</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>

                                <div class="buy-now-btn mt--15">
                                    <a class="rbt-btn btn-border icon-hover w-100 d-block text-center" href="#">
                                        <span class="btn-text">Buy Now</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </a>
                                </div>

                                <span class="subtitle"><i class="feather-rotate-ccw"></i> 30-Day Money-Back
                                    Guarantee</span>


                                <div class="rbt-widget-details has-show-more">
                                    <ul class="has-show-more-inner-content rbt-course-details-list-wrapper">
                                        <?
                                        function widgetDetails($name, $value, $id){
                                            $valueGet = get_field($value, $id);
                                            if($valueGet){
                                                return '<li><span>'. $name .'</span><span class="rbt-feature-value rbt-badge-5">'. $value .'</span></li>';
                                            }
                                            return 0;
                                        }
                                        ?>
                                        <?
                                        widgetDetails('Start Date', 'start_date', $postData->ID);
                                        widgetDetails('Enrolled', 'enrolled', $postData->ID);
                                        widgetDetails('Lectures', 'lectures', $postData->ID);
                                        widgetDetails('Skill Level', 'skill_levels', $postData->ID);
                                        widgetDetails('Language', 'language', $postData->ID);
                                        widgetDetails('Quizzes', 'quizzes', $postData->ID);
                                        widgetDetails('Certificate', 'certificate', $postData->ID);
                                        widgetDetails('Pass Percentage', 'pass_percentage', $postData->ID);
                                        ?>
                                    </ul>
                                    <div class="rbt-show-more-btn">Show More</div>
                                </div>

                                <div class="social-share-wrapper mt--30 text-center">
                                    <div class="rbt-post-share d-flex align-items-center justify-content-center">
                                        <ul class="social-icon social-default transparent-with-border justify-content-center">
                                            <li><a href="https://www.facebook.com/">
                                                    <i class="feather-facebook"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.twitter.com">
                                                    <i class="feather-twitter"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.instagram.com/">
                                                    <i class="feather-instagram"></i>
                                                </a>
                                            </li>
                                            <li><a href="https://www.linkdin.com/">
                                                    <i class="feather-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr class="mt--20">
                                    <div class="contact-with-us text-center">
                                        <p>For details about the course</p>
                                        <p class="rbt-badge-2 mt--10 justify-content-center w-100"><i class="feather-phone mr--5"></i> Call Us: <a href="#"><strong>+444 555 666 777</strong></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>

    <div class="rbt-related-course-area bg-color-white pt--60 rbt-section-gapBottom" id="related-courses-none" style="display:none;">
        <div class="container">
            <div class="section-title mb--30">
                <span class="subtitle bg-primary-opacity">More Similar Courses</span>
                <h4 class="title">Related Courses</h4>
            </div>
            <script>
                                function ViewRelatedCorsesList(){
                                    $.ajax({
                                        type: "POST",
                                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                                        data: {
                                            action : 'view_related_courses_list',
                                            id_: <?=$postData->ID?>,
                                        },
                                        success: function (response) {
                                            document.querySelector('#related-courses-none').style = 'display:none;'
                                            if(response!=0){
                                                $("#ajax-related-courses").html(response);
                                                document.querySelector('#related-courses-none').style = '';
                                            }
                                            
                                        }
                                    });
                                }
                                ViewRelatedCorsesList();
                        </script>
            <div class="row g-5" id="ajax-related-courses">

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-card variation-01 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/course/course-online-03.jpg" alt="Card image">
                                <div class="rbt-badge-3 bg-white">
                                    <span>-10%</span>
                                    <span>Off</span>
                                </div>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <div class="rbt-card-top">
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (5 Reviews)</span>
                                </div>
                                <div class="rbt-bookmark-btn">
                                    <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                            class="feather-bookmark"></i></a>
                                </div>
                            </div>
                            <h4 class="rbt-card-title"><a href="course-details.html">Angular Zero to Mastery</a>
                            </h4>
                            <ul class="rbt-meta">
                                <li><i class="feather-book"></i>8 Lessons</li>
                                <li><i class="feather-users"></i>30 Students</li>
                            </ul>
                            <p class="rbt-card-text">Angular Js long fact that a reader will be distracted by
                                the readable.</p>

                            <div class="rbt-author-meta mb--20">
                                <div class="rbt-avater">
                                    <a href="#">
                                        <img src="assets/images/client/avatar-03.png" alt="Sophia Jaymes">
                                    </a>
                                </div>
                                <div class="rbt-author-info">
                                    By <a href="profile.html">Slaughter</a> In <a href="#">Languages</a>
                                </div>
                            </div>
                            <div class="rbt-card-bottom">
                                <div class="rbt-price">
                                    <span class="current-price">$80</span>
                                    <span class="off-price">$100</span>
                                </div>
                                <a class="rbt-btn-link" href="course-details.html">Learn
                                    More<i class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-card variation-01 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/course/course-online-04.jpg" alt="Card image">
                                <div class="rbt-badge-3 bg-white">
                                    <span>-40%</span>
                                    <span>Off</span>
                                </div>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <div class="rbt-card-top">
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-bookmark-btn">
                                    <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                            class="feather-bookmark"></i></a>
                                </div>
                            </div>

                            <h4 class="rbt-card-title"><a href="course-details.html">Web Front To Back</a>
                            </h4>
                            <ul class="rbt-meta">
                                <li><i class="feather-book"></i>20 Lessons</li>
                                <li><i class="feather-users"></i>40 Students</li>
                            </ul>
                            <p class="rbt-card-text">Web Js long fact that a reader will be distracted by
                                the readable.</p>
                            <div class="rbt-author-meta mb--20">
                                <div class="rbt-avater">
                                    <a href="#">
                                        <img src="assets/images/client/avater-01.png" alt="Sophia Jaymes">
                                    </a>
                                </div>
                                <div class="rbt-author-info">
                                    By <a href="profile.html">Patrick</a> In <a href="#">Languages</a>
                                </div>
                            </div>

                            <div class="rbt-card-bottom">
                                <div class="rbt-price">
                                    <span class="current-price">$60</span>
                                    <span class="off-price">$120</span>
                                </div>
                                <a class="rbt-btn-link" href="course-details.html">Learn
                                    More<i class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="rbt-card variation-01 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="assets/images/course/course-online-05.jpg" alt="Card image">
                                <div class="rbt-badge-3 bg-white">
                                    <span>-20%</span>
                                    <span>Off</span>
                                </div>
                            </a>
                        </div>
                        <div class="rbt-card-body">
                            <div class="rbt-card-top">
                                <div class="rbt-review">
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <span class="rating-count"> (15 Reviews)</span>
                                </div>
                                <div class="rbt-bookmark-btn">
                                    <a class="rbt-round-btn" title="Bookmark" href="#"><i
                                            class="feather-bookmark"></i></a>
                                </div>
                            </div>
                            <h4 class="rbt-card-title"><a href="course-details.html">SQL Beginner Advanced</a>
                            </h4>
                            <ul class="rbt-meta">
                                <li><i class="feather-book"></i>12 Lessons</li>
                                <li><i class="feather-users"></i>50 Students</li>
                            </ul>
                            <p class="rbt-card-text">It is a long established fact that a reader will be
                                distracted
                                by the readable.</p>
                            <div class="rbt-author-meta mb--20">
                                <div class="rbt-avater">
                                    <a href="#">
                                        <img src="assets/images/client/avatar-02.png" alt="Sophia Jaymes">
                                    </a>
                                </div>
                                <div class="rbt-author-info">
                                    By <a href="profile.html">Angela</a> In <a href="#">Development</a>
                                </div>
                            </div>
                            <div class="rbt-card-bottom">
                                <div class="rbt-price">
                                    <span class="current-price">$60</span>
                                    <span class="off-price">$120</span>
                                </div>
                                <a class="rbt-btn-link left-icon" href="course-details.html"><i
                                        class="feather-shopping-cart"></i> Add To Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

            </div>
        </div>
    </div>

    <!-- Start Course Action Bottom  -->
    <div class="rbt-course-action-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="section-title text-center text-md-start">
                        <h5 class="title mb--0">The Complete Histudy 2023: From Zero to Expert!</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt_sm--15">
                    <div class="course-action-bottom-right rbt-single-group">
                        <div class="rbt-single-list rbt-price large-size justify-content-center">
                            <span class="current-price color-primary">$750.00</span>
                            <span class="off-price">$1500.00</span>
                        </div>
                        <div class="rbt-single-list action-btn">
                            <a class="rbt-btn btn-gradient hover-icon-reverse btn-md" href="#">
                                <span class="icon-reverse-wrapper">
                                <span class="btn-text">Purchase Now</span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Course Action Bottom  -->
    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>


<?
get_footer();
?>