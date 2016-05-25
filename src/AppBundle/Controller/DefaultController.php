<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\Category;

class DefaultController extends Controller
{

    protected $start;
    protected $end;
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

        return $this->render('default/index.html.twig', ['base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),'Product_id'=>$this->createProduct()]);
    }

    /**
     * @Route("/PG/{cat}", name="PG")
     */

    public function createPGAction($cat)
        {
            $category = new Category();
            $category->setName($cat);

            $product = new Product();
            $product->setName('Keyboard');
            $product->setPrice(19.99);
            $product->setDescription('Ergonomic and stylish!');
            // relate this product to the category
            $product->setCategory($category);

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->persist($product);
            $em->flush();

            return new Response(
                'Saved new product with id: '.$product->getId()
                .' and new category with id: '.$category->getId()
            );
        }
        /**
         * @Route("/PGA/{id}", name="PGA")
         */
        public function showPGAction($id) {
        $product = $this->getDoctrine()
              ->getRepository('AppBundle:Product')
              ->find($id);


          $categoryName = $product->getCategory()->getName();
          echo $categoryName;

        //  dump($product);

          exit();


        }

    private function createProduct()
    {

        $this->start = $this->microtime_float();


        $em = $this->getDoctrine()->getManager();
        for ($i=0;$i<10;$i++) {
          $product = new Product();
          $product->setName('Keyboard'.$i);
          $product->setPrice(rand(0,$i).'99');
          $product->setDescription('Ergonomic and stylish!'.$i);

          $em->persist($product); // tells Doctrine you want to (eventually) save the Product (no queries yet)

          file_put_contents('Test.log',$i."\n",8);

        }
        $em->flush();
        $this->end   = $this->microtime_float();

        // actually executes the queries (i.e. the INSERT query)


        echo   $this->Displaytime($this->start,$this->end);
        return $product->getId();
        // return new Response('Saved new product with id '.$product->getId());
    }
    private function updateProduct($id)
    {

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository('AppBundle:Product')->find($id);

       if (!$product) {
           throw $this->createNotFoundException(
               'No product found for id '.$id
           );
       }
       /* Update */
       $product->setPrice(1000);

       /* Del the next ID */
       $product = $em->getRepository('AppBundle:Product')->find($id++);
       // Del next Product
       $em->remove($product);

       $em->flush();

    }

    private function delProduct($id)
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return $product->getId();
        // return new Response('Saved new product with id '.$product->getId());
    }
    /**
     * @Route("/show/{id}", name="show")
     */
    public function showAction($id)
    {
      $this->updateProduct($id);

      $product = $this->getDoctrine()
             ->getRepository('AppBundle:Product')
             ->findAll();
             // ->findOneBy(array('name' => 'Keyboard0', 'price' => 99.00));
/*
             $product = $repository->findOneBy(
    array('name' => 'Keyboard', 'price' => 19.99)
);
*/
         if (!$product) {
             throw $this->createNotFoundException(
                 'No product found for id '.$id
             );
         }

      return $this->render('product.html.twig', ['product' => $product]);

    }
    /**
     * @Route("/show/", name="showAll")
     */
    public function showAllAction()
    {


      $em = $this->getDoctrine()->getManager();

      $product = $em->getRepository('AppBundle:Product')
                ->findAllOrderedByName();
                /*
      $query = $em->createQuery(
                                'SELECT p
                                FROM AppBundle:Product p
                                WHERE p.price > :price
                                ORDER BY p.price ASC'
                                )->setParameter('price', '200');

       $product = $query->getResult();
       // $product = $query->setMaxResults(1)->getOneOrNullResult();
*/

         if (!$product) {
             throw $this->createNotFoundException(
                 'No product found for id '.$id
             );
         }

      return $this->render('product.html.twig', ['product' => $product]);

    }

    private function microtime_float() {
      list ($msec, $sec) = explode(' ', microtime());
      $microtime = (float)$msec + (float)$sec;
      return $microtime;
  }
  private function Displaytime($start,$end) {

      $total = round($end - $start, 3);
      $heure = intval(abs($total / 3600));
      $total = $total - ($heure * 3600);
      $minute = intval(abs($total / 60));
      $total = $total - ($minute * 60);
      $seconde = $total;
      return "Script Execution Time: $heure H : $minute min : $seconde sec";

  }


}
