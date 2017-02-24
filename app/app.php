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

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/stylists", function() use($app) {
        $new_stylist = new Stylist($_POST['stylist_last_name'], $_POST['stylist_first_name'], $_POST['specialty']);
        $successful_creation = false;
        $successful_creation = $new_stylist->save();
        if($successful_creation){
            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
        } else {
            return $app['twig']->render('invalid.html.twig', array('stylists' => Stylist::getAll()));
        };
    });

    $app->get("/stylist/{id}", function($id) use ($app) {
        return $app['twig']->render('stylist.html.twig', array('stylist' =>Stylist::findById($id), 'clients' => Client::findByStylistId($id)));
    });

    $app->patch("/updatestylist", function() use ($app) {
        $updatable_stylist = Stylist::findById($_POST['id']);
        $successful_update = false;
        $successful_update = $updatable_stylist->update($_POST['stylist_last_name'], $_POST['stylist_first_name'], $_POST['specialty']);
        if($successful_update)
        {
            return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
        } else {
            return $app['twig']->render('invalid.html.twig', array('stylists' => Stylist::getAll()));
        }
    });

    $app->delete("/delete_stylist/{id}", function($id) use ($app) {
        $deletable_stylist = Stylist::findById($id);
        $deletable_clients = Client::findByStylistId($id);
        $deletable_stylist->delete();
        foreach($deletable_clients as $deletable_client)
        {
            $deletable_client->delete();
        }
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/addclient", function() use ($app) {
        $new_client = new Client($_POST['client_last_name'], $_POST['client_first_name'], $_POST['stylist_id']);
        $successful_add = false;
        $successful_add = $new_client->save();
        if ($successful_add)
        {
            return $app['twig']->render('stylist.html.twig', array('stylist' =>Stylist::findById($_POST['stylist_id']), 'clients' => Client::findByStylistId($_POST['stylist_id'])));
        } else {
            return $app['twig']->render('invalid.html.twig', array('stylists' => Stylist::getAll()));
        }
    });

    $app->get("/client/{id}", function($id) use ($app) {
        return $app['twig']->render('client.html.twig', array('client' =>Client::findById($id), 'stylists' => Stylist::getAll()));
    });

    $app->patch("/updateclient", function() use ($app) {
        $updatable_client = Client::findById($_POST['id']);
        $successful_update = false;
        $successful_update = $updatable_client->update($_POST['client_last_name'], $_POST['client_first_name'], $_POST['stylist_id']);
        if ($successful_update)
        {
            return $app['twig']->render('stylist.html.twig', array('stylist' =>Stylist::findById($_POST['stylist_id']), 'clients' => Client::findByStylistId($_POST['stylist_id'])));
        } else {
            return $app['twig']->render('invalid.html.twig', array('stylists' => Stylist::getAll()));
        }
    });

    $app->delete("/delete_client/{id}", function($id) use ($app) {
        $deletable_client = Client::findById($id);
        $stylist_id = $deletable_client->getStylistId();
        $deletable_client->delete();
        return $app['twig']->render('stylist.html.twig', array('stylist' =>Stylist::findById($stylist_id), 'clients' => Client::findByStylistId($stylist_id)));
    });

    return $app;
?>
