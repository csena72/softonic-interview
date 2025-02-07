# Usa la imagen base de Sail para PHP
FROM vendor/laravel/sail/runtimes/8.4

# Instalar Python y pip
RUN apt-get update && apt-get install -y python3 python3-pip

# Instalar las librerías necesarias
RUN pip3 install fuzzywuzzy python-Levenshtein
