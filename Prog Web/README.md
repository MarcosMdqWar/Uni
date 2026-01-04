\[Hacer funcionar el captcha.php]



Cómo habilitarla (Windows)



Localiza php.ini: 

Busca el archivo de configuración de PHP en tu instalación.

Busca la línea: Usa Ctrl+F (o Cmd+F) y busca extension=gd o ;extension=gd.

Descomenta la línea: Elimina el punto y coma (;) al principio si existe, para que quede extension=gd.

Guarda y reinicia: Guarda el archivo php.ini y reinicia tu servidor web (Apache, Nginx) para aplicar los cambios. 



Cómo habilitarla (Linux - Ubuntu/Debian)

Instala el paquete específico para tu versión de PHP, por ejemplo:

sudo apt-get install php8.1-gd (para PHP 8.1).

sudo apt-get install php8.2-gd (para PHP 8.2). 

