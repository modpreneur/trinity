<?php

namespace Trinity\FrameworkBundle\Services;


use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
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
     * @param object $entity The entity
     * @param string $entityTypeString
     * @param string $urlPrefix The entity url name
     * @param array $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     *
     * @return FormInterface The form
     */
    public function createEditForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = "_update",
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Edit",
        string $submitButtonClasses = "button edit"

    ):FormInterface
    {
        $routeParameters['id'] = $entity->getId();

        // If the input arrays have the same string keys, then the later value for that key will overwrite the previous one
        $options = array_merge(
            [
                'action' => $this->router->generate($urlPrefix.$urlPostfix, $routeParameters),
                'method' => 'PUT',
                'attr' => ['class' => "edit-form"],
            ],
            $formOptions
        );

        $form = $this->formFactory->create(
            $entityTypeString,
            $entity,
            $options
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
     * @param object $entity The entity
     * @param string $entityTypeString
     * @param string $urlPrefix The entity url name
     * @param string[] $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     *
     * @return FormInterface The form
     */
    public function createCreateForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = "_create",
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Edit",
        string $submitButtonClasses = "button edit"
    ):FormInterface
    {

        // If the input arrays have the same string keys, then the later value for that key will overwrite the previous one
        $options = array_merge(
            [
                'action' => $this->router->generate($urlPrefix.$urlPostfix, $routeParameters),
                'method' => 'POST',
                'attr' => ['class' => "new-form"],
            ],
            $formOptions
        );

        $form = $this->formFactory->create(
            $entityTypeString,
            $entity,
            $options
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
     * @param string $urlPrefix The entity url name
     * @param int $id The entity id
     * @param string[] $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     * @param string $submitButtonOnClick
     * @return FormInterface The form
     */
    public function createDeleteForm(
        string $urlPrefix,
        int $id,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = "_delete",
        string $submitButtonName = "submit",
        string $submitButtonLabel = "Delete",
        string $submitButtonClasses = "button delete",
        string $submitButtonOnClick = "return confirm('Are you sure?')"
    ):FormInterface
    {
        $routeParameters['id'] = $id;

        // If the input arrays have the same string keys, then the later value for that key will overwrite the previous one
        $options = array_merge(
            [
                'action' => $this->router->generate($urlPrefix.$urlPostfix, $routeParameters),
                'method' => 'DELETE',
                'attr' => ['class' => "delete-form"],
            ],
            $formOptions
        );

        $form = $this->formFactory->create(
            'Symfony\Component\Form\Extension\Core\Type\FormType',
            null,
            $options
        );

        $form->add(
            $submitButtonName,
            SubmitType::class,
            [
                'label' => $submitButtonLabel,
                'attr' => [
                    'class' => $submitButtonClasses,
                    'onClick' => $submitButtonOnClick
                ]
            ]
        );

        return $form;
    }
}
