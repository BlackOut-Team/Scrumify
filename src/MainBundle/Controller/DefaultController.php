<?php

namespace MainBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

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

    public function dashboardAction()
    {
        $em= $this->getDoctrine()->getManager();
        $pieChart = new PieChart();
        $project =$em->getRepository('ProjectApi:Projet')->findAll();
        $user =$em->getRepository('MainBundle:User')->findAll();
        $team =$em->getRepository('TeamBundle:Team')->findAll();

        $sizeP = count($project);
        $sizeU = count($user);
        $sizeT = count($team);

        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'number'],
                ['Project',     $sizeP],
                ['users',      $sizeU],
                ['teams',  $sizeT],

            ]
        );
        $pieChart->getOptions()->setTitle('General informations');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#16CABD');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('@Main/Default/indexBack.html.twig', array('piechart' => $pieChart, 'sizeP'=>$sizeP , 'sizeU'=>$sizeU, 'sizeT'=>$sizeT));
    }
    public function dashAction()
    {
        return $this->render('@Scrum/DashboardB.html.twig');
    }

}
