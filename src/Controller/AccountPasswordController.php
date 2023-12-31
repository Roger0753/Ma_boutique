<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    #[Route('/compte/modifier-mon-mot-de-passe', name: 'app_account_password')]
    public function index(): Response
    {   
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);


        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
