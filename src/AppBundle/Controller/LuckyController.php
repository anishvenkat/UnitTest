<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller; // Template

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number/{count}")
     */
    public function numberAction($count)
    {

              $numbers = array();
              for ($i = 0; $i < $count; $i++) {
              $numbers[] = rand(0, 100);
              }
              $numbersList = implode(',', $numbers);
            //  $html = $this->container->get('templating')->render('lucky/number.html.twig',array('luckyNumberList' => $numbersList));
              return $this->render('lucky/number.html.twig',array('luckyNumberList' => $numbersList));
  //            return new Response($html);
    }
    /**
     * @Route("/wtf/man")
     */

    public function apiAction()
    {
      $data = array(
              'lucky_number' => rand(0, 100),
              );

              return new Response(
                json_encode($data),
                200,
                array('Content-Type' => 'application/json')
              );
    }
    /**
     * @Route("/allo/man")
     */
     public function dAction()
     {
       $data = array(
               'lucky_number' => rand(0, 100),
               );

               return new JsonResponse($data);
     }
}
?>
