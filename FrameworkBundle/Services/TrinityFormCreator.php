<?php

namespace Trinity\FrameworkBundle\Services;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Trinity\Component\Core\Interfaces\EntityInterface;
use Trinity\FrameworkBundle\Utils\Utils;

/**
 * Class TrinityFormCreator
 * @package Trinity\FrameworkBundle\Services
 */
class TrinityFormCreator
{
    /** @var  FormFactoryInterface */
    protected $formFactory;
    /** @var  RouterInterface */
    protected $router;
    /** @var  TranslatorInterface */
    protected $trs;

    /**
     * FormFactory constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param RouterInterface $router
     * @param TranslatorInterface $trs
     */
    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, TranslatorInterface $trs)
    {
        $this->formFactory = $formFactory;
        $this->router      = $router;
        $this->trs         = $trs;
    }

    /**
     * Creates a form to edit entity.
     *
     * @param EntityInterface $entity The entity
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
     *
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createEditForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_update',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Update',
        string $submitButtonClasses = 'button button-success'
    ): FormInterface {
        return $this->createNamedEditForm(
            $entity,
            $entityTypeString,
            $urlPrefix,
            '',
            $routeParameters,
            $formOptions,
            $urlPostfix,
            $submitButtonName,
            $submitButtonLabel,
            $submitButtonClasses
        );
    }

    /**
     * Creates a form to edit entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $entityTypeString
     * @param string $urlPrefix The entity url name
     * @param string $formName
     * @param array $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     *
     * @return FormInterface The form
     *
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createNamedEditForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        string $formName = '',
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_update',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Update',
        string $submitButtonClasses = 'button button-success button-save'
    ): FormInterface {
        $routeParameters['id'] = $entity->getId();
        $submitButtonLabel     =
            $submitButtonLabel === 'Create' ? $this->trs->trans('trinity_framework.form.update') : $submitButtonLabel;

        return $this->createNamedForm(
            $entity,
            $entityTypeString,
            $urlPrefix,
            $formName,
            $routeParameters,
            Utils::mergeArraysDeep(
                [
                    'method' => 'PUT',
                    'attr'   => ['class' => 'edit-form'],
                ],
                $formOptions
            ),
            $urlPostfix,
            $submitButtonName,
            $submitButtonLabel,
            $submitButtonClasses
        );
    }

    /**
     * Creates a form to create entity.
     *
     * @param EntityInterface $entity The entity
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
     *
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createCreateForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_create',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Create',
        string $submitButtonClasses = 'button button-success button-save'
    ): FormInterface {
        // If the input arrays have the same string keys,
        // then the later value for that key will overwrite the previous one
        return $this->createNamedCreateForm(
            $entity,
            $entityTypeString,
            $urlPrefix,
            '',
            $routeParameters,
            $formOptions,
            $urlPostfix,
            $submitButtonName,
            $submitButtonLabel,
            $submitButtonClasses
        );
    }

    /**
     * Creates a form to create entity.
     *
     * @param EntityInterface $entity The entity
     * @param string $entityTypeString
     * @param string $urlPrefix The entity url name
     * @param string $formName Name of form
     * @param string[] $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     *
     * @return FormInterface The form
     *
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createNamedCreateForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        string $formName,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_create',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Create',
        string $submitButtonClasses = 'button button-success button-save'
    ): FormInterface {
        $submitButtonLabel =
            $submitButtonLabel === 'Create' ? $this->trs->trans('trinity_framework.form.create') : $submitButtonLabel;

        return $this->createNamedForm(
            $entity,
            $entityTypeString,
            $urlPrefix,
            $formName,
            $routeParameters,
            Utils::mergeArraysDeep(
                [
                    'method' => 'POST',
                    'attr'   => ['class' => 'new-form'],
                ],
                $formOptions
            ),
            $urlPostfix,
            $submitButtonName,
            $submitButtonLabel,
            $submitButtonClasses
        );
    }

    /**
     * Creates a form to Edit or Create entity
     *
     * @param EntityInterface $entity The entity
     * @param string $entityTypeString
     * @param string $urlPrefix The entity url name
     * @param string $formName Name of form
     * @param string[] $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     *
     * @return FormInterface The form
     *
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    private function createNamedForm(
        $entity,
        string $entityTypeString,
        string $urlPrefix,
        string $formName,
        array $routeParameters,
        array $formOptions,
        string $urlPostfix,
        string $submitButtonName,
        string $submitButtonLabel,
        string $submitButtonClasses
    ): FormInterface {
        $options = Utils::mergeArraysDeep(
            [
                'action' => $this->router->generate($urlPrefix . $urlPostfix, $routeParameters)
            ],
            $formOptions
        );

        $form = null;
        if ($formName === '') {
            $form = $this->formFactory->create(
                $entityTypeString,
                $entity,
                $options
            );
        } else {
            $form = $this->formFactory->createNamed(
                $formName,
                $entityTypeString,
                $entity,
                $options
            );
        }

        $form->add(
            $submitButtonName,
            SubmitType::class,
            [
                'label' => $submitButtonLabel,
                'attr'  => ['class' => $submitButtonClasses, 'autocomplete' => 'off']
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
     *
     * @return FormInterface The form
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createDeleteForm(
        string $urlPrefix,
        int $id,
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_delete',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Delete',
        string $submitButtonClasses = 'button button-danger button-remove',
        string $submitButtonOnClick = "return confirm('Are you sure?')"
    ): FormInterface {
        return $this->createNamedDeleteForm(
            $urlPrefix,
            $id,
            '',
            $routeParameters,
            $formOptions,
            $urlPostfix,
            $submitButtonName,
            $submitButtonLabel,
            $submitButtonClasses,
            $submitButtonOnClick
        );
    }

    /**
     * Creates a form to delete entity by id.
     *
     * @param string $urlPrefix The entity url name
     * @param int $id The entity id
     * @param string $formName
     * @param string[] $routeParameters Array of params required to generate URL
     * @param array $formOptions
     * @param string $urlPostfix
     * @param string $submitButtonName
     * @param string $submitButtonLabel
     * @param string $submitButtonClasses
     * @param string $submitButtonOnClick
     *
     * @return FormInterface The form
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function createNamedDeleteForm(
        string $urlPrefix,
        int $id,
        string $formName = '',
        array $routeParameters = [],
        array $formOptions = [],
        string $urlPostfix = '_delete',
        string $submitButtonName = 'submit',
        string $submitButtonLabel = 'Delete',
        string $submitButtonClasses = 'button button-danger button-remove',
        string $submitButtonOnClick = "return confirm('Are you sure?')"
    ): FormInterface {
        $routeParameters['id'] = $id;

        // If the input arrays have the same string keys, 
        // then the later value for that key will overwrite the previous one
        $options = Utils::mergeArraysDeep(
            [
                'action' => $this->router->generate($urlPrefix . $urlPostfix, $routeParameters),
                'method' => 'DELETE',
                'attr'   => ['class' => 'delete-form'],
            ],
            $formOptions
        );

        $form = null;
        if ($formName === '') {
            $form = $this->formFactory->create(
                'Symfony\Component\Form\Extension\Core\Type\FormType',
                null,
                $options
            );
        } else {
            $form = $this->formFactory->createNamed(
                $formName,
                'Symfony\Component\Form\Extension\Core\Type\FormType',
                null,
                $options
            );
        }

        $form->add(
            $submitButtonName,
            SubmitType::class,
            [
                'label' => $submitButtonLabel,
                'attr'  => [
                    'class'        => $submitButtonClasses,
                    'onClick'      => $submitButtonOnClick,
                    'autocomplete' => 'off'

                ]
            ]
        );

        return $form;
    }
}
