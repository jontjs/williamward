<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employees;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employees", name="employees")
     */
    public function index()
    { 
        $entityManager = $this->getDoctrine()->getManager();

        $employees = new employees();
        $employees->setFName('William');
        $employees->setlName('Ward');
        $employees->setDOB(\DateTime::createFromFormat('Y-m-d', "1997-10-01"));
        $employees->setEmail('william@tjs.com');

        $entityManager->persist($employees);

        $entityManager->flush();

        return new Response('Employee has been saved under '.$employees->getId());
    }

    /**
     * @Route("/employeesData", name="employees_show")
     */
    public function show(Request $request) {
    {
        $employees = $this->getDoctrine()
            ->getRepository(Employees::class)
            ->findAll();
        }

        return $this->render('employee/data.html.twig', array ('employees' => $employees));
    }
}
