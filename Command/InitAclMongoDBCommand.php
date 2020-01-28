<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hatemben\MongoDBAclBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Set the indexes required by the MongoDB ACL provider
 *
 * @author Richard Shank <develop@zestic.com>
 */
class InitAclMongoDBCommand extends Command
{

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        parent::__construct();
    }
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('init:acl:mongodb')
            ->setDescription('Set the indexes required by the MongoDB ACL provider')
        ;
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // todo: change services and paramters when the configuration has been finalized
        $mongo = $this->container->get('doctrine_mongodb.odm.default_connection');
        $dbName = $this->container->getParameter('doctrine_mongodb.odm.security.acl.database');
        $db = $mongo->selectDatabase($dbName);

        $oidCollection = $db->selectCollection($this->container->getParameter('doctrine_mongodb.odm.security.acl.oid_collection'));
        $oidCollection->ensureIndex(array('randomKey' => 1), array());
        $oidCollection->ensureIndex(array('identifier' => 1, 'type' => 1));

        $entryCollection = $db->selectCollection($this->container->getParameter('doctrine_mongodb.odm.security.acl.entry_collection'));
        $entryCollection->ensureIndex(array('objectIdentity.$id' => 1));

        $output->writeln('ACL indexes have been initialized successfully.');
    }
}
