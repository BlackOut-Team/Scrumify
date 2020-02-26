<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new AppBundle\AppBundle(),
            new MainBundle\MainBundle(),
            new TasksBundle\TasksBundle(),
            new ForumBundle\ForumBundle(),
            new ActivityBundle\ActivityBundle(),
            new TeamBundle\TeamBundle(),
            new UserstoryBundle\UserstoryBundle(),
            new SprintBundle\SprintBundle(),
            new ScrumBundle\ScrumBundle(),
            new MyAppMailBundle\MyAppMailBundle(),
            new MessagingBundle\MessagingBundle(),
            new FOS\CKEditorBundle\FOSCKEditorBundle(),
            new CMEN\GoogleChartsBundle\CMENGoogleChartsBundle(),
            new GrapheBundle\GrapheBundle(),
            new FOS\MessageBundle\FOSMessageBundle(),
            new Mgilet\NotificationBundle\MgiletNotificationBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),

            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),

            new ADesigns\CalendarBundle\ADesignsCalendarBundle(),

            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new CalendarBundle\CalendarBundle(),

        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
