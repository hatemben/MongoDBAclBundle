<?php

namespace hatemben\MongoDBAclBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Psr\Container\ContainerInterface;

/**
 * Set the indexes required by the MongoDB ACL provider
 *
 * @author Richard Shank <develop@zestic.com>
 */
class InitAclMongoDBCommand extends Command
{

    private $container;

    protected static $defaultName = 'init:acl:mongodb';
    const MESSAGE_SUCCESS = 'ACL indexes have been initialized successfully.';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct();

    }

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Set the indexes required by the MongoDB ACL provider.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Command help will be updated asap.')
        ;

    }

    /**
     * @see Command
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // todo: change services and parameters when the configuration has been finalized
        $mongo = $this->container->get('doctrine_mongodb.odm.default_connection');
        $dbName = $this->container->getParameter('doctrine_mongodb.odm.security.acl.database');
        $db = $mongo->selectDatabase($dbName);

        $oidCollection = $db->selectCollection($this->container->getParameter('doctrine_mongodb.odm.security.acl.oid_collection'));
        $oidCollection->ensureIndex(['randomKey' => 1], []);
        $oidCollection->ensureIndex(['identifier' => 1, 'type' => 1]);

        $entryCollection = $db->selectCollection($this->container->getParameter('doctrine_mongodb.odm.security.acl.entry_collection'));
        $entryCollection->ensureIndex(['objectIdentity.$id' => 1]);

        $output->writeln(self::MESSAGE_SUCCESS);
    }
}
