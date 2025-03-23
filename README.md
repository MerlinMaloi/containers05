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

### Выполнение

#### 1. Создал репозиторий `containers05` и склонировал его себе на комп:

#### 2. Создал в папке `containers05` папку `files`, а также: 
- папку `files/apache2` - для файлов конфигурации `apache2`;
- папку `files/php` - для файлов конфигурации `php`;
- папку `files/mariadb` - для файлов конфигурации `mariadb`.

#### 3. Создал файл `Dockerfile` в папке `containers05` со следующим содержимым:

```
# create from debian image
FROM debian:latest

# install apache2, php, mod_php for apache2, php-mysql and mariadb
RUN apt-get update && \
    apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server && \
    apt-get clean
```

#### 4. Построил образ контейнера с именем `apache2-php-mariadb`:

```
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
```

#### 5. Создал контейнер apache2-php-mariadb из образа apache2-php-mariadb

```
docker container create --name apache2-php-mariadb apache2-php-mariadb 
13c3f24fd756d0f2e10e1e32185833c0c19e310e4fac4f4559492aad7b2c1492
```

*Попроборвал исправить команду так как не использовал фоновый флаг и без команды запуска bash:*

```
docker container run -d --name apache2-php-mariadb apache2-php-mariadb bash
docker: Error response from daemon: Conflict. The container name "/apache2-php-mariadb" is already in use by container "13c3f24fd756d0f2e10e1e32185833c0c19e310e4fac4f4559492aad7b2c1492". You have to remove (or rename) that container to be able to reuse that name.
See 'docker run --help'.
```

*Удалил через интерфейс докера неправильный контейнер и исправил команду*

```
PS F:\containers05> docker container run -d --name apache2-php-mariadb apache2-php-mariadb bash  
4565af7653ec50c167069fb940d7863a3bd0696eae0197b7fd221a450212c27d
```

#### 6. Скопировал из контейнера файлы конфигурации `apache2`, `php`, `mariadb` в папку `files/` на компьютер, применив следующие команды:

```
PS F:\containers05> docker cp apache2-php-mariadb:/etc/apache2/sites-available/000-default.conf files/apache2/
>> docker cp apache2-php-mariadb:/etc/apache2/apache2.conf files/apache2/
>> docker cp apache2-php-mariadb:/etc/php/8.2/apache2/php.ini files/php/
>> docker cp apache2-php-mariadb:/etc/mysql/mariadb.conf.d/50-server.cnf files/mariadb/
Successfully copied 3.07kB to F:\containers05\files\apache2\
Successfully copied 9.22kB to F:\containers05\files\apache2\
Successfully copied 75.8kB to F:\containers05\files\php\
Successfully copied 5.63kB to F:\containers05\files\mariadb\
```
*появились файлы конфигурации apache2, php, mariadb*

Остановливаем и удаляем контейнер apache2-php-mariadb

```
PS F:\containers05> docker container rm apache2-php-mariadb 
apache2-php-mariadb
```

#### 7. **Настройка конфигурационных файлов**

    1. Конфигурационный файл apache2

- Открыл файл `files/apache2/000-default.conf`, отыскал строку `#ServerName www.example.com` и заменил её на `ServerName` localhost.
Нашел строку `ServerAdmin webmaster@localhost` и заменил в ней почтовый адрес на свой.
После строки `DocumentRoot /var/www/html` добавил следующee `DirectoryIndex index.php index.html`
Сохранил файл и закрыл.
В конце файла `files/apache2/apache2.conf` добавил строку: `ServerName localhost`





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










