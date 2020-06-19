<?php

namespace MainBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use ScrumBundle\Entity\Projet;

class DefaultController extends Controller
{
    public function rootAction()
    {
        $security = $this->get('security.authorization_checker');

        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('dash');
        }

        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('fos_user_security_login');
    }

    public function indexAction()
    {
        return $this->render('@Main/Default/index.html.twig');
    }
    public function recaptchaAction()
    {
        return $this->render('@Main/Security/recaptchaa.html.twig');
    }
    function captchaverifyAction($recaptcha)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret" => "6LcZA_0UAAAAAFLu0wleQkmNYY5GSdKSxVg7VnZz", "response" => $recaptcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }

        public function indexbackAction()
    {
        return $this->render('@Main/Default/indexback.html.twig');
    }

    public function loginAction()
    {
        return $this->render('@Main/Security/login.html.twig');
    }
    public function registerAction()
    {
        return $this->render('@Main/Registration/register.html.twig');
    }
    public function changeAction()
    {
        return $this->render('@Main/ChangePassword/change_password.html.twig');
    }


    public function dashAction()
    {

        return $this->render('@Scrum/DashboardB.html.twig');
    }
    public function dashBAction(){
        return $this->render('@Scrum/Back/Dashboard.html.twig');
    }
    public function backAction(){
        $p=$this->getDoctrine()->getRepository(Projet::class)->findAll();

        return $this->render('@Scrum/Back/projects.html.twig',array('pp'=> $p));
    }
    public function chartbackAction()
    {
        $em= $this->getDoctrine()->getManager();
        $pieChart = new PieChart();
        $Archive =$em->getRepository('ScrumBundle:Projet')->findBy(['etat'=>0]);
        $Active =$em->getRepository('ScrumBundle:Projet')->findBy(['etat'=>1]);

        $user=$em->getRepository('MainBundle:User')->findAll();

        $sizeAr = count($Archive);
        $sizeAc = count($Active);

        $size = count($user);
        $oldColumnChart = new ColumnChart();
        $oldColumnChart->getData()->setArrayToDataTable(
            [['Project', 'Project'],
                ['Archive',     $sizeAr],
                ['Active',      $sizeAc],

            ]
        );
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Task'],
                ['Archive',     $sizeAr],
                ['Active',      $sizeAc],
            ]
        );
        $pieChart->getOptions()->setTitle('Projects');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#16CABD');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        $oldColumnChart->getOptions()->getLegend()->setPosition('top');
        $oldColumnChart->getOptions()->setWidth(450);
        $oldColumnChart->getOptions()->setHeight(250);

        $newColumnChart = new ColumnChart();
        $newColumnChart->getData()->setArrayToDataTable(
            [
                ['n', 'Member'],
                [ 'Number of members in team', $size]

            ]);
        $newColumnChart->setOptions($oldColumnChart->getOptions());



        return $this->render('@Scrum/Back/chart.html.twig', array(
            'oldColumnChart' => $oldColumnChart,
            'newColumnChart' => $newColumnChart,
            'piechart' => $pieChart

        ));
    }
}
