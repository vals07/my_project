<?php

//declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProjectController extends AbstractController
{
    /** @var ProjectRepository $projectRepository */
    private $projectRepository;
    private $em;

    public function __construct(ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $this->projectRepository = $projectRepository;
        $this->em = $em;
    }
    
    #[Route('/projects', name: 'projects_list')]
    public function projects()
    {
        $projects = $this->projectRepository->findBy(
            ['closeDate' => null],
            ['name' => 'ASC']
        );
        return $this->render('projects/index.html.twig', [
           'projects' => $projects
        ]);
    }

    #[Route('/projects/create', name: 'project_create')]
    public function add(Request $request, ValidatorInterface $validator)
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $project->setOpenDate(new \DateTime());
            $errors = $validator->validate($project);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $this->em->persist($project);
            $this->em->flush();

            return $this->redirectToRoute('projects_list');
        }

        return $this->render('projects/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/projects/update/{id}', name: 'project_update')]
    public function edit(Project $project, Request $request, ValidatorInterface $validator)
    {
         $form = $this->createForm(ProjectType::class, $project);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($project);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $this->em->flush();

            return $this->redirectToRoute('projects_list');
         }

         return $this->render('projects/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/projects/delete/{id}', name: 'project_delete')]
    public function delete(Project $project)
    {     
        $project->setCloseDate(new \DateTime());
        $this->em->flush();

        return $this->redirectToRoute('projects_list');
    }
}
?>