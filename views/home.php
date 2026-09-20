
<?php
    use app\core\Application;
?>

<?php

$success = Application::$app->session->getAuth('user');

?>

<h1>Welcome to Book Shop Information System!</h1>
<h3>We have a large selection of books,<br/> Take a look and Get the best books that will make your bookstore richer.</h3>