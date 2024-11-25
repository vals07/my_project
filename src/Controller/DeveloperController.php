<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Developer;
use App\Form\DeveloperType;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class DeveloperController extends AbstractController
{
    /** @var DeveloperRepository $developerRepository */
    private $developerRepository;
    private $em;

    public function __construct(DeveloperRepository $developerRepository, EntityManagerInterface $em)
    {
        $this->developerRepository = $developerRepository;
        $this->em = $em;
    }
    
    #[Route('/developers', name: 'developers_list')]
    public function developers()
    {
        $developers = $this->developerRepository->findBy(
            ['fireDate' => null],
            ['fullName' => 'ASC']
        );

        return $this->render('developers/index.html.twig', [
           'developers' => $developers
        ]);
    }

    #[Route('/developers/create', name: 'developer_create')]
    public function addDeveloper(Request $request, ValidatorInterface $validator, LoggerInterface $logger)
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($developer);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $this->em->persist($developer);
            $this->em->flush();
            $logger->info("DEVELOPER add " . $developer);
            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developers/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/developers/update/{id}', name: 'developer_update')]
    public function edit(Developer $developer, Request $request, ValidatorInterface $validator)
    {
         $form = $this->createForm(DeveloperType::class, $developer);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $errors = $validator->validate($developer);
            if (count($errors) > 0) {
                return $this->render('validation.html.twig', [
                    'errors' => $errors,
                ]);
            }
            $this->em->flush();

            return $this->redirectToRoute('developers_list');
         }

         return $this->render('developers/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/developers/delete/{id}', name: 'developer_delete')]
    public function delete(Developer $developer)
    {     
        $developer->setFireDate(new \DateTime());
        $this->em->flush();

        return $this->redirectToRoute('developers_list');
    }
}
?>