<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Likes;
use Authorization\IdentityInterface;

/**
 * Likes policy
 */
class LikesPolicy
{
    /**
     * Check if $user can add Likes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Likes $likes
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Likes $likes)
    {
        return true;
    }

    /**
     * Check if $user can edit Likes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Likes $likes
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Likes $likes)
    {
        return false;
    }

    /**
     * Check if $user can delete Likes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Likes $likes
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Likes $likes)
    {
        return false;
    }

    /**
     * Check if $user can view Likes
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Likes $likes
     * @return bool
     */
    public function canView(IdentityInterface $user, Likes $likes)
    {
        return true;
    }
}
