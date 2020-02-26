<?php
namespace AppBundle\Subscriber;

use ForumBundle\Mailer\AppMailer;
use Doctrine\Common\Persistence\ObjectManager;
use ForumBundle\Event\BadgeUnlockedEvent;
use ForumBundle\Manager\BadgeManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BadgeSubscriber implements EventSubscriberInterface {

    /**
     * @var AppMailer
     */
    private $mailer;

    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var BadgeManager
     */
    private $badgeManager;

    public function __construct(AppMailer $mailer, ObjectManager $em, BadgeManager $badgeManager)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->badgeManager = $badgeManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BadgeUnlockedEvent::NAME => 'onBadgeUnlock',
        ];
    }

    public function onBadgeUnlock(BadgeUnlockedEvent $event) {
        return $this->mailer->badgeUnlocked($event->getBadge(), $event->getUser());
    }


}