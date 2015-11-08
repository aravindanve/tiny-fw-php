<?php

# TinyFW
# ------
# Tiny PHP Framework for Static Pages
# version 2.0
# by @aravindanve
# http://github.com/aravindanve

$DEBUG = true;

if ($DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$_config = $_ = [];

# directories
$_['page_dir']      = 'pages/';
$_['template_dir']  = 'templates/';
$_['partial_dir']   = 'partials/';

# defaults
$_['template_file']  = 'base';      // in templates
$_['404_file']       = 'notfound';  // in partials
$_['403_file']       = 'forbidden'; // in partials
$_['home_file']      = 'home';      // in pages

# urls
$_['base_url']      = '';           // auto sets if empty
$_['static_url']    = 'static/';

# page variables
$_page = [];

$_page['version']   = '0.1';
$_page['title']     = 'TinyFW 2';

# DO NOT MODIFY BELOW THIS LINE
# ---------------------------------------------------------------------------- #

# init
define('APPPATH', rtrim(dirname(__FILE__), '/').'/');
if (file_exists('config.php')) include APPPATH.'config.php';
if (file_exists('local.php')) include APPPATH.'local.php';
if (empty(trim($_['base_url']))) {
    if (isset($_SERVER['HTTP_HOST'])) {
        $_base_url = isset($_SERVER['HTTPS']) && strtolower(
            $_SERVER['HTTPS']) !== 'off'? 'https' : 'http';
        $_base_url .= '://'.$_SERVER['HTTP_HOST'].str_replace(
            basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
    } else {
        $_base_url = 'http://localhost/a';
    }
    $_['base_url'] = $_base_url;
}
foreach ($_ as $setting => &$value) {
    if (preg_match('/_dir$/i', $setting)) {
        $value = rtrim(APPPATH.$value, '/').'/';
    }
    if (preg_match('/_url$/i', $setting)) {
        $value = rtrim($value, '/').'/';
    }
    if (preg_match('/_file$/i', $setting)) {
        $value = preg_replace('/\.php$/i', '', trim($value)).'.php';
    }
} unset($value);
$_request_uri = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $_request_uri = trim(preg_replace('/^'.preg_quote(trim(str_replace(
        basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME'])), '/').
        '/i', '', $_SERVER['REQUEST_URI']));
    $_request_uri = rtrim($_request_uri, '/');
}
isset($ALLOW_URI_DEPTH) or $ALLOW_URI_DEPTH = false;
if (!$ALLOW_URI_DEPTH) {
    $_request_uri = trim(preg_replace(
        '/^.*\//i', '', rtrim($_request_uri, '/')));
}

# functions
function base_url($uri = '') {
    global $_;
    return $_['base_url'].ltrim($uri, '/');
}

function static_url($uri) {
    global $_, $_page;
    $full_url = base_url($_['static_url'].$uri);
    return $full_url.(preg_match('/\?/i', $full_url)? '&' : '?').
        'v='.$_page['version'];
}

function page($file, $folder = null) {
    global $_;
    isset($folder) or $folder = $_['page_dir'];
    $file = preg_replace('/\.php$/i', '', trim($file)).'.php';
    return rtrim($folder, '/').'/'.ltrim($file, '/');
}

function template($file) {
    global $_;
    return page($file, $_['template_dir']);
}

function partial($file) {
    global $_;
    return page($file, $_['partial_dir']);
}

function page_title($custom = '') {
    global $_page;
    return (empty($custom)? '' : $custom.' - ').$_page['title'];
}

# route
if (empty($_request_uri)) {
    # home
    $__pagelet = page($_['home_file']);
} else {
    $__pagelet = page($_request_uri);
}

# check if page exists
if (!file_exists($__pagelet)) {
    $__pagelet = partial($_['404_file']);
}

# render pagelet
ob_start();
include $__pagelet;
$_parsed_pagelet = ob_get_clean();

# set essential variables
isset($TEMPLATE) or $TEMPLATE = $_['template_file'];
isset($PAGE_TITLE) or $PAGE_TITLE = page_title();

$PAGE_BODY = $_parsed_pagelet;

# load template with
# PAGE_TITLE
# PAGE_BODY

include template($TEMPLATE);


