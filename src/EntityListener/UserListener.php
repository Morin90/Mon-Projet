<?php
namespace App\EntityListener;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
/**
 * This class listens to events related to user entities and performs password encoding when necessary.
 */
class UserListener
{
    /**
 * Initializes the listener with a password hasher instance
 * @param UserPasswordHasherInterface $hasher
 * @return void
 * 
 */
    private UserPasswordHasherInterface $hasher;
    public function __construct(UserPasswordHasherInterface $hasher){
        $this->hasher = $hasher;
    }
    /**
     * Called before a user entity is persisted; encodes the user's password if it has a plain password set.
     * @param User $user
     * @return void
     */
    public function prePersist(User $user){
        $this->encodePassword( $user);
    }
    /**
     * Called before a user entity is updated; encodes the user's password if it has a plain password set.
     * @param User $user
     * @return void
     */
    public function preUpdate(User $user){
        $this->encodePassword($user);
    }
    /**
     * Encodes the user's password using the provided password hasher if the user has a plain password set; clears the plain password afterwards.
     * @param User $user
     * @return void
     */

    public function encodePassword(User $user){
        if($user->getPlainPassword()===null){
            return;
        }
        $user->setPassword(
            $this->hasher->hashPassword(
                $user,
                $user->getPlainPassword()
            )
            );
            $user->setPlainPassword(null);
    }
}