<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Studio
 */


 define( 'WP_USE_THEMES', false ); get_header(); ?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main" ng-cloak>
            <!--<div ng-class="{'is-loaded': allLoaded, 'is-not-loaded full-screen-cover': !allLoaded}" class="parent-valign">
                 <div class="child-valign">
                    <div class="shadow scaling pos-x"></div> <img class="diamond-loader floating" src="../wp-content/themes/leadership-diamond-theme/img/diamond.svg" /> </div>
            </div> -->
            <div>
                <!-- Heading -->
                <section id="heading">
                    <div class="row">
                        <div class="heading-container">
                            <div class="heading-second">{{leadershipOS.title}}</div>
                            <div class="heading-title"> {{leadershipdiamond.title}}<span>®</span> </div>
                            <div class="heading-second"> {{nothingButApps.title}}! </div>
                        </div> <img class="diamond" src="../wp-content/themes/leadership-diamond-theme/img/diamond.svg" />
                        <div class="shadow pos-0"></div>
                    </div>
                </section>
                <section id="graph">
                    <!-- Graph section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="graphs-container">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12"> <img class="graph" src="../wp-content/themes/leadership-diamond-theme/img/Graph-1.svg" /> </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="number">Din verksamhet kommer att dö!</div><span class="graph-text"> {{graphTexts.graph1.title}} Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin faucibus vestibulum velit sed gravida. Aenean vulputate iaculis purus id aliquam. Duis porttitor vitae nunc vitae interdum. Pellentesque eu feugiat diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent hendrerit dui nec turpis sollicitudin consequat. Fusce commodo nunc odio, id suscipit ante tristique id. Duis blandit ante et imperdiet lacinia. In hac habitasse platea dictumst. Fusce imperdiet ultricies sapien eget tincidunt. Morbi lorem quam, porta vitae enim eu, consequat ultricies magna. Nullam quis nisi sem. Cras cursus eros sit amet magna consequat interdum.</span> </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 float-right no-float-mobile"> <img class="graph" src="../wp-content/themes/leadership-diamond-theme/img/Graph-2.svg"> </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="number">Du räddar företaget, för studen...</div><span class="graph-text">{{graphTexts.graph2.title}}
                                    
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin faucibus vestibulum velit sed gravida. Aenean vulputate iaculis purus id aliquam. Duis porttitor vitae nunc vitae interdum. Pellentesque eu feugiat diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent hendrerit dui nec turpis sollicitudin consequat. Fusce commodo nunc odio, id suscipit ante tristique id. Duis blandit ante et imperdiet lacinia. In hac habitasse platea dictumst. Fusce imperdiet ultricies sapien eget tincidunt. Morbi lorem quam, porta vitae enim eu, consequat ultricies magna. Nullam quis nisi sem. Cras cursus eros sit amet magna consequat interdum.</span> </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-xs-12"> <img class="graph" src="../wp-content/themes/leadership-diamond-theme/img/Graph-3.svg"> </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div class="number">Gör rätt val vid brytpunkten!</div><span class="graph-text"> {{graphTexts.graph3.title}} Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin faucibus vestibulum velit sed gravida. Aenean vulputate iaculis purus id aliquam. Duis porttitor vitae nunc vitae interdum. Pellentesque eu feugiat diam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent hendrerit dui nec turpis sollicitudin consequat. Fusce commodo nunc odio, id suscipit ante tristique id. Duis blandit ante et imperdiet lacinia. In hac habitasse platea dictumst. Fusce imperdiet ultricies sapien eget tincidunt. Morbi lorem quam, porta vitae enim eu, consequat ultricies magna. Nullam quis nisi sem. Cras cursus eros sit amet magna consequat interdum.</span> </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button " class="btn leader-btn waves-effect waves-light" ng-click="goToElement('post-1')"> Se Exempel ▼ </button>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Graph section -->
                <section id="question">
                    <!-- Post section -->
                    <div class="row">
                        <uib-accordion close-others="oneAtATime">
                            <?php 
                            query_posts('&meta_key=wpcf-index&orderby=meta_value&order=ASC');
                                if ( have_posts() ) {
                                    while ( have_posts() ) {
                                        the_post();

                                        ?>
                                <script type="text/javascript">
                                    <?php $post_index = get_post_meta($post->ID,'wpcf-index',true); ?>
                                    <?php $posts_size = sizeof($posts); ?>;
                                </script>
                                <uib-accordion-group heading="<?php the_title(); ?>" id="post-<?php echo $post_index; ?>" class="page-scroll " ng-click="registerQuestionClick(<?php echo $post_index; ?>) ">
                                    <?php the_content();?>
                                        <div class="btns">
                                            <div class="next-btn-cont col-md-6" ng-show="<?php echo $post_index; ?> < <?php echo $posts_size; ?>">
                                                <button type="button " class="btn next-btn btn-success waves-effect waves-light" ng-click="$event.stopPropagation(); moveToNextPost(<?php echo $post_index; ?>) ">{{goToNextPost.title}} ▼</button>
                                            </div>
                                            <div class="leader-btn-cont col-md-6 ">
                                                <button type="button " class="btn leader-btn waves-effect waves-light" ng-click="$event.stopPropagation(); goToDiamondSection()"> {{goToDiamond.title}}! ▼ </button>
                                            </div>
                                        </div>
                                </uib-accordion-group>
                                <?php } // end while
                                } // end if
                                ?>
                        </uib-accordion>
                    </div>
                </section>
                <!-- Post section -->
                <section id="diamond">
                    <!-- Leadership Diamond section -->
                    <div class="row">
                        <div class="diamond-section clearfix">
                            <div class="question-card">
                                <div class="diamond-title "> {{leadershipdiamond.title}} </div>
                                <div class="diamond-about-text col-md-12"> <img align="right" src="../wp-content/themes/leadership-diamond-theme/img/PeterK.jpg" class="peter-image"> {{diamondAboutText.title}} </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="course">
                    <!-- Course offers section -->
                    <div class="row">
                        <div class="course-section clearfix">
                            <div class="course-title "> {{leadershipdiamond.title}} </div>
                            <!--                            <div class="diamond-about-text col-md-12"> <img align="left" src="../wp-content/themes/leadership-diamond-theme/img/PeterK.jpg" class="peter-image"> {{diamondAboutText.title}} </div>-->
                            <div ng-repeat="course in allCourses | orderBy: 'courseIndex' " class="course-container col-sm-6 col-xs-12 ">
                                <div class="course-title-container"> {{course.title}} </div>
                                <div class="course-level-container ng-hide"> {{course.level}} </div>
                                <div class="course-content-container"> {{course.content}} </div>
                            </div>
                            <div class="course-btn">
                                <a href="mailto: lars.beck-friis@accigo.se">
                                    <button class="btn"> Kontakta oss! </button>
                                </a>
                            </div>
                        </div> <img class="diamond pos-1" src="../wp-content/themes/leadership-diamond-theme/img/diamond.svg" />
                        <div class="shadow pos-1"></div> <img class="diamond pos-2 " src="../wp-content/themes/leadership-diamond-theme/img/diamond.svg" />
                        <div class="shadow pos-2"></div> <img class="diamond pos-3 " src="../wp-content/themes/leadership-diamond-theme/img/diamond.svg" />
                        <div class="shadow pos-3"> </div>
                    </div>
                </section>
                <!-- Course offers section -->
                <div class="lang-picker fixed-action-btn">
                    <div ng-repeat="lang in languages">
                        <div ng-if="currentLanguage.name !== lang.name "> <a class="btn-floating btn-large red " href="{{lang.url}}">{{lang.name}}</a> </div>
                        <!-- <div ng-if="currentLanguage.name===l ang.name ">{{lang.name}}</div> --></div>
                </div>
            </div>
            <!-- startCtrl-->
        </main>
        <!-- #main -->
    </div>
    <!-- #primary -->
    <?php get_footer(); ?>