# Cornerstone
A Docker Skeleton for LAMP

If you work with PHP you frequently need a LAMP (Linux Apache MySQL PHP) stack.  Setting up this
stack on any workstation can be a pain.  If you work in an environment with multiple versions 
of PHP, MySQL and supporting libraries, this can truly become a pain. 

Docker lets us abstract the environment setup into containers in a virtual network.  This project is
an attempt to use Docker, plus some scripting sugar, to take the pain out of setting up a new
development environment. 

# Quickstart

* [Quick Start for Windows 10](bin/QuickStartWindows.md)
* [Quick Start for Apple OS X](bin/QuickStartApple.md)

For the Docker purest:

* Install Docker.
* Edit the `.env` file in the root of the project.  Make sure the ports are not in use.
* (Optional) Copy your SSH key into `ssh/id_rsa`. Only if you need to use SSH git or composer inside a container.
* To build all `docker-compose build`.
* To run all server `docker-compose up`.
* To run a BASH session in a container with PHP and MySQL tools, `docker-compose run bash`.
* To run a PhpMyAdmin server, `docker-compose run myadmin` open your browser to http://loopback.world:{Port from `.env`}.
* To run the Web-Server, `docker-compose run apache` open your browser to https://loopback.world:{Port from `.env` file}.


## The .env file
The `.env` file sets variables used in all the other scripts.  This is the default variable location for
 docker-composer.  The PowerShell and BASH scripts also can read this file and use the setting as well.
 If you need to extend the functionality of these script this is where you should put any setting that might
 change.  These setting can be passed into the Docker containers as environment variables.
 
 ## SSH Keys
 
 ## PHP XDebug
 
 ### Path Mappings
 * Apache container (Website)
 * BASH container (Command Line or CLI)
 
 ## The BASH container
 
 ### Adding Tools
 
 ### The ssh key
 
 ## Changing PHP Versions
 
 ## Changing MySQL/MariaDB Versions
 
 ## Adding Containers
 
 ### A Message Que container and Long Running PHP scripts
 
 ### A PHP Web-socket container
 
 ### A PHPUnit container 
 
 ## CI/CD
 
 # Gotyas 
 If you work in windows your line endings can mess up the files used in the Linux containers.  Be sure to 
 set your IDE to use `LF \n` for line endings for any Linux shell scripts. 
  
 SSH Keys.  If you need SSH keys for git or composer inside a container you 
 will need to copy the id_rsa into the ssh directory.  I am sure there is a 
 better way to do SSH keys inside containers but I have not found it.