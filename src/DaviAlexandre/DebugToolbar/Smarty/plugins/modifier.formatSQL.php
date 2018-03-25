<?php

use CRM_DebugToolbar_ExtensionUtil as E;

require_once E::path('libraries/SqlFormatter.php');

/**
 * Format a piece of SQL code
 *
 * Usage:
 *
 * @code
 * {$query|formatSQL}
 * @endcode
 *
 * @param string $value
 *   the SQL code to be formatted
 *
 * @return string
 */
function smarty_modifier_formatSQL($value) {
  return SqlFormatter::format($value, false);
}
