<?php

namespace App\EventSubscriber;

use App\Repository\TagRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Twig\Environment;

class KernelControllerSubscriber implements EventSubscriberInterface
{
    private $tagRepository;
    private $twig;

    public function __construct(
        TagRepository $tagRepository, 
        Environment $twig
    )
    {
        $this->tagRepository = $tagRepository;
        $this->twig = $twig;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $tags = $this->tagRepository->findAll();
        // envoyer les tags à Twig
        $this->twig->addGlobal('global_tags', $tags);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}
