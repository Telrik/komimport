<?php
drupal_add_library('system', 'ui.dialog');

/*
function business_theme(&$existing, $type, $theme, $path)
{
    $hooks['user_login_block'] = array(
        'template' => 'templates/user-login-block',
        'render element' => 'form',
    );
    return $hooks;
}

function business_theme(&$existing, $type, $theme, $path)
{
    $hooks['user_login'] = array(
        'template' => 'templates/user-login-block',
        'render element' => 'form',
    );
    return $hooks;
}

function business_preprocess_user_login_block(&$vars)
{
    // For debug only
    //print '<pre>';
    //print_r($vars['form']);
    //print '</pre>';
    //exit;

    $vars['name'] = render($vars['form']['name']);
    $vars['pass'] = render($vars['form']['pass']);
    $vars['submit'] = render($vars['form']['actions']['submit']);
    $vars['rendered'] = drupal_render_children($vars['form']);
}
*/


function business_menu_link($variables)
{

    $path = drupal_get_path_alias($variables['element']['#original_link']['link_path']);
    $path_cur = drupal_get_path_alias(current_path());
    $element = $variables['element'];
    if ($path == $path_cur || ($path == '<front>' && drupal_is_front_page())) {
        $element['#attributes']['class'][] = 'active_item';
    }
    $sub_menu = '';
    $element['#attributes']['class'][] = 'depth_' . $variables['element']['#original_link']['depth'];
    $element['#attributes']['class'][] = 'sf-depth-' . $variables['element']['#original_link']['depth'];
    $element['#attributes']['class'][] = 'mlid_' . $variables['element']['#original_link']['mlid'];

    $element['#localized_options']['attributes']['class'][] = 'sf-depth-' . $variables['element']['#original_link']['depth'];

    if ($variables['element']['#original_link']['mlid'] == 372) {
        $element['#attributes']['class'][] = 'call_func';
    }


    if ($element['#below']) {
        $sub_menu = drupal_render($element['#below']);
    }

    if ($variables['element']['#original_link']['mlid'] == 331) {
        $terms = taxonomy_get_tree(1, 27);
        $sub_menu = business_get_link_to_menu($terms);
    }
    if ($variables['element']['#original_link']['mlid'] == 332) {
        $terms = taxonomy_get_tree(1, 25);
        $sub_menu = business_get_link_to_menu($terms);
    }
    if ($variables['element']['#original_link']['mlid'] == 918) {
        $terms = taxonomy_get_tree(1, 0, 1);
        $sub_menu = business_get_link_to_menu($terms);
    }

    $output = l($element['#title'], $element['#href'], $element['#localized_options']);

    return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

function business_get_link_to_menu($terms)
{
    $out = '<ul>';
    foreach ($terms as $term) {
        $out .= '<li>' . l($term->name, drupal_get_path_alias('taxonomy/term/' . $term->tid)) . "</li>\n";
    }
    $out .= '</ul>';
    return $out;
}

/**
 * Implements hook_html_head_alter().
 * This will overwrite the default meta character type tag with HTML5 version.
 */
function business_html_head_alter(&$head_elements)
{
    $head_elements['system_meta_content_type']['#attributes'] = array(
        'charset' => 'utf-8'
    );
}

/**
 * Insert themed breadcrumb page navigation at top of the node content.
 */
function business_breadcrumb($variables)
{
    $breadcrumb = $variables['breadcrumb'];
    if (!empty($breadcrumb)) {
        // Use CSS to hide titile .element-invisible.
        $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';
        //kpr($breadcrumb);
        if (arg(0) == 'node') {
            $node = node_load(arg(1));
            if ($node->type == 'services' && count($breadcrumb) == 1) {
                $breadcrumb[] = l('Услуги', 'services');
            }
        }
        // comment below line to hide current page to breadcrumb
        $breadcrumb[] = drupal_get_title();
        $output .= '<nav class="breadcrumb">' . implode(' → ', $breadcrumb) . '</nav>';
        return $output;
    }
}

/**
 * Override or insert variables into the html template.
 */
function business_process_html(&$vars)
{
    // Hook into color.module
    if (module_exists('color')) {
        _color_html_alter($vars);
    }
}

/**
 * Override or insert variables into the page template.
 */
function business_process_page(&$variables)
{
    // Hook into color.module.
    if (module_exists('color')) {
        _color_page_alter($variables);
    }

}

/**
 * Override or insert variables into the page template.
 */
drupal_add_library('system', 'ui.tabs');
function business_preprocess_page(&$vars)
{
    if (isset($vars['page']['content']['system_main']['no_content'])) {
        unset($vars['page']['content']['system_main']['no_content']);
    }
    if (isset($vars['main_menu'])) {
        $vars['main_menu'] = theme('links__system_main_menu', array(
            'links' => $vars['main_menu'],
            'attributes' => array(
                'class' => array('links', 'main-menu', 'clearfix'),
            ),
            'heading' => array(
                'text' => t('Main menu'),
                'level' => 'h2',
                'class' => array('element-invisible'),
            )
        ));
    } else {
        $vars['main_menu'] = FALSE;
    }
    if (isset($vars['secondary_menu'])) {
        $vars['secondary_menu'] = theme('links__system_secondary_menu', array(
            'links' => $vars['secondary_menu'],
            'attributes' => array(
                'class' => array('links', 'secondary-menu', 'clearfix'),
            ),
            'heading' => array(
                'text' => t('Secondary menu'),
                'level' => 'h2',
                'class' => array('element-invisible'),
            )
        ));
    } else {
        $vars['secondary_menu'] = FALSE;
    }
}

/**
 * Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */
function business_menu_local_tasks(&$variables)
{
    $output = '';

    if (!empty($variables['primary'])) {
        $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
        $variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
        $variables['primary']['#suffix'] = '</ul>';
        $output .= drupal_render($variables['primary']);
    }
    if (!empty($variables['secondary'])) {
        $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
        $variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
        $variables['secondary']['#suffix'] = '</ul>';
        $output .= drupal_render($variables['secondary']);
    }
    return $output;
}

/**
 * Override or insert variables into the node template.
 */
function business_preprocess_node(&$variables)
{
    $node = $variables['node'];
    if ($variables['view_mode'] == 'full' && node_is_page($variables['node'])) {
        $variables['classes_array'][] = 'node-full';
    }
}

/**
 * Add javascript files for front-page jquery slideshow.
 */
if (drupal_is_front_page()) {
    drupal_add_js(drupal_get_path('theme', 'business') . '/js/sliding_effect.js');
}
