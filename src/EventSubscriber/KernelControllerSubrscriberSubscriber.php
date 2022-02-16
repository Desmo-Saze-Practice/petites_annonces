<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use App\Repository\TagRepository;
use Twig\Environment;

class KernelControllerSubrscriberSubscriber implements EventSubscriberInterface
{
    private $tagRepository;
    private $twig;

    public function __construct(TagRepository $tagRepository, Environment $twig)
    {
        $this->tagRepository = $tagRepository;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $tags =  $this->tagRepository->findAll();

        $this->twig->addGlobal('global_tags', $tags);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
