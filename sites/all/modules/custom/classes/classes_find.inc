<?php
/**
 * @file
 * Functions to extract ids or other values from different parameter types.
 */

/**
 * Find a nid from the provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_nid($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a nid:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XNode object or a regular Drupal node:
    return (int) $param->nid;
  }
  elseif (is_array($param)) {
    // $param is node record or a CCK field:
    return (int) $param['nid'];
  }
  return NULL;
}

/**
 * Find a uid from the provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_uid($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a uid:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XUserBase object or a regular Drupal user account object:
    return (int) $param->uid;
  }
  elseif (is_array($param)) {
    // $param is a Drupal user account or edit array:
    return (int) $param['uid'];
  }
  elseif (is_string($param)) {
    // $param is a username, look up the uid:
    return (int) db_result(db_query("SELECT uid FROM {users} WHERE name = '%s'", $param));
  }
  return NULL;
}

/**
 * Find a tid from the provided parameter.
 *
 * @param mixed $param
 * @param mixed $vocab = NULL
 * @return int
 */
function classes_find_tid($param, $vocab = NULL) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a tid:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XTermBase object or a regular Drupal taxonomy term object:
    return (int) $param->tid;
  }
  elseif (is_array($param)) {
    // $param is term_data record or a a CCK field; check for tid first:
    return isset($param['tid']) ? (int) $param['tid'] : (int) $param['value'];
  }
  elseif (is_string($param)) {
    // $param is a term name, look up the tid, using the vid if provided:
    $vid = classes_find_vid($vocab);
    $sql = "SELECT tid FROM {term_data} WHERE name = '%s'";
    if ($vid) {
      $sql .= " AND vid = $vid";
    }
    return (int) db_result(db_query($sql, $param));
  }
  return NULL;
}

/**
 * Find a vid from the provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_vid($param) {
  // Static cache mapping vocabulary names to vids:
  static $vids;

  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a vocabulary id:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XTermBase or regular Drupal taxonomy term object:
    // @todo Make a Vocabulary class.
    return (int) $param->vid;
  }
  elseif (is_array($param)) {
    // $param is a record from the term_data or vocabulary table:
    return (int) $param['vid'];
  }
  elseif (is_string($param)) {
    // $param is a vocabulary name, look up the vid.
    // Vocabulary names are not constrained to be unique.
    // This code will find the first matching vocabulary.
    // Check the static cache:
    if (!$vids[$param]) {
      $vid = (int) db_result(db_query("SELECT vid FROM {vocabulary} WHERE name = '%s'", $param));
      if ($vid) {
        $vids[$param] = $vid;
      }
    }
    return $vids[$param];
  }
  return NULL;
}

/**
 * Find a rid from the provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_rid($param) {
  // Static cache mapping role names to rids:
  static $rids;

  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a role id:
    return (int) $param;
  }
  elseif (is_object($param)) {
    return (int) $param->rid;
  }
  elseif (is_array($param)) {
    return (int) $param['rid'];
  }
  elseif (is_string($param)) {
    // $param is a role name, look up the rid:
    // Check the static cache:
    if (!$rids[$param]) {
      $rid = (int) db_result(db_query("SELECT rid FROM {role} WHERE name = '%s'", $param));
      if ($rid) {
        $rids[$param] = $rid;
      }
    }
    return $rids[$param];
  }
  return NULL;
}

/**
 * Find a fid from the provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_fid($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a file id:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XFileBase or a regular Drupal file object:
    return (int) $param->fid;
  }
  elseif (is_array($param)) {
    // $param is a record from the files table or a CCK field:
    return (int) $param['fid'];
  }
  elseif (is_string($param)) {
    // $param is a file path; look up the fid:
    return (int) db_result(db_query("SELECT fid FROM {files} WHERE filepath = '%s'", $param));
  }
  return NULL;
}

/**
 * Find a lid from the provided parameter.
 *
 * I've opted not to support strings here, since location names are often NULL
 * or not unique (many users could have a location called 'Home', for instance).
 * So there's little point finding a lid from a string.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_lid($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a location id:
    return (int) $param;
  }
  elseif (is_object($param)) {
    // $param is a XLocationBase or a regular Drupal location object:
    return (int) $param->lid;
  }
  elseif (is_array($param)) {
    // $param is a record from the location table or a CCK field:
    return (int) $param['lid'];
  }
  return NULL;
}

/**
 * Find a Unix timestamp from a provided parameter.
 *
 * @param mixed $param
 * @return int
 */
function classes_find_timestamp($param) {
  if (is_null($param)) {
    return NULL;
  }
  elseif (classes_is_int($param)) {
    // $param is a Unix timestamp:
    return (int) $param;
  }
  elseif ($param instanceof DateTime) {
    // $param is a DateTime or XDateTime object:
    return $param->getTimestamp();
  }
  elseif (is_string($param)) {
    $match = preg_match("/^\@(\d+)$/", $param);
    if ($match) {
      // $param is a Unix timestamp with the '@' prefix:
      return (int) $match[1];
    }
    else {
      // $param is a datetime string:
      return strtotime($param);
    }
  }
  else {
    // Arrays and other cases:
    $dt = new XDateTime($param);
    return $param->getTimestamp();
  }
  return NULL;
}
