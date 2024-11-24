<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Developer;
use App\Form\DeveloperType;
use App\Repository\DeveloperRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormError; 

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
    public function addDeveloper(Request $request)
    {
        $developer = new Developer();
        $form = $this->createForm(DeveloperType::class, $developer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && empty($form['email']->getData())) {
            $form->addError(new FormError('Поле должно быть заполнено'));
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $developer->setHireDate(new \DateTime());
            $this->em->persist($developer);
            $this->em->flush();

            return $this->redirectToRoute('developers_list');
        }

        return $this->render('developers/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/developers/update/{id}', name: 'developer_update')]
    public function edit(Developer $developer, Request $request)
    {
         $form = $this->createForm(DeveloperType::class, $developer);
         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
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