<?php

namespace MamuzContact\Form;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder;
use MamuzContact\Entity\Contact;
use Zend\Form\FormInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CreateFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @return FormInterface
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof ServiceLocatorAwareInterface) {
            $serviceLocator = $serviceLocator->getServiceLocator();
        }

        $form = $this->buildForm($serviceLocator);

        $config = $serviceLocator->get('Config');
        if (isset($config['captcha'])) {
            $form->add($config['captcha']);
        }

        $this->addCsrfTo($form);
        $this->addSubmitTo($form);

        return $form;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return FormInterface
     */
    private function buildForm(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Doctrine\Common\Persistence\ObjectManager $entityManager */
        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $entity = new Contact;

        $builder = new AnnotationBuilder($entityManager);
        $form = $builder->createForm($entity);
        $form->setHydrator(new DoctrineHydrator($entityManager));
        $form->bind($entity);

        return $form;
    }

    /**
     * @param FormInterface $form
     * @return void
     */
    private function addCsrfTo(FormInterface $form)
    {
        $form->add(
            array(
                'type'    => 'Zend\Form\Element\Csrf',
                'name'    => 'csrf',
                'options' => array(
                    'csrf_options' => array(
                        'timeout' => 6000 // 10 minutes
                    )
                )
            )
        );
    }

    /**
     * @param FormInterface $form
     * @return void
     */
    private function addSubmitTo(FormInterface $form)
    {
        $form->add(
            array(
                'type'       => 'Submit',
                'name'       => 'submit',
                'attributes' => array(
                    'value' => 'send',
                    'class' => 'btn btn-success btn-block',
                ),
            )
        );
    }
}
