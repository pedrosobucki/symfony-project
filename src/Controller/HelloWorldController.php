<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HelloWorldController {

  /**
   * @Route("/hello")
   */
  public function helloWorld(Request $request) : Response {

    $pathInfo = $request->getPathInfo();
    $query = $request->query->all();

    return new JsonResponse([
      'msg' => 'hello world!',
      'pathInfo' => $pathInfo,
      'query' => $query
    ]);
  }

}

?>