<div class="rbt-rbt-blog-area rbt-section-gapTop bg-color-white">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top News</span>
                        <h2 class="title">Have a look on <span class="color-primary">our News</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="blog.html">
                            <span data-text="View All News">View All News</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div id="top-news-ajax" class="row g-5">
            <script>
                function topNewsAjax(){
                    $.ajax({
                        type: "POST",
                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                        data: {
                            action : 'top_news',
                        },
                        success: function (response) {
                            $("#top-news-ajax").html(response);
                        }
                    });
                }
                topNewsAjax();
            </script>
                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="wp-content/themes/histudy/assets/images/blog/blog-grid-01.jpg" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Is lms The Most Trending
                                    Thing Now?</a></h5>
                            <p class="rbt-card-text">It is a long established fact that a reader.</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Learn
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"></path><path stroke-linecap="square" d="M.663 5.572h14.594"></path></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="wp-content/themes/histudy/assets/images/blog/blog-grid-02.jpg" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Learn How More Money With
                                    lms.</a></h5>
                            <p class="rbt-card-text">It is a long established fact that a reader.</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Learn
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"></path><path stroke-linecap="square" d="M.663 5.572h14.594"></path></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->

                <!-- Start Single Card  -->
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="rbt-card variation-02 rbt-hover">
                        <div class="rbt-card-img">
                            <a href="course-details.html">
                                <img src="wp-content/themes/histudy/assets/images/blog/blog-grid-03.jpg" alt="Card image"> </a>
                        </div>
                        <div class="rbt-card-body">
                            <h5 class="rbt-card-title"><a href="course-details.html">Understand The Background Of
                                    lms.</a></h5>
                            <p class="rbt-card-text">It is a long established fact that a reader.</p>
                            <div class="rbt-card-bottom">
                                <a class="transparent-button" href="course-details.html">Learn
                                    More<i><svg width="17" height="12" xmlns="http://www.w3.org/2000/svg"><g stroke="#27374D" fill="none" fill-rule="evenodd"><path d="M10.614 0l5.629 5.629-5.63 5.629"></path><path stroke-linecap="square" d="M.663 5.572h14.594"></path></g></svg></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Card  -->
            </div>
            <!-- End Card Area -->
        </div>
    </div>