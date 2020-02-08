<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace hatemben\MongoDBAclBundle\Security\Acl\Domain;

/**
 * A SecurityIdentity implementation used for actual users
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
final class UserSecurityIdentity implements SecurityIdentityInterface
{
    private $id;
    private $class;

    /**
     * Constructor
     *
     * @param string $id the username representation
     * @param string $class    the user's fully qualified class name
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($id, $class)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('$id must not be empty.');
        }
        if (empty($class)) {
            throw new \InvalidArgumentException('$class must not be empty.');
        }

        $this->id = (string) $id;
        $this->class = $class;
    }

    /**
     * Creates a user security identity from a UserInterface
     *
     * @param UserInterface $user
     * @return UserSecurityIdentity
     */
    public static function fromAccount(UserInterface $user)
    {
        return new self($user->getId(), ClassUtils::getRealClass($user));
    }

    /**
     * Creates a user security identity from a TokenInterface
     *
     * @param TokenInterface $token
     * @return UserSecurityIdentity
     */
    public static function fromToken(TokenInterface $token)
    {
        $user = $token->getUser();

        if ($user instanceof UserInterface) {
            return self::fromAccount($user);
        }

        return new self((string) $user, is_object($user) ? ClassUtils::getRealClass($user) : ClassUtils::getRealClass($token));
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->id;
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the user's class name
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(SecurityIdentityInterface $sid)
    {
        if (get_class($sid)!='hatemben\MongoDBAclBundle\Security\Acl\Domain\UserSecurityIdentity') {
            return false;
        }
        return $this->id === $sid->getId()
            && $this->class === $sid->getClass();
    }

    /**
     * A textual representation of this security identity.
     *
     * This is not used for equality comparison, but only for debugging.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('UserSecurityIdentity(%s, %s)', $this->id, $this->class);
    }
}