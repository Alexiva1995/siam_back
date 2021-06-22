import paramiko
import os
import sys
import time
from termcolor import colored

server_variable = 'SERVER_PRODUCTION'
branch = 'master'

def runCommand(command):
    print("")
    print(colored(command, 'green'))
    (stdin, stdout, stderr) = client.exec_command(command)
    for line in stdout:
        print(line, end = '')
    error = stdout.channel.recv_exit_status()
    del stdin, stdout, stderr
    print("")

    if (error):
        sys.exit(1)
    

# Defino la ubicacion del key y me conecto utilizando la librería paramiko
# El hostname lo defino a traves de una variable de entorno
key = paramiko.RSAKey.from_private_key_file("/opt/atlassian/pipelines/agent/ssh/id_rsa_tmp")
client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect( hostname = os.getenv(server_variable), port = os.getenv('PORT'), username = os.getenv('USER'), pkey = key )
# --

# Obtengo el listado de carpetas dentro de la cerpeta ./releases y los grabo como int dentro de la lista my_list
folder = os.getenv('FOLDER')
(stdin, stdout, stderr) = client.exec_command("cd " + folder + "/releases && ls")
my_list = []
for line in stdout.readlines():
    my_list.append(int(line))
my_list.sort()
# --

# Defino una variable con el nombre de la carpeta del nuevo release
# El nombre del nuevo release es el de la última carpeta dentro de ./releases + 1
# En caso que no haya carpetas dentro de ./releases, el nuevo release será el 1
if my_list.count == 0:
    new_release = 1
else:
    new_release = str(my_list[-1] + 1)
# --


# Clono el repositorio dentro de una nueva carpeta
runCommand("git clone git@bitbucket.org:emi-arcioni/siam-backend.git -b " + branch + " " + folder + "/releases/" + new_release)

# Ejecuto comandos para instanciar el release
laravel_path = folder + "/releases/" + new_release

# composer install
runCommand("cd " + laravel_path + " && composer install --no-scripts")

# composer dump-autoload
runCommand("cd " + laravel_path + " && composer dump-autoload")

# Se stablecen permisos de escritura en carpetas de storage
runCommand("chmod 777 " + laravel_path + "/storage/logs/")
runCommand("chmod -R 777 " + laravel_path + "/storage/framework/")

# Genero el symlink del .env
runCommand("ln -s " + folder + "/shared/.env " + laravel_path + "/.env")

# ejecuto artisan migrate
runCommand("php " + laravel_path + "/artisan migrate --force")

# ejecuto artisan db:seed
runCommand("php " + laravel_path + "/artisan db:seed --force")

# Genero los symlinks para los keys de Laravel Passport
runCommand("ln -s " + folder + "/shared/oauth-private.key " + laravel_path + "/storage/oauth-private.key")
runCommand("ln -s " + folder + "/shared/oauth-public.key " + laravel_path + "/storage/oauth-public.key")

# Elimino la carpeta /storage/app/public actual y la reemplazo con un symlink hacia la carpeta de storage fija del servidor
runCommand("rm -Rf " + laravel_path + "/storage/app/public/")
runCommand("ln -s " + folder + "/storage " + laravel_path + "/storage/app/public")

# Creo un symlink al storage desde la carpeta publica de laravel
runCommand("ln -s " + folder + "/storage " + laravel_path + "/public/storage")

# Elimino el symlink actual y creo uno nuevo que apunte a la carpeta con el nuevo deploy
runCommand("rm " + folder + "/current && ln -s " + folder + "/releases/" + new_release + " " + folder + "/current")
# --

# Cuando tengo más de 5 releases, elimino la carpeta mas vieja dentro de ./releases
if len(my_list) > 5:
    client.exec_command("rm -R " + folder + "/releases/" + str(my_list[0]))
# --

# Cierro la conexion
if client is not None:
    client.close()
    del client
# --