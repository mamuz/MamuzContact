<?php

namespace MamuzContact\Controller;

use MamuzContact\Feature\CommandInterface;
use Zend\Form\FormInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface;
use Zend\View\Model\ModelInterface;
use Zend\View\Model\ViewModel;

class CommandController extends AbstractActionController
{
    /** @var CommandInterface */
    private $commandService;

    /** @var FormInterface */
    private $contactForm;

    /** @var ModelInterface */
    private $viewModel;

    /**
     * @param CommandInterface $commandService
     * @param FormInterface    $contactForm
     */
    public function __construct(
        CommandInterface $commandService,
        FormInterface $contactForm
    ) {
        $this->commandService = $commandService;
        $this->contactForm = $contactForm;
        $this->viewModel = new ViewModel(array('form' => $this->contactForm));
    }

    /**
     * Persist contact entity
     *
     * @return ModelInterface|ResponseInterface
     */
    public function createAction()
    {
        /** @var \Zend\Http\PhpEnvironment\Request $request */
        $request = $this->getRequest();
        $prg = $this->prg($request->getRequestUri(), true);
        if ($prg instanceof ResponseInterface) {
            return $prg;
        } elseif ($prg === false) {
            return $this->viewModel;
        }

        if ($this->contactForm->setData($prg)->isValid()) {
            /** @var \MamuzContact\Entity\Contact $contact */
            $contact = $this->contactForm->getData();
            $this->commandService->persist($contact);
            $this->viewModel->setVariable('contact', $contact);
        }

        return $this->viewModel;
    }
}
