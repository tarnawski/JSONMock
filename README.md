JSONMock-beckend
====================

A Symfony project created on January 2016

<h2>Short description</h2>
The application is designed to mock JSON response.
Mock your JSON responses and test your REST API!

<h2>Links:</h2>

<p>Url to frontend application repository based on this application:</p>
`https://github.com/tarnawski/JSONMock-frontend`

Rest API documentation endpoint: `/doc/api`
 
<p><h2>Getting started</h2></p>
Prepare: 
- VirtualBox
- Vagrant witch plugin:
    - vagrant-winnfsd: `vagrant plugin install vagrant-winnfsd` (If you use Windows)

2. Source code
Clone the repository:
`https://github.com/tarnawski/JSONMock-backend.git`
Get into project catalog:
`cd JSONStorage-backend`
3. Run Vagrant
`cd vagrant` and `vagrant up`
When the process is complete, get into the machine:
`vagrant ssh`
4. Creating database schema:
`php app/console doctrine:schema:create`
5. Load fixtures:
`php app/console doctrine:fixtures:load`
6. Add to your hosts:
`10.0.0.200 jsonmock.dev`

That's all! Now you can start to use your app!!!