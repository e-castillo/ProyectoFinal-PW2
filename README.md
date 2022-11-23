# ProyectoFinal-PW2
Proyecto Final - InfoNete

Descripción general del sistema

La empresa “InfoNete s.a.” está incursionando en el mundo de las noticias digitales, llevando sus diarios y revistas a la web. Dado que la misma no posee un departamento de desarrollo de sistemas, va a contratarnos para desarrollar la plataforma que les permita publicar sus medios de comunicación, administrarlos fácilmente y poseer un buen control y generación de reportes aún mejor que el que poseen los medios físicos, facilitando el análisis del producto en tiempo real, por ejemplo, la cantidad de personas que observa una noticia, en-tre otros reportes e información que sólo la web nos puede facilitar.

Nuestro cliente nos solicita NO utilizar un gestor de contenidos, ya que desea escalar el sistema a lo largo del tiempo y prefiere que el mismo sea de código propio.

Como detalles técnicos extras, el cliente desea que trabajemos sobre servidores Linux con lenguaje de programación PHP por parte del servidor y bases de datos MySql para almacenar los datos (Las claves de los usuarios deben ser almacenadas como mínimo en MD5).

Funcionalidades:

• El sistema debe permitir que el usuario se registre cargando sus datos personales, un correo electrónico, contraseña y ubicación de residencia (desde un mapa de Google o de here.com), el registro deberá pedir confirmación por email.
• El sistema debe permitir realizar login al usuario.
• El usuario debe poder visualizar un catálogo de productos (revistas y diarios).
• El sistema debe permitir suscribirse a un producto mensualmente, desuscri-birse, o abonar un número de la revista o diario en particular (a través de MercadoPago y de ser posible a través de un código QR).
• El sistema debe permitir que el usuario visualice las noticias / revistas por las que ha pagado.
• El usuario debe poder imprimir en PDF el resumen de suscripciones o pa-gos del periodo de tiempo seleccionado.
• El usuario debe poseer una vista donde encuentre fácilmente los productos que posee.
• El sistema debe mostrar en la pantalla principal el pronóstico del clima como muestra la competencia (El clima será consultado a un WebServer externo a nuestro sistema).
• El usuario podrá localizar el lugar geográfico de la noticia mediante un mapa en línea (Se requiere utilizar mapas de Google o de here.com)

• El sistema debe permitir que el contenidista se loguee con usuario y contra-seña (el mismo será creado por el administrador de sistema)
• El contenidista tiene que poder crear una revista o diario.
• El contenidista tiene que poder crear secciones dentro del diario o revista
• El contenidista tiene que poder crear una edición de una revista o diario dado
• El contenidista debe georeferenciar la noticia de manera que el suscriptor pueda observar en un mapa el lugar de ocurrencia de la misma. (Se re-quiere utilizar mapas de Google o de here.com)
El contenidista tiene que poder crear noticias para una sección de revista o diario, cada noticia debe poseer al menos un título, subtítulo, una imagen o varias y el contenido. Como datos opcionales permitir agregar un link a ma-yor información o un video que debe poder visualizarse dentro de la misma página web.
• El contenidista debe poder tomar una foto/video directamente desde el sitio y asociarla a una noticia.
• El contenidista debe poder grabar un audio desde una noticia y asociarlo di-rectamente


● El sistema debe permitir loguearse al administrador
● El administrador debe poder realizar ABM sobre los componentes de la revista, contenidistas y usuarios, ya que es el moderador del sitio.
● El administrador debe poder generar gráficos de torta con la cantidad de productos vendidos en un periodo de tiempo, dividido por producto. (So-licita utilizar Google Charts)
● El administrador debe poder visualizar un gráfico de barras que muestre por cada día del periodo de tiempo seleccionado, cuantas suscrip-ciones se realizaron (y en otro gráfico, cuántos productos se vendieron) (Solicita utilizar Google Charts)
● El administrador debe poder generar una lista descargable a PDF con:
    ○ Sus contenidistas y su información personal
    ○ Sus clientes y su información personal y producto adquirido
    ○ Sus productos con su información básica, cantidad de vendi-dos/suscritos y ediciones
