NYC Planning Application Development Code Challenge
Employees Management Application
========================

Based on the "[Symfony Demo Application][1]", and using [EasyAdminBundle][2].

After running normal installation procedure, you must edit /vendor/easycorp/easyadmin-bundle/src/Controller/AdminControllerTrait.php and replace the entire contents of newAction() with "return $this->redirectToRoute('create_user');"


[1]: https://github.com/symfony/demo
[2]: https://github.com/EasyCorp/EasyAdminBundle
