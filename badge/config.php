<?php

/**
 * Configuration files that holds the image settings for each project
 * SD = Screendoor
 * Get data from Screendoor API:
 * http://dobtco.github.io/screendoor-api-docs/
 * Sample config:
 *   '2916' =>  array (                                           // Project Identifier (if Screendoor is used, then use SD project id)
 *  'project'         => '#Africa4Her 2016',                    // project name
 *  'prefix'          => 'yali_africa2016_',                    // prefix to append to the saved image
 *  'src_path'        => '/images/yali_africa4her_bkgrd.png',    // image src path
 *  'save_path'       => '/generated-images/',                  // folder to save image in
 *  'font'            => 'Lato-Regular.ttf',                    // default proj font family of dynamic text (file saved in fonts dir)
 *  'font_size'       => 40,                                    // default font size of dynamic text
 *  'color'           => '#333333',                              // default font color of dynamic text
 *  'align'           => 'center',                              // default text align of dynamic text
 *  'line_max_chars'  => 31,                                    // max number of characters per line before text wraps
 *  'line_height'     => 62,                                    // height of text line (sapce between lines)
 *  'text'            => array (                                // text content
 *    array (
 *      'content'     => 'FIELD',                               // use 'FIELD' string for runtime content & provide SD field_id
 *      'field_id'    => 35173,                                 // SD field ID
 *      'x'           => 428,                                    // x position of text
 *      'y'           => 250,                                    // y position of text
 *      'color'       => '#218b43'                              // overide default color
 *    ),
 *    array (
 *      'content'     => 'My name is',
 *      'x'           => 40,
 *      'y'           => 75,
 *      'color'       => '#314071'
 *    ),
 *    array (
 *      'content'     => 'FIELD',
 *      'field_id'    => 35164,
 *      'x'           => 428,
 *      'y'           => 385,
 *      'color'       => '#218b43'
 *    ),
 *    array (
 *      'content'     => 'FIELD',
 *      'field_id'    => 35170,
 *      'x'           => 428,
 *      'y'           => 426 ,
 *      'color'       => '#bf202a',
 *      'font'        => 'AvenirNext-Bold.ttf',
 *      'font_size'   => 24
 *    )
 *  )
 *)
 */

return array(
  'get_certificate'   =>  array (             // Form that is sending certificate -- MUST match form key
    'prefix'          => 'ylai_certificate_',
    'src_path'        => 'images/ylai_certificate_bkgrd.png',
    'save_path'       => 'generated-images/',
    'font'            => 'fonts/Oxygen-Bold.otf',
    'font_size'       => 32,
    'color'           => '#009bdc',
    'align'           => 'center',
    'line_max_chars'  => 40,
    'line_height'     => 42,
    'text'            => array (
      array (
        'content'     => 'FIELD',
        'field_id'    => 'course_name',       // course name (formidable field key) -- MUST match
        'x'           => 549,
        'y'           => 345
      ),
      array (
        'content'     => 'FIELD',
        'field_id'    => 'full_name_course',   // Name to appear on certificate (formidable field key)  -- MUST match
        'x'           => 542,
        'y'           => 580
      ),
      array (
        'content'     => date("F j, Y"),      // Date, static field
        'x'           => 550,
        'y'           => 680,
        'font_size'   => 18
      )
    )
  ),
  'get_membership_badge'   =>  array (             // Form that is sending certificate -- MUST match form key
    'prefix'          => 'ylai_membership_card_',
    'src_path'        => 'images/ylai_membership_card_bkgrd.png',
    'save_path'       => 'generated-images/',
    'font'            => 'fonts/Oxygen-Regular.ttf',
    'font_size'       => 60,
    'color'           => '#2f78ab',
    'align'           => 'center',
    'line_max_chars'  => 40,
    'line_height'     => 80,
    'text'            => array (
      array (
        'content'     => 'FIELD',
        'field_id'    => 'full_name',       // Full name (formidable field key) -- MUST match
        'font_size'   => 65,
        'x'           => 750,
        'y'           => 280,
        'font'        => 'fonts/Oxygen-Bold.otf'
      ),
      array (
        'content'     => 'FIELD',
        'field_id'    => 'country',   // Country (formidable field key)  -- MUST match
        'x'           => 750,
        'y'           => 385
      ),
      array (
        'content'     => 'FIELD',      // Year (formidable field key)  -- MUST match
        'field_id'    => 'year',
        'align'       => 'left',
        'x'           => 1074,
        'y'           => 476
      )
    )
  ),
  'get_certificate_es'   =>  array (             // Form that is sending certificate -- MUST match form key
    'prefix'          => 'ylai_certificate_es_',
    'src_path'        => 'images/ylai_certificate_es_bkgrd.jpg',
    'save_path'       => 'generated-images/',
    'font'            => 'fonts/Oxygen-Bold.otf',
    'font_size'       => 35,
    'color'           => '#009bdc',
    'align'           => 'center',
    'line_max_chars'  => 40,
    'line_height'     => 42,
    'text'            => array (
      array (
        'content'     => 'FIELD',
        'field_id'    => 'course_name_es',       // course name (formidable field key) -- MUST match
        'x'           => 550,
        'y'           => 345
      ),
      array (
        'content'     => 'FIELD',
        'field_id'    => 'full_name_course_es',   // Name to appear on certificate (formidable field key)  -- MUST match
        'x'           => 550,
        'y'           => 580
      ),
      array (
        'content'     => date("d/m/Y"),      // Date, static field
        'x'           => 550,
        'y'           => 680,
        'font_size'   => 22
      )
    )
  )
);
