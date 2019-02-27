<?php

namespace App\Controller;

use App\Entity\Employees;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class mainController extends Controller
{
    /**
     * @Route("/index")
     */
    public function index()
    {
        return $this->render('employee/index.html.twig');
    }

    /**
     * @Route("/form", name="new_employee")
     * Method({"GET", "POST"})
     */
    public function new(Request $request)
    {
        $article = new Employees();
        $form = $this->createFormBuilder($article)
            ->add('fName', TextType::class, array(
                'required' => true,
                'label' => 'First Name:',
                'attr' => array('class' => 'form-control')))
            ->add('lName', TextType::class, array(
                'required' => true,
                'label' => 'Last Name:',
                'attr' => array('class' => 'form-control')
            ))
            ->add('dob', DateType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date of Birth:',
                'attr' => array('class' => 'form-control')
            ))
            ->add('email', EmailType::class, array(
                'required' => true,
                'label' => 'Email Address:',
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'SUBMIT',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        //Process of sending Data
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Successfully added employee data!'
            );

            return $this->redirectToRoute('new_employee');
        }
        return $this->render('employee/form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
