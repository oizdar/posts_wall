# Recruitment task
### Posts & Comments system 

Backend requirements: 
- Clear PHP (without any framework)
- REST Request 
- JSON Response

Frontend: 
- jQuery
- Bootstrap

### Installation:
- (important)Repository doesn't have bootstrap files. Copy them inside /web/bootstrap folder. or modify index.html file references.
jQuery is included from external source.
- Example configuration is in .env.dist file, copy it as .env
- This system is built on docker. To start app is enough to use command `docker-compose up` in project directory.
Server starts on port 8080.
- To install database schemas and/or fixtures run `install.php` file in fpm container:
    ```bash
      docker exec -it fpm_container_name bash
      $ php install.php 
    ```
    
- Paths:
    - Backend api is configured for path: `localhost:8080/api/`.
