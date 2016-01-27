<?php

namespace Trinity\FrameworkBundle\Services;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;

class TrinityFormCreator
{
    /** @var  FormFactoryInterface */
    protected $formFactory;

    /** @var  RouterInterface */
    protected $router;

    /**
     * FormFactory constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     */
    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
    }


    /**
     * Creates a form to edit entity.
     *
     * @param object            $entity             The entity
     * @param FormTypeInterface $entityType         The entity type object
     * @param string            $urlPrefix          The entity url name
     * @param array             $routeParameters    Array of params required to generate URL
     * @param string            $urlPostfix
     * @param string            $formCssClasses
     * @param string            $submitButtonName
     * @param string            $submitButtonLabel
     * @param string            $submitButtonClasses
     *
     * @return FormInterface The form
     * @internal param string $formCssClass
     */
    public function createEditForm(
        $entity,
        FormTypeInterface $entityType,
        string $urlPrefix,
        array $routeParameters = [],
        string $urlPostfix = "_update",
        string $formCssClasses = 'edit-form',
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Edit",
        string $submitButtonClasses = "button edit"

    ):FormInterface
    {
        $routeParameters['id'] = $entity->getId();

        $form = $this->formFactory->create(
            get_class($entityType),
            $entity,
            [
                'action' => $this->router->generate($urlPrefix.$urlPostfix, $routeParameters),
                'method' => 'PUT',
                'attr' => ['class' => $formCssClasses],
            ]
        );

        $form->add(
            $submitButtonName,
            SubmitType::class,
            [
                'label' => $submitButtonLabel,
                'attr' => ['class' => $submitButtonClasses]
            ]

        );

        return $form;
    }

    /**
     * Creates a form to create entity.
     *
     * @param object            $entity              The entity
     * @param FormTypeInterface $entityType          The entity type object
     * @param string            $urlPrefix           The entity url name
     * @param string[]          $routeParameters     Array of params required to generate URL
     * @param string            $urlPostfix
     * @param string            $formCssClasses
     * @param string            $submitButtonName
     * @param string            $submitButtonLabel
     * @param string            $submitButtonClasses
     *
     * @return FormInterface The form
     */
    public function createCreateForm(
        $entity,
        FormTypeInterface $entityType,
        string $urlPrefix,
        array $routeParameters = [],
        string $urlPostfix = "_create",
        string $formCssClasses = 'edit-form',
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Edit",
        string $submitButtonClasses = "button edit"
    ):FormInterface
    {
        $form = $this->formFactory->create(
            get_class($entityType),
            $entity,
            [
                'action' => $this->router->generate($urlPrefix.$urlPostfix, $routeParameters),
                'method' => 'POST',
                'attr' => ['class' => $formCssClasses],
            ]
        );

        $form->add(
            $submitButtonName,
            SubmitType::class,
            [
                'label' => $submitButtonLabel,
                'attr' => ['class' => $submitButtonClasses]
            ]

        );

        return $form;
    }

    /**
     * Creates a form to delete entity by id.
     *
     * @param string    $urlPrefix       The entity url name
     * @param int       $id              The entity id
     * @param string[]  $routeParameters Array of params required to generate URL
     * @param string    $urlPostfix
     * @param string    $formCssClasses
     * @param string    $submitButtonName
     * @param string    $submitButtonLabel
     * @param string    $submitButtonClasses
     * @param string    $submitButtonOnClick
     *
     * @return FormInterface The form
     */
    public function createDeleteForm(
        string $urlPrefix,
        int $id,
        array $routeParameters = [],
        string $urlPostfix = "_delete",
        string $formCssClasses = 'delete-form',
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Delete",
        string $submitButtonClasses = "button delete",
        string $submitButtonOnClick = "return confirm('Are you sure?')"
    ):FormInterface
    {
        $routeParameters['id'] = $id;

        return $this->formFactory->createBuilder(null, ['attr' => ['class' => $formCssClasses]])
            ->setAction(
                $this->router->generate($urlPrefix.$urlPostfix, $routeParameters)
            )
            ->setMethod(
                'DELETE'
            )
            ->add(
                $submitButtonName,
                SubmitType::class,
                [
                    'label' => $submitButtonLabel,
                    'attr' => [
                        'class' => $submitButtonClasses,
                        'onclick' => $submitButtonOnClick,
                    ],
                ]
            )->getForm();
    }
}
