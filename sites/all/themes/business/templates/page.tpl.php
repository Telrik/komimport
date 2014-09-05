<?php
/**
 * @file
 * Default theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/garland.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['sidebar_second']: Items for the second sidebar.
 * - $page['header']: Items for the header region.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 */
if (arg(0) == 'node' && $node && $node->field_page_h1['und'][0]['value']) {
    $title = $node->field_page_h1['und'][0]['value'];
}
?>
<script src="//api-maps.yandex.ru/2.0/?load=package.full&amp;lang=ru-RU" type="text/javascript"></script>
<div id="wrap">
    <?php if ($page['preheader']) { ?>
        <div id="preheader">
            <?php print render($page['preheader']); ?>
        </div>
    <? } ?>
    <header id="header" class="clearfix" role="banner">

        <div id='logo_sitename'>
            <?php if ($logo): ?>
                <div id="logo">
                    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/></a>
                </div>
            <?php endif; ?>
            <div id="sitename">
                <h2><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a></h2>

                <p><?php if ($site_slogan): ?><?php print $site_slogan; ?><?php endif; ?></p><!--site slogan-->
            </div>
        </div>

        <?php print render($page['headerright']); ?>
        <?php print render($page['header']); ?>
    </header>
    <?php print render($page['secondarycontent']); ?>

    <div id="main">

        <div id="main_page_content">
            <?
            $sitebar_not_shown = 'sitebar_not_shown';
            if (arg(0) != 'product' && $page['sidebar_first']) {
                $sitebar_not_shown = '';
            }
            ?>
            <section id="post-content" role="main" class='<?= $sitebar_not_shown ?>'>
                <?php if (theme_get_setting('breadcrumbs')): ?>
                    <div id="breadcrumbs"><?php if ($breadcrumb): print $breadcrumb; endif; ?></div><?php endif; ?>
                <?php print $messages; ?>
                <?php if ($page['content_top']): ?>
                    <div id="content_top"><?php print render($page['content_top']); ?></div><?php endif; ?>
                <?php print render($title_prefix); ?>
                <?php if ($title && !drupal_is_front_page()): ?><h1 class="page-title"><?php print $title; ?></h1><?php endif; ?>
                <?php print render($title_suffix); ?>
                <?php if (!empty($tabs['#primary'])): ?>
                    <div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
                <?php print render($page['help']); ?>
                <?php if ($action_links): ?>
                    <ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
                <?php print render($page['content']); ?>
                <?
                if (arg(0) == 'node') {
                    $var = views_embed_view('reviews', 'block', arg(1));
                    echo $var;
                }?>
                <?
                if (arg(0) == 'node' && $node->type == 'services') {
                    $block = block_load('block', '10');
                    $render_array = _block_get_renderable_array(_block_render_blocks(array($block)));
                    $output = render($render_array);
                    print $output;
                }
                ?>
            </section>
            <!-- /#main -->

            <?php
            if (arg(0) != 'product' && $page['sidebar_first']):

                ?>
                <aside id="sidebar" role="complementary" class="sidebar clearfix">
                    <?php print render($page['sidebar_first']); ?>

                    <?
                    if (!drupal_is_front_page() && !(isset($node) && $node->nid == 28)) {
                        $var = views_embed_view('reviews', 'block_1');
                        echo $var;
                    }
                    ?>
                </aside>  <!-- /#sidebar-first -->
            <?php endif; ?>
        </div>
        <? if (arg(0) == 'node' && $node && $node->field_seo_text['und'][0]['value']) { ?>
            <div class="text_line">
                <div class="line_content">
                    <?= $node->field_seo_text['und'][0]['value'] ?>
                </div>
            </div>
        <? } ?>

        <?php if ($page['footer_first'] || $page['footer_second'] || $page['footer_third'] || $page['footer_fourth']): ?>
            <div id="footer-saran" class="clearfix">
                <div id="footer-wrap">
                    <?php if ($page['footer_first']): ?>
                        <div class="footer-box"><?php print render($page['footer_first']); ?></div>
                    <?php endif; ?>
                    <?php if ($page['footer_second']): ?>
                        <div class="footer-box"><?php print render($page['footer_second']); ?></div>
                    <?php endif; ?>
                    <?php if ($page['footer_third']): ?>
                        <div class="footer-box"><?php print render($page['footer_third']); ?></div>
                    <?php endif; ?>
                    <?php if ($page['footer_fourth']): ?>
                        <div class="footer-box remove-margin"><?php print render($page['footer_fourth']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="clear"></div>
        <?php endif; ?>

        <!--END footer -->
        <? if ($page['footer']) { ?>
            <div id="footer-wrapper">
                <?php print render($page['footer']) ?>
            </div>
        <? } ?>

        <?php if (theme_get_setting('footer_copyright') || theme_get_setting('footer_credits')): ?>
            <div class="clear"></div>
            <div id="copyright">
                <?php if (theme_get_setting('footer_copyright')): ?>
                    <?php print t('Copyright'); ?> &copy; <?php echo date("Y"); ?>, <?php print $site_name; ?>.
                <?php endif; ?>
                <?php if (theme_get_setting('footer_credits')): ?>
                    <span class="credits"><?php print t('Designed by'); ?>  <a href="http://www.devsaran.com">Devsaran</a>.</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
