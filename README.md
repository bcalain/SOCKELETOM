# SOCKELETOM
###Esqueleto con Sockets, como Motor de Códigos PHP en forma de módulos#

Licencia GPL3

Versión 1.0.0

Lenguage PHP 5.3 O Superior

No necesita Gestor de Bases de Datos para su funcionamiento


Sockeletom es una aplicación escrita en lenguaje PHP, devenido framework por su capacidad de asimilar scripts, clases herramientas, aplicaciones, además de una estructura y grupo de clases que brinda como herramientas para el desarrollo de aplicaciones php.Su nombre se compone de las palabras Socket, Esqueleto y Modular (Socket, Skeleton, Modular ), siendo descriptivo de su estructura y forma de gestión, esta aplicación se creó pensando en todo momento en como hacer más fácil la interacción entre scripts, aplicaciones etc sin que estas cumplieran estrictamente con un modelo, estructura u otra forma de diseño; pueden ser escritas en momentos diferentes, por grupos de desarrollo diferentes, con estilos diferentes y con un simple ajuste al Sockeletom pueden interactuar entre ellas.

Su gestión es en forma de ejecución de los scripts, aplicaciones php etc antes mencionados, a los que se les denomina procesos en el ámbito del Sockeletom; estos procesos tiene una cola de ejecución y ellos mismos pueden lanzar la ejecución de otro proceso, sucediendose estas ejecuciones hasta que se finalice la cola o algún proceso finalice el interprete php. Estos procesos pueden dejar datos en forma segura después de morir el proceso y ser leídos, modificados o eliminados, estos datos, por procesos que se ejecutan posteriormente en la cola de procesos, esto sucede de forma dinámica en objetos contenedores que brinda el Sockeletom para este tipo de intercambio como parte de las herramientas que pone el Sockeletom al servicio de las aplicaciones que hagan uso del framework.
