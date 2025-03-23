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

7.1. **Конфигурационный файл apache2**

- Открыл файл `files/apache2/000-default.conf`, отыскал строку `#ServerName www.example.com` и заменил её на `ServerName` localhost.
- Нашел строку `ServerAdmin webmaster@localhost` и заменил в ней почтовый адрес на свой.
- После строки `DocumentRoot /var/www/html` добавил следующee `DirectoryIndex index.php index.html`
- Сохранил файл и закрыл.
- В конце файла `files/apache2/apache2.conf` добавил строку: `ServerName localhost`

```
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
```

7.2. **Конфигурационный файл php**

- В файле `files/php/php.ini` строку `;error_log = php_errors.log `и заменил её на `error_log = /var/log/php_errors.log`.
- Настроил параметры `memory_limit`, `upload_max_filesize`, `post_max_size` и `max_execution_time` следующим образом:
    - `memory_limit = 128M`
    - `upload_max_filesize = 128M`
    - `post_max_size = 128M`
    - `max_execution_time = 120`

7.3. **Конфигурационный файл mariadb** 

- Открыл файл `files/mariadb/50-server.cnf`, нашел строку `#log_error = /var/log/mysql/error.log` и раскомментировал её.
- Сохранил файл

#### 8.  Создание скрипта запуска

Создал в папке `files` папку `supervisor` и файл `supervisord.conf` со следующим содержимым:

```
[supervisord]
nodaemon=true
logfile=/dev/null
user=root

# apache2
[program:apache2]
command=/usr/sbin/apache2ctl -D FOREGROUND
autostart=true
autorestart=true
startretries=3
stderr_logfile=/proc/self/fd/2
user=root

# mariadb
[program:mariadb]
command=/usr/sbin/mariadbd --user=mysql
autostart=true
autorestart=true
startretries=3
stderr_logfile=/proc/self/fd/2
user=mysql
```

#### 9. Создание Dockerfile

- Открыл файл `Dockerfile` и добавил:
    - после инструкции `FROM ...` монтирование томов:
    ```
    # mount volume for mysql data
    VOLUME /var/lib/mysql

    # mount volume for logs
    VOLUME /var/log
    ```
    - в инструкции `RUN ...` добавьте установку пакета `supervisor`.
    ```
    Dockerfile
    RUN apt-get update && \
        apt-get install -y apache2 php libapache2-mod-php php-mysql mariadb-server supervisor && \
        apt-get clean
    ```
    - после инструкции `RUN ...` добавьте копирование и распаковку сайта `WordPress`:
    ```
    Dockerfile
    # add wordpress files to /var/www/html
    ADD https://wordpress.org/latest.tar.gz /var/www/html/
    RUN tar xf /var/www/html/latest.tar.gz -C /var/www/html/
    ```
    *потребовалось указание диска -C*
    - после копирования файлов `WordPress` добавил копирование конфигурационных файлов `apache2`, `php`, `mariadb`, а также скрипта запуска:
    ```
    # copy the configuration file for apache2 from files/ directory
    COPY files/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf
    COPY files/apache2/apache2.conf /etc/apache2/apache2.conf

    # copy the configuration file for php from files/ directory
    COPY files/php/php.ini /etc/php/8.2/apache2/php.ini

    # copy the configuration file for mysql from files/ directory
    COPY files/mariadb/50-server.cnf /etc/mysql/mariadb.conf.d/50-server.cnf

    # copy the supervisor configuration file
    COPY files/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
    ```
    *в дальнейшем окажется последняя команда неправильной `COPY files/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf`*
    - для функционирования `mariadb` создал `/var/run/mysqld` и установил права на неё:
    ```
    # create mysql socket directory
    RUN mkdir /var/run/mysqld && chown mysql:mysql /var/run/mysqld
    ```
    - открыл порт 80:
    ```
    EXPOSE 80
    ```
    - добавьте команду запуска `supervisord`:
    ```
    # start supervisor
    CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
    ```
- Пересобирал образы контейнера с именем apache2-php-mariadb и запуская контейнер apache2-php-mariadb из образа apache2-php-mariadb. Проверил наличие сайта WordPress в папке /var/www/html/. *есть*

#### 10. Создание базы данных и пользователя

В Докере в контейнере в `exec` создал базу данных `wordpress` и пользователя `wordpress` с паролем `wordpress` в контейнере `apache2-php-mariadb`:

```
mysql
CREATE DATABASE wordpress;
CREATE USER 'wordpress'@'localhost' IDENTIFIED BY 'wordpress';
GRANT ALL PRIVILEGES ON wordpress.* TO 'wordpress'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### 11. Создание файла конфигурации WordPress

Открыл в браузере сайт `http://localhost/`. Укажите параметры подключения к базе данных:
- имя базы данных: `wordpress`;
- имя пользователя: `wordpress`;
- пароль: `wordpress`;
- адрес сервера базы данных: `localhost`;
- префикс таблиц: `wp_`.
Скопировал содержимое в новый файл конфигурации в файл `files/wp-config.php` на компьютере.

*Потребовалось переделывать запуск контейнера и всего образа для того чтобы указать октрытость порта для хоста `-p 80:80`*

#### 12. Добавление файла конфигурации WordPress в Dockerfile

Добавил в файл Dockerfile строки:
```
# copy the configuration file for wordpress from files/ directory
COPY files/wp-config.php /var/www/html/wordpress/wp-config.php
```

#### 13. Запуск и тестирование

В очередной раз пересобрал образ контейнера с именем apache2-php-mariadb и запусти контейнер apache2-php-mariadb из образа apache2-php-mariadb. Сайт WordPress рррааботает.

#### 14. Ответы на вопрос

-Какие файлы конфигурации были изменены?

Файл php, mariadb, apache2, файл конфигурации WordPress и supervisor были созданы

-За что отвечает инструкция DirectoryIndex в файле конфигурации apache2?

DirectoryIndex — это директива в конфигурации Apache, которая указывает, какой файл будет загружаться по умолчанию, когда пользователь обращается к директории (папке) на сервере без указания конкретного файла

-Зачем нужен файл wp-config.php?

Это важный конфигурационный файл WordPress, который содержит критически важные настройки для работы сайта

-За что отвечает параметр post_max_size в файле конфигурации php?

Это директива в конфигурационном файле PHP (php.ini), которая определяет максимально допустимый размер данных, которые могут быть отправлены через HTTP POST-запрос. Это важно, например, при загрузке файлов через формы на сайте чтобы обезопаситься от пользователя.

-Укажите, на ваш взгляд, какие недостатки есть в созданном образе контейнера?

Необходимость открывать порт для хоста вручную

Некоторая сложность отслеживания личных ошибок


### Вывод

В ходе работы над лабараторной был получен опыт в создании и настройке контейнеров с веб-серверами и базами данных, а также в установке и настройке популярных веб-приложений, таких как WordPress. Это позволяет лучше понять концепцию контейнеризации и повысить навыки работы с Docker
