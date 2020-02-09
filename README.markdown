MongoDB ACL Bundle
====================

This bundle allows the use of MongoDB as the storage layer for the Symfony ACLs component.

This is the working version with an ODM. Notice that it works only with Sonata Admin ACL editor for users/roles, but not with Groups !
Tests need to be updated, and code to be reviewed. This version have been updated to use user's id in UserSecurityIdentity instead of username.  

![Image of User Acl](Resources/public/images/user-acl.png)

![Image of Acl Options](Resources/public/images/acl-options.png)

[![Build Status](https://travis-ci.org/hatemben/MongoDBAclBundle.svg?branch=master)](http://travis-ci.org/hatemben/MongoDBAclBundle)


Documentation
-------------

The documentation for configuring this bundle can be found [here](Resources/doc/index.rst).

