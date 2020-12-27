<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="alert")
     */
    public function alertAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/alert.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/homepage", name="homepage")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        if ($error != null) {
            $this->get('session')->getFlashBag()->add('danger', 'Chybné přihlašovací jméno nebo heslo!');
        }
        return $this->render('default/index.html.twig', array(
            'last_username' => $lastUsername
        ));
    }


    /**
     * @Route("/onas", name="onas")
     */
    public function onasAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/onas.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/kontakt", name="kontakt")
     */
    public function kontaktAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/kontakt.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/pokyny", name="pokyny")
     */
    public function pokynyAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/pokyny.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/sablona", name="sablona")
     **/
    public function sablonaAction(){

        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/files/';
        $filename = "Šablona LOGOS POLYTECHNIKOS.docx";

        return new BinaryFileResponse($publicResourcesFolderPath.$filename);
    }

    /**
     * @Route("/recenzni_rizeni", name="recenzni_rizeni")
     **/
    public function recenzni_rizeniAction(){

        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/files/';
        $filename = "Recenzní řízení časopisu LOGOS POLYTECHNIKOS.pdf";

        return new BinaryFileResponse($publicResourcesFolderPath.$filename);
    }
}
