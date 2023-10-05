<div class="rbt-categories-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 align-items-start mb--30">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="section-title">
					<span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h4 class="title">Popular Categories.</h4>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="read-more-btn text-start text-md-end">
                        <a class="rbt-btn rbt-switch-btn bg-primary-opacity btn-sm" href="http://kursy.existparts.ru/all-courses/">
                            <span data-text="View All">View All</span>
                        </a>
                    </div>
                </div>
				
											<div class="row mt--60">
                        <div class="col-lg-12">
                            <div class="rbt-cats-filter-filter filter-button-default messonry-button text-start justify-content-start">
                                <button data-filter="*" class="is-checked" onclick="topCategories()">
                                    <span class="filter-text">All Categories</span>
                                    <span class="course-number"></span>
                                </button>
                            <? $tags = get_tags(array(
                                'hide_empty' => false,
                                'exclude'    => array(13, 17),
                                ));
                                $categories = get_categories( array(
                                    'orderby'      => 'name',
                                    'order'        => 'ASC',
                                    'hide_empty'   => 0,
                                    'exclude'      => array(15, 16),
                                    'include'      => '',
                                ));
                                $counterTag = 1;
                                ?>

                                <?foreach( $tags as $tag ):?>
                                    <?
                                    $arrayCat = [];
                                    $counterCat = 0;
                                    foreach( $categories as $cat ){
                                        $my_posts = get_posts( array(
                                            'tag'              => $tag->slug,
                                            'category'         => $cat->term_id,
                                        ) );
                                        if($my_posts && $cat->parent != 0){
                                            $arrayCat[$cat->name] = $cat->term_id;
                                        }
                                    }
                                    ?>
                                    <button data-filter=".cat--<?=$tag->term_id;?>" class="" onclick="topCategories('<?=$tag->name;?>')">
                                        <span class="filter-text"><?=$tag->name;?></span>
                                        <span class="course-number"><?=count($arrayCat);?></span>
                                    </button>
                                    <?$counterTag++;?>
                                <?endforeach;?>
                            </div>
                        </div>
                    </div>
            </div>
			<script>
                function topCategories(tag=''){
                    $.ajax({
                        type: "POST",
                        url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                        data: {
                            action : 'top_categories',
                            tag_: tag,
                        },
                        success: function (response) {
                            $("#ajax-top-categories").html(response);
                        }
                    });
                }
            </script>
            <div id='ajax-top-categories' class="row g-5"><script>topCategories();</script></div>
            
            

        </div>
    </div>