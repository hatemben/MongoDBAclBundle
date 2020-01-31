<?php

namespace hatemben\MongoDBAclBundle\Tests\Functional\Security\Problematic\Domain;

use hatemben\MongoDBAclBundle\Security\Problematic\Domain\AclManager;
use hatemben\MongoDBAclBundle\Security\Problematic\Model\AclManagerInterface;
use hatemben\MongoDBAclBundle\Tests\App\AbstractFunctionalTest;

class AclManagerTest extends AbstractFunctionalTest
{
    public function testServiceExistence()
    {
        $sut = $this->container->get('mongodb.acl_manager');

        $this->assertInstanceOf(AclManagerInterface::class, $sut);
        $this->assertInstanceOf(AclManager::class, $sut);
    }
}