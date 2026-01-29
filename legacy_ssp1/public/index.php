<?php
// public/index.php
require_once __DIR__ . '/../config/db.php';

$route = $_GET['route'] ?? 'home';

function controllerAction($controllerClass, $method) {
    require_once __DIR__ . "/../app/Controllers/{$controllerClass}.php";
    $c = new $controllerClass();
    return $c->$method();
}

switch($route) {
    case 'home':
        controllerAction('HomeController','index');
        break;
    case 'products':
        controllerAction('ProductController','index');
        break;
    case 'product.detail':
        require_once __DIR__ . '/../app/Controllers/ProductController.php';
        $controller = new ProductController();
        $controller->detail();
        break;

    case 'food':
        require_once __DIR__ . '/../app/Controllers/CategoryController.php';
        (new CategoryController())->food();
        break;
    case 'toys':
        require_once __DIR__ . '/../app/Controllers/CategoryController.php';
        (new CategoryController())->toys();
        break;
    case 'grooming':
        require_once __DIR__ . '/../app/Controllers/CategoryController.php';
        (new CategoryController())->grooming();
        break;
    case 'accessories':
        require_once __DIR__ . '/../app/Controllers/CategoryController.php';
        (new CategoryController())->accessories();
        break;
   
    case 'login':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') (new AuthController())->login();
        else (new AuthController())->showLogin();
        break;
    case 'register':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') (new AuthController())->register();
        else (new AuthController())->showRegister();
        break;
    case 'logout':
        require_once __DIR__ . '/../app/Controllers/AuthController.php';
        (new AuthController())->logout();
        break;
    case 'cart.add':
        require_once __DIR__ . '/../app/Controllers/CartController.php';
        (new CartController())->add();
        break;
    case 'cart':
        require_once __DIR__ . '/../app/Controllers/CartController.php';
        (new CartController())->view();
        break;
    case 'cart.remove':
        require_once __DIR__ . '/../app/Controllers/CartController.php';
        (new CartController())->remove();
        break;
    case 'cart.count':
        require_once 'app/Controllers/CartController.php';
        (new CartController)->count();
        break;
    case 'checkout':
        require_once __DIR__ . '/../app/Controllers/CheckoutController.php';
        (new CheckoutController())->index();
        break;
    case 'checkout.submit':
        require_once __DIR__ . '/../app/Controllers/CheckoutController.php';
        (new CheckoutController())->submit();
        break;
    case 'checkout.success':
        require __DIR__ . '/../app/Views/checkout_success.php';
        break;
    case 'admin.dashboard':
        controllerAction('AdminController','dashboard');
        break;
    case 'account':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->account();
        break;
    case 'account.edit':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->edit();
        break;

    case 'account.update':
        require_once __DIR__ . '/../app/Controllers/UserController.php';
        (new UserController())->update();
        break;
    case 'admin.products':
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->products(); // You need to create this method
        break;

    case 'admin.categories':
        require_once __DIR__ . '/../app/Controllers/AdminController.php';
        $controller = new AdminController();
        $controller->categories(); // <-- This method should exist in AdminController
        break;


    case 'admin.orders':
        require_once __DIR__ . '/../app/Controllers/OrderController.php';
        $controller = new OrderController();
        $controller->index(); // You need this controller/method
        break;
    case 'admin.customers':
        require_once __DIR__ . '/../app/Controllers/CustomerController.php';
        $controller = new CustomerController();
        $controller->index(); // You need this controller/method
        break;

    case 'admin.analytics':
        require_once __DIR__ . '/../app/Controllers/AnalyticsController.php';
        $controller = new AnalyticsController();
        $controller->index(); // You need this controller/method
        break;
        
    case 'admin.settings':
        require_once __DIR__ . '/../app/Controllers/SettingsController.php';
        $controller = new SettingsController();
        $controller->index(); // You need this controller/method
        break;

    case 'admin.product.create':
        controllerAction('ProductController','createForm');
        break;
    case 'admin.product.store':
        controllerAction('ProductController','store');
        break;
    case 'admin.product.edit':
        controllerAction('ProductController','editForm');
        break;
    case 'admin.product.update':
        controllerAction('ProductController','update');
        break;
    case 'admin.product.delete':
        controllerAction('ProductController','destroy');
        break;
    case 'admin.categories':
        controllerAction('AdminController', 'categories');
        break;
    case 'admin.categories.create':
        controllerAction('CategoryController', 'categoryCreateForm');
        break;
    case 'admin.categories.store':
        controllerAction('CategoryController', 'categoryStore');
        break;
    case 'admin.categories.edit':
        controllerAction('CategoryController', 'categoryEditForm');
        break;
    case 'admin.categories.update':
        controllerAction('CategoryController', 'categoryUpdate');
        break;
    case 'admin.categories.delete':
        controllerAction('CategoryController', 'categoryDestroy');
        break;
    default:
        echo "Unknown route: ". htmlspecialchars($route);
        break;
}
