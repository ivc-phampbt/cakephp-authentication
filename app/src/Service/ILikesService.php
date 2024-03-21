<?php

namespace App\Service;

interface ILikesService extends IBaseService
{
    /**
     * Has like.
     * @param mixed $userId: the user id.
     * @param mixed $articleId: the article id.
     * @return bool
     */
    public function hasLike($userId, $articleId) :bool;

    /**
     * Total likes
     * @param mixed $articleId: the article id.
     * @return int
     */
    public function totalLikes($articleId): int;
}
