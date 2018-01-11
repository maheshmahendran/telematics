# telematics
Install docker
Window users, please see https://docs.docker.com/docker-for-windows/
OSX users, please see https://docs.docker.com/docker-for-mac/
Linux users, please see https://docs.docker.com/engine/installation/linux/

Build the Docker image
	cd ~/ && git clone https://github.com/maheshmahendran/telematics.git
	cd telematics/Backend
	docker build -t telematics.api:latest .
Run the container 
Windows users:
docker run -it --rm -p 5000:80 -v  ~/telematics/Backend:/var/www/html telematics.api:latest /bin/bash
service apache2 start
composer install
