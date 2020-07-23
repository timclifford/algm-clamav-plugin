<?php

namespace DrutinyTests\Audit;

use Drutiny\ClamAV\Audit\ClamAVScan;
use Drutiny\Container;
use Drutiny\Policy;
use Drutiny\Sandbox\Sandbox;
use Drutiny\Target\Registry as TargetRegistry;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class ClamAVScanTest extends TestCase {

  protected $target;

  public function __construct()
  {
    Container::setLogger(new NullLogger());
    $this->target = TargetRegistry::getTarget('none', '');
    parent::__construct();
  }

  public function testPass()
  {
    $policy = Policy::load('ClamAV:ClamAVScan');
    $sandbox = new Sandbox($this->target, $policy);

    $response = $sandbox->run();
    $this->assertTrue($response->isSuccessful());
  }
}
