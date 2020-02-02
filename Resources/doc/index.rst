MongoDB Acl Provider
====================

Installation using composer
---------------------------

To install MongoDBAclBundle using composer add following line to you composer.json file::

    # composer.json
    "hatemben/mongodb-acl-bundle": "dev-master"

Then composer update and the bundle will be added with flex.

Configuration
-------------

To use the MongoDB Acl Provider, the minimal configuration is adding acl_provider to the MongoDb config in config/packages/mongo_acl.yaml::

    # config/packages/mongo_acl.yaml
    mongo_db_acl:
        acl_provider: 
            default_database: '%env(MONGODB_DB)%'

Then you can test this with Sonata admin by adding in sonata_admin.yaml

    # config/packages/sonata_admin.yaml
    sonata_admin:
        security:
            handler: sonata.admin.security.handler.acl

The full acl provider configuration options are listed below::

    # app/config/config.yml
    mongo_db_acl:
        acl_provider:
            default_database: '%env(MONGODB_DB)%'
            collections:
                entry: acl_entry
                object_identity: acl_oid

Then initialize the MongoDB ACL with the following command::

    ./bin/console sonata:admin:setup-acl