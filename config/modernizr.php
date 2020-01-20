<?php

return [

    /*
     * Your project specific Modernizr config file.
     * This file determines which feature detections will be included.
     */
    'config_path' => base_path('modernizr.json'),

    /*
     * Your local instance of Modernizr.
     * Usually somewhere inside the `node_modules` directory.
     */
    'modernizr_path' => base_path('node_modules/.bin/modernizr'),

    /*
     * Path and filename of the script to be generated.
     * Make sure this name does not collide with an existing file as it will be overwritten!
     */
    'resource_path' => resource_path('js/modernizr.min.js'),

    /*
     * Determines if the output is minified.
     */
    'minify' => true,

];
