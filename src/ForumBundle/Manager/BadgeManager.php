<?php
namespace ForumBundle\Manager;

use MainBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use ForumBundle\Entity\BadgeUnlock;
use ForumBundle\Event\BadgeUnlockedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BadgeManager {

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(ObjectManager $manager, EventDispatcherInterface $dispatcher)
    {
        $this->em = $manager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Check if a badge exists for this action and action occurence and unlock it for the user
     *
     * @param User $user
     * @param string $action
     * @param int $action_count
     */
    public function checkAndUnlock(User $user, string $action, int $action_count): void {
        // Vérifier si on a un badge qui correspond à action et action count
        try {
            $badge = $this->em
                ->getRepository('ForumBundle:Badge')
                ->findWithUnlockForAction($user->getId(), $action, $action_count);
            // Vérifier si l'utilisateur a déjà ce badge
            if ($badge->getUnlocks()->isEmpty()) {
                // Débloquer le badge pour l'utilisateur en question
                $unlock = new BadgeUnlock();
                $unlock->setBadge($badge);
                $unlock->setUser($user);
                $this->em->persist($unlock);
                $this->em->flush();
                // Emetter un évènement pour informer l'application du déblocage de bage
                $this->dispatcher->dispatch(BadgeUnlockedEvent::NAME, new BadgeUnlockedEvent($unlock));
            }
        } catch (NoResultException $e) {

        }
    }

    /**
     * Get Badges unlocked for the current user
     *
     * @param User $user
     * @return array
     */
    public function getBadgeFor (User $user): array {
        return $this->em->getRepository('ForumBundle:Badge')->findUnlockedFor($user->getId());
    }

}