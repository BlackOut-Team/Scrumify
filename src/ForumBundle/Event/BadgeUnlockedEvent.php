<?php
    namespace ForumBundle\Event;
    use ForumBundle\Entity\Badge;
    use ForumBundle\Entity\BadgeUnlock;
    use MainBundle\Entity\User;
    use Symfony\Component\EventDispatcher\Event;

    class BadgeUnlockedEvent extends Event{

        const NAME = 'badge.unlock';

        private $badgeUnlock;
        public function __construct(BadgeUnlock $badgeUnlock)
        {
                $this->badgeUnlock = $badgeUnlock;
        }/**
     * @return BadgeUnlock
     */
public function getBadgeUnlock(): BadgeUnlock
{
    return $this->badgeUnlock;
}
    public function getBadge(): Badge
    {

        return $this->badgeUnlock->getBadge();
    }

    public function getUser(): User
    {

        return $this->badgeUnlock->getUser();
    }

    }