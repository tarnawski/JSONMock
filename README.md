JSONMock-beckend
====================

A Symfony project created on January 2016

<h2>Short description</h2>
The application is designed to mock JSON response.
Mock your JSON responses and test your REST API!

It's based on a few symfony's bundles:

* FOSRestBundle
* SerializerBundle
* ApiDocBundle

And development tools:

* Behat
* Codesniffer
* Vagrant
* Ansible
* Jenkins 

###Links:

* Url to frontend application repository based on this application
`https://github.com/tarnawski/JSONMock-frontend`

Rest API documentation endpoint: `/doc/api`
 
###Getting started

In order to set up this application you need clone this repo:

```git clone https://github.com/tarnawski/JSONMock-backend.git```

And you have to install dependencies:

```cd JSONStorage-backend```

```composer install```

Run Vagrant with prepared environment:

```cd vagrant && vagrant up ```


When the process is complete, get into the machine:
```
vagrant ssh
cd /var/www/JSONMock/
```

Creating schema and loading fixtures:
```
php app/console doctrine:schema:create 
php app/console doctrine:fixtures:load
```  


Add to your hosts:
`10.0.0.200 jsonmock.dev`

That's all! Now you can start to use app!!!