<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 *
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

function astro_format_about_how_long_ago($datetime) {
  $datetime = new StarDateTime($datetime);
  $time_ago = $datetime->aboutHowLongAgo();
  $time_ago = $time_ago == 'now' ? 'just now' : "about $time_ago ago";
  $iso = $datetime->format('Y-m-d\TH:i:s\Z');
  return "<time datetime='$iso'>$time_ago</time>";
}

/**
 * Returns HTML for a link to a file.
 *
 * @param $variables
 *   An associative array containing:
 *   - file: A file object to which the link will be created.
 *   - icon_directory: (optional) A path to a directory of icons to be used for
 *     files. Defaults to the value of the "file_icon_directory" variable.
 *
 * @ingroup themeable
 */
function astro_file_link($variables) {
  $image_mime_types = array(
    'image/jpeg',
    'image/png',
    'image/gif'
  );

  $file = $variables['file'];
  $url = file_create_url($file->uri);

  if (in_array($file->filemime, $image_mime_types)) {
    // Get the image dimensions:
    $path = drupal_realpath($file->uri);
    $image_info = getimagesize($path);

    $description = isset($file->description) ? $file->description : '';

    // Get the HTML for the image as medium style:
    $image_vars = array(
      'style_name' => 'medium',
      'path'       => $file->uri,
      'width'      => $image_info[0],
      'height'     => $image_info[1],
      'alt'        => $description,
      'title'      => $description,
    );
    $image = theme('image_style', $image_vars);

    // Create a link to the full-sized image in a colorbox:
    return l($image, $url, array(
                                'html'       => TRUE,
                                'attributes' => array(
                                  'class' => array('colorbox'),
                                  'alt'   => check_plain($description),
                                  'title' => check_plain($description),
                                  'rel'   => 'gallery-channel',
                                )
                           ));
  }
  else {
    $icon_directory = $variables['icon_directory'];
    $icon = theme('file_icon', array(
                                    'file'           => $file,
                                    'icon_directory' => $icon_directory
                               ));

    // Set options as per anchor format described at
    // http://microformats.org/wiki/file-format-examples
    $options = array(
      'attributes' => array(
        'type'   => $file->filemime . '; length=' . $file->filesize,
        'target' => '_blank',
        'title'  => check_plain($file->description),
      ),
    );

    $link_text = $file->filename;
    return '<span class="file">' . $icon . ' ' . l($link_text, $url, $options) . '</span>';
  }
}
