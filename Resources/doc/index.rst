MongoDB Acl Provider
====================

Installation using composer
---------------------------

To install MongoDBAclBundle using composer add following line to you composer.json file::

    # composer.json
    "hatemben/mongodb-acl-bundle": "dev-master"

Then simply run composer update.

Configuration
-------------

To use the MongoDB Acl Provider, the minimal configuration is adding acl_provider to the MongoDb config in config/packages/mongo_acl.yaml::

    # config/packages/mongo_acl.yaml
    mongo_db_acl:
        acl_provider: 
            default_database: '%env(MONGODB_DB)%'

Then you can test this with Sonata admin by adding in sonata_admin.yaml::

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

    $./bin/console sonata:admin:setup-acl
    ACL indexes have been initialized successfully.

Then you can test sonata admin for example ::

    $ ./bin/console sonata:admin:setup-acl
    Starting ACL AdminBundle configuration
     > install ACL for sonata.user.admin.user
       - add role: ROLE_SONATA_USER_ADMIN_USER_GUEST, permissions: ["LIST"]
       - add role: ROLE_SONATA_USER_ADMIN_USER_STAFF, permissions: ["LIST","CREATE"]
       - add role: ROLE_SONATA_USER_ADMIN_USER_EDITOR, permissions: ["OPERATOR","EXPORT"]
       - add role: ROLE_SONATA_USER_ADMIN_USER_ADMIN, permissions: ["MASTER"]
     > install ACL for sonata.user.admin.group
       - add role: ROLE_SONATA_USER_ADMIN_GROUP_GUEST, permissions: ["LIST"]
       - add role: ROLE_SONATA_USER_ADMIN_GROUP_STAFF, permissions: ["LIST","CREATE"]
       - add role: ROLE_SONATA_USER_ADMIN_GROUP_EDITOR, permissions: ["OPERATOR","EXPORT"]
       - add role: ROLE_SONATA_USER_ADMIN_GROUP_ADMIN, permissions: ["MASTER"]
