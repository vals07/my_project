<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Project;
use App\Repository\DeveloperRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\QueryBuilder;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название'
            ])
            ->add('client', TextType::class, [
                'label' => 'Заказчик'
            ])
            ->add('openDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Дата открытия проекта'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
