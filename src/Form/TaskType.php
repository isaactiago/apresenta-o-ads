<?php

namespace App\Form;

use App\Dto\TaskInput;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<TaskInput>
 */
class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Título',
                'attr' => ['maxlength' => 120, 'placeholder' => 'Ex.: Estudar Symfony'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Descrição (opcional)',
                'required' => false,
                'attr' => ['rows' => 3, 'placeholder' => 'Detalhes da tarefa'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TaskInput::class,
            'csrf_token_id' => 'task_form',
        ]);
    }
}
