### Reto Técnico de Códigos Postales

#### ¿Cómo se realizó?
1. Se analizó la fuente de información para tener una idea de cómo abordar el reto.
2. Una vez analizada la fuente de información, se pudo crear la estructura de la base de datos.

3. Con la estructura de la base de datos, se procedió a crear un comando que se encargase de ingresar la fuente de información a la base de datos. Como se eligió el Excel como fuente de información, se procedió a instalar la librería Laravel Excel.
4. Teniendo la información con el cual trabajar, se empezó a crear la lógica que se encargaría de entregar la información del código postal solicitado.
5. Una vez hecho el reto, se procedió a crear las pruebas funcionales de lo realizado.
6. Para finalizar, se procedió a hacer el deploy de la aplicación en AWS.


#### Estructura de la Base de Datos
![](https://i.imgur.com/E5Stuy7.png)

#### ¿Cómo hacer funcionar el proyecto en local?
Prerequisitos Docker
- Clonar el proyecto:
```
git clone git@github.com:alejurian/technical-challenge-zip-codes.git
```
- Ingresamos a la carpeta `technical-challenge-zip-codes` e instalar las dependencias:
```
cd technical-challenge-zip-codes && docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
- Se copia el contenido del archivo `.env.example` y se pega en uno nuevo con el nombre de `.env`.
```
cp .env.example .env
```
- En el archivo .env cambiaremos el valor que poseen las siguientes variables: `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`. Si se utiliza el contenedor de Mysql para Docker, colocar en la variable `DB_HOST` el valor de `mysql`.
- Levantamos los contenedores con Docker:
```
./vendor/bin/sail up -d
```
- Generamos la key de encriptación:
```
./vendor/bin/sail artisan key:generate
```
- [Descargamos el Excel de la fuente de datos](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx "Descargamos el Excel de la fuente de datos") y lo copiamos en la ruta `/storage/app/` con el nombre `CPdescarga.xls`. El archivo que utilicé fue [este](https://docs.google.com/spreadsheets/d/1WfHb4pxLSoeI_FjtbPAVnvoJemzu-VSg/edit?usp=share_link&ouid=101262177311718890593&rtpof=true&sd=true "este").
- Desde la raíz del proyecto ejecutamos el comando que ingresará la información del Excel a la Base de Datos. Este proceso suele demorar unas horas. Si se desea, se puede descargar [el dump](https://drive.google.com/file/d/1q97Rrw-woc6D2S-FcxXeHkc49wQtxMlc/view?usp=share_link "el dump") que obtuve al finalizar este proceso.
```
./vendor/bin/sail php artisan process:file
```
- Una vez migrada la información del Excel, la aplicación está lista para ser utilizada.
- Si se desea, se pueden ejecutar las pruebas funcionales con el siguiente comando:
```
./vendor/bin/sail php artisan test
```
