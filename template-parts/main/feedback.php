<div class="rbt-testimonial-area  rbt-section-gap bg-color-extra2 overflow-hidden mt_dec--120 mt_lp_dec--30 mt_lg_dec--30 mt_md_dec--30 mt_sm_dec--30">
			
			        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb--60">
                    <div class="section-title text-center">
                        <span class="subtitle bg-primary-opacity">EDUCATION FOR EVERYONE</span>
                        <h2 class="title">Student's <span class="color-primary">Feedback</span></h2>
                    </div>
                </div>
            </div>
			</div>
			
       
		<div class="scroll-animation-wrapper mt--50">

            <div id="ajax-feedback-top" class="scroll-animation scroll-right-left">

            </div>
        </div>
        <div class="scroll-animation-wrapper mt--50">

            <div id="ajax-feedback-botton" class="scroll-animation scroll-left-right">

            </div>
        </div>
        <script>
            function feedbackAjax(){
                $.ajax({
                    type: "POST",
                    url: 'http://kursy.existparts.ru/wp-admin/admin-ajax.php',
                    data: {
                        action : 'feedback',
                    },
                    success: function (response) {
                        $("#ajax-feedback-top").html(response);
                        $("#ajax-feedback-botton").html(response);
                    }
                });
            }
            feedbackAjax();
        </script>
		</div>