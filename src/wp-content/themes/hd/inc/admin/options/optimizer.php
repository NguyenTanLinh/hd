<?php

use Cores\Helper;

$optimizer_options = Helper::getOption( 'optimizer__options' );

$https_enforce = $optimizer_options['https_enforce'] ?? 0;
$gzip = $optimizer_options['gzip'] ?? 0;
$bs_caching = $optimizer_options['bs_caching'] ?? 0;
$heartbeat = $optimizer_options['heartbeat'] ?? 0;
$svgs = $optimizer_options['svgs'] ?? 'disable';

$lazy_load = $optimizer_options['lazy_load'] ?? 0;
$minify_html = $optimizer_options['minify_html'] ?? 0;

$exclude_lazyload = $optimizer_options['exclude_lazyload'] ?? [];
$font_preload = $optimizer_options['font_preload'] ?? [];
$dns_prefetch = $optimizer_options['dns_prefetch'] ?? [];

$font_optimize = $optimizer_options['font_optimize'] ?? 0;

?>
<h2><?php _e( 'Optimizer Settings', TEXT_DOMAIN ); ?></h2>
<div class="section section-checkbox" id="section_https_enforce">
    <label class="heading" for="https_enforce"><?php _e( 'HTTPS', TEXT_DOMAIN ); ?></label>
    <div class="desc"><?php _e( 'Configures your site to work correctly via HTTPS and forces a secure connection to your site. In order to force HTTPS, we will automatically update your database replacing all insecure links. In addition to that, we will add a rule in your .htaccess file, forcing all requests to go through encrypted connection.', TEXT_DOMAIN ); ?></div>
    <div class="option">
        <div class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="https_enforce" id="https_enforce" <?php checked( $https_enforce, 1 ); ?> value="1">
        </div>
        <div class="explain"><?php _e( 'Check to activate', TEXT_DOMAIN ); ?></div>
    </div>
</div>
<div class="section section-checkbox" id="section_gzip">
    <label class="heading" for="gzip"><?php _e( 'GZIP Compression', TEXT_DOMAIN ); ?></label>
    <div class="desc"><?php _e( 'Enables compression of the content delivered to visitors\' browsers, improving the network loading times of your site.', TEXT_DOMAIN ); ?></div>
    <div class="option">
        <div class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="gzip" id="gzip" <?php checked( $gzip, 1 ); ?> value="1">
        </div>
        <div class="explain"><?php _e( 'Check to activate', TEXT_DOMAIN ); ?></div>
    </div>
</div>
<div class="section section-checkbox" id="section_bs_caching">
    <label class="heading" for="bs_caching"><?php _e( 'Browser Caching', TEXT_DOMAIN ); ?></label>
    <div class="desc"><?php _e( 'Adds rules to store the static content of your site in visitors\' browser cache for a longer period, improving site performance.', TEXT_DOMAIN ); ?></div>
    <div class="option">
        <div class="controls">
            <input type="checkbox" class="hd-checkbox hd-control" name="bs_caching" id="bs_caching" <?php checked( $bs_caching, 1 ); ?> value="1">
        </div>
        <div class="explain"><?php _e( 'Check to activate', TEXT_DOMAIN ); ?></div>
    </div>
</div>

<?php
if ( Helper::is_addons_active() ) {
    include ADDONS_PATH . 'src/Heartbeat/options.php';
	include ADDONS_PATH . 'src/SVG/options.php';
	include ADDONS_PATH . 'src/Minifier/options.php';
	include ADDONS_PATH . 'src/Font/options.php';
	include ADDONS_PATH . 'src/Lazy_Load/options.php';
}
