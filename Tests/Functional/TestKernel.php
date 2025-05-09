<?php

namespace FOS\MessageBundle\Tests\Functional;

use FOS\MessageBundle\FOSMessageBundle;
use FOS\MessageBundle\Tests\Functional\Entity\Message;
use FOS\MessageBundle\Tests\Functional\Entity\Thread;
use FOS\MessageBundle\Tests\Functional\Entity\UserProvider;
use FOS\MessageBundle\Tests\Functional\EntityManager\MessageManager;
use FOS\MessageBundle\Tests\Functional\EntityManager\ThreadManager;
use FOS\MessageBundle\Tests\Functional\Form\UserToUsernameTransformer;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

/**
 * @author Guilhem N. <guilhem.niot@gmail.com>
 */
class TestKernel extends Kernel
{
    use MicroKernelTrait;

    /**
     * {@inheritdoc}
     */
    public function registerBundles(): iterable
    {
        $bundles = array(
            new FrameworkBundle(),
            new SecurityBundle(),
            new TwigBundle(),
            new FOSMessageBundle(),
        );

        return $bundles;
    }

    public function getCacheDir(): string
    {
        return \sprintf('%scache', $this->getBaseDir());
    }

    public function getLogDir(): string
    {
        return \sprintf('%slog', $this->getBaseDir());
    }

    public function getProjectDir(): string
    {
        return __DIR__;
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('@FOSMessageBundle/Resources/config/routing.xml');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void
    {
        $container->loadFromExtension('framework', array(
            'secret' => 'MySecretKey',
            'test' => null,
            'form' => null,
        ));

        $container->loadFromExtension('security', array(
            'providers' => array('permissive' => array('id' => 'app.user_provider')),
            'password_hashers' => array('FOS\MessageBundle\Tests\Functional\Entity\User' => 'plaintext'),
            'firewalls' => array('main' => array('http_basic' => true)),
        ));

        $container->loadFromExtension('twig', array(
            'strict_variables' => '%kernel.debug%',
        ));

        $container->loadFromExtension('fos_message', array(
            'db_driver' => 'orm',
            'thread_class' => Thread::class,
            'message_class' => Message::class,
        ));

        $container->register('fos_user.user_to_username_transformer', UserToUsernameTransformer::class);
        $container->register('app.user_provider', UserProvider::class);
        $container->addCompilerPass(new RegisteringManagersPass());
    }


    private function getBaseDir(): string
    {
        return \sprintf('%s/fos-message-bundle/var/', sys_get_temp_dir());
    }
}

class RegisteringManagersPass implements CompilerPassInterface {
    public function process(ContainerBuilder $container)
    {
        $container->register('fos_message.message_manager.default', MessageManager::class);
        $container->register('fos_message.thread_manager.default', ThreadManager::class);
    }
}