PS F:\containers05> docker container rm apache2-php-mariadb
apache2-php-mariadb
PS F:\containers05> docker image rm apache2-php-mariadb
Untagged: apache2-php-mariadb:latest
Deleted: sha256:2454814bb572b0f4c25dcfff3ccd90efbc0fd26cbe5ce067ae966304b041fb48
PS F:\containers05> docker image build -t apache2-php-mariadb .
[+] Building 43.3s (17/17) FINISHED                                                                                                       docker:desktop-linux
 => [internal] load build definition from Dockerfile                                                                                                      0.7s
 => => transferring dockerfile: 1.37kB                                                                                                                    0.7s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                          4.0s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                             0.0s
 => [internal] load .dockerignore                                                                                                                         0.1s
 => => transferring context: 2B                                                                                                                           0.0s 
 => [ 1/10] FROM docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                  0.1s
 => => resolve docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                    0.1s 
 => [internal] load build context                                                                                                                         0.2s 
 => => transferring context: 87.05kB                                                                                                                      0.1s 
 => [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                        8.6s
 => CACHED [ 2/10] RUN apt-get update &&     apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor &&     apt-get clean   0.0s
 => CACHED [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                 0.0s 
 => CACHED [ 4/10] RUN tar xf /var/www/html/latest.tar.gz -C /var/www/html/                                                                               0.0s 
 => CACHED [ 5/10] COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf                                                      0.0s 
 => CACHED [ 6/10] COPY files/apache2/apache2.conf /etc/apache2/apache2.conf                                                                              0.0s 
 => CACHED [ 7/10] COPY files/php/php.ini /etc/php/8.2/apache2/php.ini                                                                                    0.0s 
 => CACHED [ 8/10] COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf                                                               0.0s
 => CACHED [ 9/10] COPY files/supervisor/supervisord.conf /etc/supervisor/supervisord.conf                                                                0.0s 
 => CACHED [10/10] RUN mkdir /var/run/mysqld && chown mysql:mysql /var/run/mysqld                                                                         0.0s 
 => exporting to image                                                                                                                                   28.3s 
 => => exporting layers                                                                                                                                   0.0s
 => => exporting manifest sha256:2929e63cfbd6686b53ffe635d081dab03f3c9a9eb0419cc4004a3a9ba5d1a977                                                         0.0s 
 => => exporting attestation manifest sha256:5a43568bf3bf2e6d9aa732678dea7b9187bda5ad462065b3b1d3f23b8f9cfdfa                                             0.1s 
 => => exporting manifest list sha256:c150bcb0e1946bcbeefdea7bc187ed240002bafff147335078a9c1c13b380753                                                    0.0s 
 => => unpacking to docker.io/library/apache2-php-mariadb:latest                                                                                         28.0s 
View build details: docker-desktop://dashboard/build/desktop-linux/desktop-linux/j7phwcr8jjxgs5mpig4ehhwlm
PS F:\containers05> docker container run -d --name apache2-php-mariadb apache2-php-mariadb
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED          STATUS                     PORTS     NAMES
85bdefa6076d   apache2-php-mariadb   "/usr/bin/supervisor…"   10 seconds ago   Exited (2) 5 seconds ago             apache2-php-mariadb
PS F:\containers05> docker image rm apache2-php-mariadb
Error response from daemon: conflict: unable to delete apache2-php-mariadb:latest (must be forced) - container 85bdefa6076d is using its referenced image c150bcb0e194
PS F:\containers05> docker container rm apache2-php-mariadb
apache2-php-mariadb
PS F:\containers05> docker image rm apache2-php-mariadb    
Untagged: apache2-php-mariadb:latest
Deleted: sha256:c150bcb0e1946bcbeefdea7bc187ed240002bafff147335078a9c1c13b380753
PS F:\containers05> docker image build -t apache2-php-mariadb .
[+] Building 33.6s (17/17) FINISHED                                                                                                       docker:desktop-linux
 => [internal] load build definition from Dockerfile                                                                                                      0.2s
 => => transferring dockerfile: 1.37kB                                                                                                                    0.1s
 => [internal] load metadata for docker.io/library/debian:latest                                                                                          1.5s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                             0.0s
 => [internal] load .dockerignore                                                                                                                         0.1s
 => => transferring context: 2B                                                                                                                           0.1s 
 => [ 1/10] FROM docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                  0.1s
 => => resolve docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                    0.1s 
 => [internal] load build context                                                                                                                         0.1s 
 => => transferring context: 392B                                                                                                                         0.1s 
 => [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                        6.0s
 => CACHED [ 2/10] RUN apt-get update &&     apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor &&     apt-get clean   0.0s
 => CACHED [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                 0.0s 
 => CACHED [ 4/10] RUN tar xf /var/www/html/latest.tar.gz -C /var/www/html/                                                                               0.0s 
 => CACHED [ 5/10] COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf                                                      0.0s 
 => CACHED [ 6/10] COPY files/apache2/apache2.conf /etc/apache2/apache2.conf                                                                              0.0s 
 => CACHED [ 7/10] COPY files/php/php.ini /etc/php/8.2/apache2/php.ini                                                                                    0.0s 
 => CACHED [ 8/10] COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf                                                               0.0s 
 => CACHED [10/10] RUN mkdir /var/run/mysqld && chown mysql:mysql /var/run/mysqld                                                                         0.0s 
 => => exporting layers                                                                                                                                   0.0s 
 => => exporting manifest sha256:2929e63cfbd6686b53ffe635d081dab03f3c9a9eb0419cc4004a3a9ba5d1a977                                                         0.1s 
 => => exporting attestation manifest sha256:a6cb0a0c6a3c6ca6537213516b1986e6f0a67cacc221db16f97902e28a0e020f                                             0.1s 
 => => naming to docker.io/library/apache2-php-mariadb:latest                                                                                             0.1s 
 => => unpacking to docker.io/library/apache2-php-mariadb:latest                                                                                         24.6s 
View build details: docker-desktop://dashboard/build/desktop-linux/desktop-linux/mg9xs0w6ttqp6745o6yxrngvx
PS F:\containers05> docker container run -d --name apache2-php-mariadb apache2-php-mariadb
351cd99c30d2a54edf810983ea8b02b81aecd37d2567962102c77f4a9721f89d
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED         STATUS                     PORTS     NAMES
351cd99c30d2   apache2-php-mariadb   "/usr/bin/supervisor…"   9 seconds ago   Exited (2) 2 seconds ago             apache2-php-mariadb
PS F:\containers05> docker container rm apache2-php-mariadb
apache2-php-mariadb
PS F:\containers05> docker image rm apache2-php-mariadb
Untagged: apache2-php-mariadb:latest
Deleted: sha256:1cca487dd3f178f4c8c5fae0bf1ab0fc742ed0b70a3310c531555ffd8b5c529b
PS F:\containers05> docker image build -t apache2-php-mariadb .
[+] Building 31.1s (16/16) FINISHED                                                                                                       docker:desktop-linux
 => [internal] load build definition from Dockerfile                                                                                                      0.2s
 => => transferring dockerfile: 1.38kB                                                                                                                    0.1s 
 => [internal] load metadata for docker.io/library/debian:latest                                                                                          0.9s
 => [internal] load .dockerignore                                                                                                                         0.1s
 => => transferring context: 2B                                                                                                                           0.0s 
 => [ 1/10] FROM docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                  0.1s 
 => => resolve docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                    0.1s 
 => [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                        5.9s 
 => [internal] load build context                                                                                                                         0.1s 
 => => transferring context: 392B                                                                                                                         0.0s
 => CACHED [ 2/10] RUN apt-get update &&     apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor &&     apt-get clean   0.0s 
 => CACHED [ 3/10] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                 0.0s
 => CACHED [ 4/10] RUN tar xf /var/www/html/latest.tar.gz -C /var/www/html/                                                                               0.0s 
 => CACHED [ 5/10] COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf                                                      0.0s 
 => CACHED [ 6/10] COPY files/apache2/apache2.conf /etc/apache2/apache2.conf                                                                              0.0s 
 => CACHED [ 7/10] COPY files/php/php.ini /etc/php/8.2/apache2/php.ini                                                                                    0.0s 
 => CACHED [ 8/10] COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf                                                               0.0s 
 => [10/10] RUN mkdir /var/run/mysqld && chown mysql:mysql /var/run/mysqld                                                                                0.6s 
 => => exporting layers                                                                                                                                   0.3s 
 => => exporting manifest sha256:40cd026a80558ab3557d892451c9adb76e9e2da3a2653da353b16413ee8d86ee                                                         0.1s 
 => => exporting attestation manifest sha256:f599cb6c6ba3b9d0021a456447f9004e74e16be0ece8d375f81fd15e233b81ff                                             0.1s 
 => => exporting manifest list sha256:b4833a687c31032304f61f0d356879aff7631e2994edb3452693ec98b2ac93b0                                                    0.0s 
 => => unpacking to docker.io/library/apache2-php-mariadb:latest                                                                                         21.5s 
View build details: docker-desktop://dashboard/build/desktop-linux/desktop-linux/mo4gj83hfm62bdmzdxhlta54z
PS F:\containers05> docker container run -d --name apache2-php-mariadb apache2-php-mariadb
d768e9ccc84eceec8c8111731d18c46cf5fe24c5f1a8ee714977b755bfa38715
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED         STATUS         PORTS     NAMES
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED          STATUS          PORTS     NAMES
PS F:\containers05> docker container stop apache2-php-mariadb
PS F:\containers05> docker container rm apache2-php-mariadb
apache2-php-mariadb
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
9eb2d3b6c7c4efa8a9f656116bcc249b8a74ed89188e7844df81c2992a8e5200
CONTAINER ID   IMAGE                 COMMAND                  CREATED         STATUS         PORTS                NAMES
9eb2d3b6c7c4   apache2-php-mariadb   "/usr/bin/supervisor…"   7 seconds ago   Up 2 seconds   0.0.0.0:80->80/tcp   apache2-php-mariadb
apache2-php-mariadb
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED          STATUS                     PORTS     NAMES
9eb2d3b6c7c4   apache2-php-mariadb   "/usr/bin/supervisor…"   21 minutes ago   Exited (0) 6 seconds ago             apache2-php-mariadb
PS F:\containers05> docker container rm apache2-php-mariadb
apache2-php-mariadb
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE     COMMAND   CREATED   STATUS    PORTS     NAMES
PS F:\containers05> docker image rm apache2-php-mariadb
Untagged: apache2-php-mariadb:latest
Deleted: sha256:b4833a687c31032304f61f0d356879aff7631e2994edb3452693ec98b2ac93b0
PS F:\containers05> docker image build -t apache2-php-mariadb .
[+] Building 52.0s (18/18) FINISHED                                                                                                       docker:desktop-linux 
 => [internal] load build definition from Dockerfile                                                                                                      0.6s 
 => => transferring dockerfile: 1.51kB                                                                                                                    0.4s 
 => [internal] load metadata for docker.io/library/debian:latest                                                                                          5.4s
 => [auth] library/debian:pull token for registry-1.docker.io                                                                                             0.0s
 => [internal] load .dockerignore                                                                                                                         0.1s
 => => transferring context: 2B                                                                                                                           0.0s 
 => [internal] load build context                                                                                                                         0.4s
 => => transferring context: 4.06kB                                                                                                                       0.3s 
 => [ 1/11] FROM docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                  0.5s 
 => => resolve docker.io/library/debian:latest@sha256:18023f131f52fc3ea21973cabffe0b216c60b417fd2478e94d9d59981ebba6af                                    0.5s 
 => [ 3/11] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                       10.1s
 => CACHED [ 2/11] RUN apt-get update &&     apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor &&     apt-get clean   0.0s
 => CACHED [ 3/11] ADD https://wordpress.org/latest.tar.gz /var/www/html/                                                                                 0.0s 
 => CACHED [ 4/11] RUN tar xf /var/www/html/latest.tar.gz -C /var/www/html/                                                                               0.0s 
 => CACHED [ 5/11] COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf                                                      0.0s 
 => CACHED [ 6/11] COPY files/apache2/apache2.conf /etc/apache2/apache2.conf                                                                              0.0s
 => CACHED [ 7/11] COPY files/php/php.ini /etc/php/8.2/apache2/php.ini                                                                                    0.0s 
 => CACHED [ 8/11] COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf                                                               0.0s 
 => CACHED [ 9/11] COPY files/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf                                                         0.0s 
 => [11/11] COPY files/wp-config.php /var/www/html/wordpress/wp-config.php                                                                                0.5s 
 => => exporting layers                                                                                                                                   0.8s 
 => => exporting manifest sha256:74dbd04c12104f347df65429e49ae0165d812b96358a438fcf15c8f536f6e0f1                                                         0.1s 
 => => exporting config sha256:b6c274ead5b9b4f387c38d52ad516ca9b4fcf358ef29007a2214039f50c3e7d8                                                           0.0s 
 => => exporting attestation manifest sha256:d7b0ef4ab73818f88bf8362e120b7861d4239df43488ca1e8647c1a930fdd5df                                             0.1s 
 => => exporting manifest list sha256:705820a6c409af9db87140c59d2dfda6214a9c67b7123a3d8ae36e7d6aad7688                                                    0.0s 
 => => naming to docker.io/library/apache2-php-mariadb:latest                                                                                             0.0s 
 => => unpacking to docker.io/library/apache2-php-mariadb:latest                                                                                         32.3s 

View build details: docker-desktop://dashboard/build/desktop-linux/desktop-linux/zowsbl90u3a0op9v5n49d782n
PS F:\containers05> docker container run -d -p 80:80 --name apache2-php-mariadb apache2-php-mariadb
6284ca3adf56fa595faabffba5add8e8b948d94eb5a68b237384dc2e69ca5d61
PS F:\containers05> docker container list -a
CONTAINER ID   IMAGE                 COMMAND                  CREATED          STATUS          PORTS                NAMES
6284ca3adf56   apache2-php-mariadb   "/usr/bin/supervisor…"   33 seconds ago   Up 31 seconds   0.0.0.0:80->80/tcp   apache2-php-mariadb
PS F:\containers05>      