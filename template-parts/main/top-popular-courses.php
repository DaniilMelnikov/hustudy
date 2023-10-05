<div class="rbt-course-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row mb--55 g-5 align-items-end">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title text-start">
                        <span class="subtitle bg-pink-opacity">Top Popular Course</span>
                        <h2 class="title">Most Popular <span class="color-primary">Courses</span></h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="load-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity" href="http://kursy.existparts.ru/all-courses/">
                            <span data-text="View All Course">View All Course</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Start Card Area -->
            <div id='ajax-top-course' class="row g-5">
                <script>
                    function topCourse(){
                        $.ajax({
                            type: "POST",
                            url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                            data: {
                                action : 'top_courses',
                            },
                            success: function (response) {
                                $("#ajax-top-course").html(response);
                            }
                        });
                    }
                    topCourse();
                </script>
            </div>
            <!-- End Card Area -->
        </div>
    </div>