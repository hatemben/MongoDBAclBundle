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

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Acl\Util\ClassUtils;
use Symfony\Component\Security\Acl\Model\SecurityIdentityInterface;

/**
 * A SecurityIdentity implementation used for actual users
 *
 * @author Johannes M. Schmitt <schmittjoh@gmail.com>
 */
final class UserSecurityIdentity implements SecurityIdentityInterface
{
    private $userId;
    private $class;

    /**
     * Constructor
     *
     * @param string $userId the username representation
     * @param string $class    the user's fully qualified class name
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($userId, $class)
    {
        if (empty($userId)) {
            throw new \InvalidArgumentException('$userId must not be empty.');
        }
        if (empty($class)) {
            throw new \InvalidArgumentException('$class must not be empty.');
        }

        $this->userId = (string) $userId;
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
        return $this->userId;
    }

    /**
     * Returns the username
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
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

        if (!$sid instanceof UserSecurityIdentity) {
            return false;
        }

        return $this->userId === $sid->getUsername()
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
        return sprintf('UserSecurityIdentity(%s, %s)', $this->userId, $this->class);
    }
}