<?php

namespace Drutiny\ClamAV\Audit;

use Drutiny\Audit;
use Drutiny\Sandbox\Sandbox;

/**
 *
 */
class ClamAVScan extends Audit {

  /**
   * @inheritdoc
   */
  public function audit(Sandbox $sandbox) {
    $is_infected = FALSE;
    $infected_files_count = 0;

    try {
      # Run clamsacn and pipe true to supress early exit error caused if infected files are found.
      $output = $sandbox->exec('clamscan . --suppress-ok-results --stdout || true');

      $searchfor = 'Infected files';
      $pattern = "/^.*$searchfor.*\$/m";
      if (preg_match_all($pattern, $output, $matches)) {
         $implode = implode("\n", $matches[0]);
         $infected_files_result = explode(':', $implode);

         if ($infected_files_result[1] > 0) {
           $is_infected = TRUE;
           $infected_files_count = $infected_files_result[1];
         }
      }
    }
    catch (Exception $e) {
      return Audit::ERROR;
    }

    if (!$is_infected) {
      return TRUE;
    }

    $result = [
        'is_infected' => $is_infected,
        'infected_files_count' => $infected_files_count
    ];

    if (empty($result)) {
      return FALSE;
    }

    $sandbox->setParameter('report', $result);
    return FALSE;
  }
}
