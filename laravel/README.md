<h1>Alex Peralta - Mars Rover Mission</h1>

<h2> About the project</h2>

<p>I created a docker-based structure with two containers, one with an apache2 webserver and the project code and another one with the mysql service. </p>

<h2>How to initialize the project</h2>

<p>I created a vhost so you will have to modify your hosts file (Windows: C:\Windows\System32\drivers\etc\hosts || Unix: /etc/hosts) with the next line:</p>
<strong>127.0.0.1 www.mars-rover-mission.com</strong>

<h3>Docker initialization</h3>
        
<p>For the inizialization of this project you will need docker and docker compose</p>
<p>Note that docker will try to bind the 80 port to the host 80 port (we are not using ssl in this case) for apache2 and the port 3306 for mysql service, if it's already in use you will have to change the binding in {project-root}/docker/dev/docker-compose.yml, in the mars-rover-mission container before executing the first command.<br/><br />
<strong>WARNING: Javascript repositories will fail in this case if we don't change the API base URL adding the new port and creating the JS bundle again and database connection may fail too if we don't change laravel .env file.</strong></p>

<strong>Commands</strong>
<ul>
    <li>cd {project-root}/docker/dev</li>
    <li>docker-compose up -d --build</li>
    <li>docker exec -it mars-rover-mission /bin/bash</li>
    <li>cd laravel</li>
    <li>cp .env.example .env</li>
    <li>composer install</li>
    <li>php artisan migrate</li>
    <li>chown -R 1000:www-data .</li>
    <li>chmod 775 -R .</li>
</ul>

<p>Now you should be able to use the application in http://www.mars-rover-mission.com<br/>
You can run the available php tests with the command "php artisan test"</p>


<strong>For any doubt or question don't hetistate to send me an email to aperaltaq92@gmail.com</strong>
