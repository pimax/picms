<?php $this->beginContent('//layouts/main'); ?>
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->

    <!-- sidebar -->
    <aside class="sidebar">
        
        <?php $this->widget('application.modules.publications.components.BestPosts'); ?>

        <section>            
            <div id="fb-root"></div>
            <script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>

            <div class="fb-like-box" data-href="http://www.facebook.com/fashiondb" data-width="292" data-show-faces="true" data-stream="false" data-header="false"></div>
        </section>    
        <br />
        <section>
            <!-- VK Widget -->
            <div id="vk_groups"></div>
            <script type="text/javascript">
            VK.Widgets.Group("vk_groups", {mode: 0, width: "292", height: "290"}, 31031505);
            </script>
        </section>

    </aside> 		
    <!-- end sidebar -->
<?php $this->endContent(); ?>
