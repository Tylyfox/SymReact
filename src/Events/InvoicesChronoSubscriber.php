<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class InvoicesChronoSubscriber implements EventSubscriberInterface {

    private $security;
    private $repository;

    public function __construct (Security $security, InvoiceRepository $repository) {
        $this->security = $security;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
      return [
          KernelEvents::VIEW => ['setChronoForInvoice', EventPriorities::PRE_VALIDATE]
      ];
    }

    public function setChronoForInvoice(ViewEvent $event) {
        $invoice = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($invoice instanceof Invoice &&  $method === "POST") {
        // 1. j'ai besoin de trouver l'utilisateur actuellement connecté
        // 2. j'ai besoin du repository des factures (InvoiceRepository)
            // 3. choper la dernière facture qui a été insérée, et choper son chrono
            // 4. dans cette nouvelle facture on donne le dernier chrono + 1

            $nextChrono = $this->repository->findNextChrono($this->security->getUser());
            $invoice->setChrono($nextChrono);

            if(empty($invoice->getSentAt()))
            {
                $invoice->setSentAt(new \DateTime());
            }

    }

    }



}
