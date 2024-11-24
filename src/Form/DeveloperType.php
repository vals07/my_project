<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Developer;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;


class DeveloperType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'ФИО'
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Дата рождения'
            ])
            ->add('position', TextType::class, [
                'label' => 'Должность'
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => false,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Контактный телефон'
            ])
            ->add('hireDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Дата приема на работу'
            ])
            ->add('projects', EntityType::class, [
                'label' => 'Проекты разработчика',
                'class' => Project::class,
                'query_builder' => function (ProjectRepository $pr): QueryBuilder {
                    return $pr->createQueryBuilder('project')
                        ->where('project.closeDate is null')
                        ->orderBy('project.name', 'ASC');
                    },
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Developer::class,
        ]);
    }
}
