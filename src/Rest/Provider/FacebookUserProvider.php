<?php

namespace Rest\Provider;

use FOS\FacebookBundle\Security\User\UserManagerInterface as FacebookUserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class FacebookUserProvider implements FacebookUserProviderInterface
{
    /**
     * @var \BaseFacebook
     */
    private $fb;

    /**
     * @param \BaseFacebook $fb
     */
    public function __construct($fb)
    {
        $this->fb = $fb;
    }

    /**
     * @param string $uid
     *
     * @return User
     */
    public function loadUserByUsername($uid)
    {
        $user = \Rest\Model\User::find_by_fid($uid);

        if (!$user) {
            $user = $this->createUserFromUid($uid);
        }

        $enabled = $this->isEnabled();

        $user->update_attribute('enabled', (int) $enabled);

        return new User($uid, null, explode(',', $user->roles), $enabled, true, true, true);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * @param string $uid
     *
     * @return \Rest\Model\User
     */
    public function createUserFromUid($uid)
    {
        $facebookUser = $this->fb->api(PS.$uid);

        $user = \Rest\Model\User::create(array(
            'fid'        => $uid,
            'first_name' => $facebookUser['first_name'],
            'last_name'  => $facebookUser['last_name'],
            'email'      => $facebookUser['email'],
            'roles'      => 'ROLE_USER',
            'enabled'    => 1,
            'added'      => date("Y-m-d H:i:s"),
        ));

        return $user;
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return $class === 'Symfony\Component\Security\Core\User\User';
    }

    /**
     * @throw FacebookApiException
     *
     * @return bool
     */
    protected function isEnabled()
    {
        try {
            $group = $this->fb->api(PS.FB_GROUP_ID);
        } catch (\FacebookApiException $e) {
            return false;
        }

        return isset($group['id']) && $group['id'] == FB_GROUP_ID;
    }
}