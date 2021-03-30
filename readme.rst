Informações para configurar o ambiente do projeto:

1º - Possuir um servidor local (de preferência o XAMPP PHP 7.0) para habilitar um servidor para rodar o projeto PHP. 
2º - Possuir o Mysql Workbench ou qualquer outro gerenciador de banco de dados Mysql.
3º - Criar um schema vazio dentro do seu gerenciador de banco de dados.
4º - Caso tenha o XAMPP, fazer o download do projeto na pasta htdocs que fica dentro da pasta do XAMPP.
5º - Após fazer o download do projeto, ir em application/config/ e será encontrado um arquivo chamado database.php.example. Você irá fazer uma cópia desse arquivo dentro
da pasta, e renomea-lo para database.php. Pode manter o database.php.example na pasta pois ele está referenciado no .gitignore.
6º - No arquivo database.php, configurar o seu banco de dados. (hostname, username, password e database, apenas esses 4 campos).
7º - O padrão de URL do XAMPP é: localhost/{pastaDoProjeto}/{controller}.
8º - Você vai em application/config/config.php e edita na linha 26 a base url, onde você vai trocar 'projetoProgIV' pelo nome da pasta que está o projeto dentro do htdocs.
9º - Após isso, ao acessar localhost/{pastaDoProjeto} o projeto já deve estar funcionando.
10º - Caso ele esteja, acesse: localhost/{pastaDoProjeto}/Doctrine_Tools e clique em 'atualizar banco'. Ao fazer isso, o controller Doctrine_Tools irá criar todas as tabelas
no seu banco de dados que foi configurado previamente.
11º - Assim, o projeto estará em perfeita condições.
12º - O usuário admin é o: 111.111.111-11. Senha: facol123.
 
###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.
