<?php
    date_default_timezone_set('America/Los_Angeles');

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app['debug']=true;

    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/stylists", function() use($app) {
        $new_stylist = new Stylist($_POST['stylist_last_name'], $_POST['stylist_first_name'], $_POST['specialty']);
        $validated = false;
        $validated = $new_stylist->save();
        if($validated){
            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
        } else {
            return $app['twig']->render('invalid.html.twig', array('stylists' => Stylist::getAll()));
        };
    });

    $app->get("/stylists/{id}", function($id) use ($app) {
        return $app['twig']->render('stylist.html.twig', array('stylist' =>Stylist::findById($id)));
    });

    return $app;
?>
