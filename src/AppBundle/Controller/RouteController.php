<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class RouteController extends Controller
{


  public function xmlConfAction($WTF=null) {

      return new Response('This is fucking awesome==>'.$WTF, Response::HTTP_OK);

  }

    private function randAlpha(){

      $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789!@#$%^&*()'); // and any other characters
      shuffle($seed);

      for($i=0;$i<10;$i++) {
                $rand[$i] = array();
                $str ="";
                foreach (array_rand($seed, 10) as $k)  $str.= $seed[$k];
                $rand[$i]=$str;
      }

      return $rand;


    }
    /**
    * @Route("/blog/{slug}", name="blog_show",defaults={"slug" = 1},requirements={"slug": "\d+"})
    * @Method("GET");
    */
    public function showAction(Request $request,$slug)
    {
        // echo $slug;
        echo $request->server->get('HTTP_HOST');
        self::debug($request,false);

        $format = $request->getRequestFormat();

        echo $format;

        return new Response('Slug '.$slug, Response::HTTP_OK);
    }

    /**
    * @Route("/blog/{slug}")
    */
    public function blogAction(Request $request,$slug)
    {


      exit();
      return new Response('Default Slug '.$slug, Response::HTTP_OK);
    }


    public function ListURL($slug)
    {

      return $this->render('sub.html.twig',array('slug' => $slug));

      // return new Response('Default Slug '.$slug, Response::HTTP_OK);
    }

    /**
    * @Route("/tony",name="tony") //Name use for redirect
    */

    public function tonyAction(Request $request) {
      $name = $request->query->get('name')      ?   $request->query->get('name') : $request->attributes->get('name');

      echo $request->server->get('HTTP_HOST');


      
  //  self::debug(json_decode($name),false);



  //    echo $session->get('mysession');
  //    $router = $this->get('router');
  //    self::debug($router,false);

      $page = $request->query->get('page', 2);
      echo $page;

      $url = $this->container->get('router')->generate('blog_show',array('slug' => '5'));
      echo $url;

  //    $this->debug($request,false);
      $data = array(
              'lucky_number' => rand(0, 100),
              );
        return $this->render('tony.html.twig',array('luckyNumberList' => $data['lucky_number']));
    }


    /**
    * @Route("/redirect")
    */
    public function redirectAction()
    {
      $response = $this->forward('AppBundle:Tony:tony', array('name' => json_encode(self::randAlpha()),'color' => 'green',));
      return $response;

      return $this->redirectToRoute('tony', array('name' => json_encode(self::randAlpha())), 301);

    }
    /**
    * @Route("/resp/{name}")
    */
    public function respAction($name)
    {
       // return new Response('Hello '.$name, Response::HTTP_OK);
       $name=self::randAlpha();
       dump($name);
       $response = new Response(json_encode(array('name' => $name)));

    //   if ($response->isInvalid()) echo 'shit'; else echo 'Wh';
       $response->headers->set('Content-Type', 'application/json');
       return $response;

    }


    /**
    * @Route("/hello/{name2}/{name}")
    */
    public function indexAction($name2,$name)
    {
       $wtf[]=1;
       $this->debug($wtf,false);
       $wtf[1]="Mouahahahaha";
       return new Response('<html><body>Hello '.$this->debug($wtf).'<br>'.$name.'<br>'.$name2.'!</body></html>');
    }

    public function debug($DebugME,$ob=true)
    {
     ($ob) ? ob_start() : null ;
      echo "<pre>";
      print_r($DebugME);
      echo "</pre>";
      return ($ob) ? ob_get_clean() : null;
   }

}
?>
