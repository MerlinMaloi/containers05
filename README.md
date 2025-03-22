# Запуск сайта в контейнере

## Цель работы:

Выполнив данную работу студент сможет подготовить образ контейнера для запуска веб-сайта на базе Apache HTTP Server + PHP (mod_php) + MariaDB.

## Задание

Создать Dockerfile для сборки образа контейнера, который будет содержать веб-сайт на базе Apache HTTP Server + PHP (mod_php) + MariaDB. База данных MariaDB должна храниться в монтируемом томе. Сервер должен быть доступен по порту 8000.

Установить сайт WordPress. Проверить работоспособность сайта.

## Подготовка

Для выполнения данной работы необходимо иметь установленный на компьютере Docker.

Для выполнения работы необходимо иметь опыт выполнения лабораторной работы №3.

## Описание выполнения работы с ответами на вопросы

1. Создал репозиторий containers05 и склонировал его себе на комп:


PS F:\containers05> docker build -t apache2-php-mariadb .
[+] Building 195.1s (7/7) FINISHED                                                                                                        docker:desktop-linux
 => [internal] load build definition from Dockerfile                                                                                                      0.4s
 => => transferring dockerfile: 284B                                                                                                                      0.2s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                          4.6s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                             0.0s
 => [internal] load .dockerignore                                                                                                                         0.2s
 => => transferring context: 2B                                                                                                                           0.0s
 => [1/2] FROM docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                   18.3s
 => => resolve docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                    0.1s
 => => sha256:7cd785773db44407e20a679ce5439222e505475eed5b99f1910eb2cda51729ab 48.47MB / 48.47MB                                                         12.7s
 => => extracting sha256:7cd785773db44407e20a679ce5439222e505475eed5b99f1910eb2cda51729ab                                                                 5.3s
 => [2/2] RUN apt-get update &&     apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server &&     apt-get clean                     120.1s
 => exporting to image                                                                                                                                   50.4s
 => => exporting layers                                                                                                                                  36.4s 
 => => exporting manifest sha256:3972a66b606304c8ce3829fa67d8eb2a35fb09c557ef234bb8870436f7f7c7b1                                                         0.1s 
 => => exporting config sha256:7ff4e5d3be51fb2255affd90d34d5ea121dcc2ab6cf8fee9bc6ca02fbce002e2                                                           0.0s 
 => => exporting attestation manifest sha256:7c63c8ff4cec7beaadaba7372f1882ce7e1806f45370840d2396003fd3627436                                             0.1s
 => => exporting manifest list sha256:62c45a297f5e23dc7ea9eec7c20c05c1c54681d5a53c36315639fd30e898d27a                                                    0.0s 
 => => naming to docker.io/library/apache2-php-mariadb:latest                                                                                             0.1s 
 => => unpacking to docker.io/library/apache2-php-mariadb:latest     




 docker container create --name apache2-php-mariadb apache2-php-mariadb 
13c3f24fd756d0f2e10e1e32185833c0c19e310e4fac4f4559492aad7b2c1492


docker container run -d --name apache2-php-mariadb apache2-php-mariadb bash
docker: Error response from daemon: Conflict. The container name "/apache2-php-mariadb" is already in use by container "13c3f24fd756d0f2e10e1e32185833c0c19e310e4fac4f4559492aad7b2c1492". You have to remove (or rename) that container to be able to reuse that name.
See 'docker run --help'.

удалил через интерфейс докера

PS F:\containers05> docker container run -d --name apache2-php-mariadb apache2-php-mariadb bash  
4565af7653ec50c167069fb940d7863a3bd0696eae0197b7fd221a450212c27d


PS F:\containers05> docker cp apache2-php-mariadb:/etc/apache2/sites-available/000-default.conf files/apache2/
>> docker cp apache2-php-mariadb:/etc/apache2/apache2.conf files/apache2/
>> docker cp apache2-php-mariadb:/etc/php/8.2/apache2/php.ini files/php/
>> docker cp apache2-php-mariadb:/etc/mysql/mariadb.conf.d/50-server.cnf files/mariadb/
Successfully copied 3.07kB to F:\containers05\files\apache2\
Successfully copied 9.22kB to F:\containers05\files\apache2\
Successfully copied 75.8kB to F:\containers05\files\php\
Successfully copied 5.63kB to F:\containers05\files\mariadb\

PS F:\containers05> docker container rm apache2-php-mariadb 
apache2-php-mariadb





<VirtualHost *:80>
	# The ServerName directive sets the request scheme, hostname and port that
	# the server uses to identify itself. This is used when creating
	# redirection URLs. In the context of virtual hosts, the ServerName
	# specifies what hostname must appear in the request's Host: header to
	# match this virtual host. For the default virtual host (this file) this
	# value is not decisive as it is used as a last resort host regardless.
	# However, you must set it for any further virtual host explicitly.
	ServerName localhost

	ServerAdmin malloialeks@gmail.com
	DocumentRoot /var/www/html
	DirectoryIndex index.php index.html





files/apache2/apache2.conf

ServerName localhost