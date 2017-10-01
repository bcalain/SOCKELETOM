<!DOCTYPE html>
<!--
Ayuda de "Valores de valores referentes a herramientas" del fichero de configuración
-->
                <div class="modal-body">
                    <div><h5 class="ayuda">  Herramientas y datos necesarios para su implementación por parte del sistema.
                            <p></p>
                            <p><strong>path_entidad_clase</strong>: (string) Es el camino hasta el fichero donde se encuentra la clase de la
                                herramienta.</p>
                            <pre>e_modulos/nucleo/nucleo_bib_funciones/herramientas/class_herramienta_earreglo.php</pre>
                            <p><strong>referencia_path_entidad</strong>: (string) Es la forma  en que se puede hacer referencia al 
                                path_entidad_clase anterior,tiene dos posibles valores, *relativo*, *relativo_esquelemod*, y *absoluto*.</p>
                            <p><strong>tipo_entidad</strong>: (string)  Si la entidad herramienta a referenciar es un objeto o una clase de
                                procedimientos estáticos. Los valores posibles son *clase* y *objeto*.</p>
                            <p><strong>Clase gedee</strong>: </p>
                            <p><strong>instancias + herramienta</strong>: (array) Es un arreglo con los identificadores de herramientas a reservar
                                desde este procedimiento, este arreglo asociativo tiene como llaves los id_herramienta</p>
                            <p>id_ herramienta (string) Identificador de cada herramienta(obligatorio), y a su vez es un arreglo asociativo al que se
                                puede insertar una llave de nombre parametros_iniciacion(1) y otra de nombre datos(2), posteriormente
                                este arreglo id_herramienta se le incorporan otros elementos con llave asociativa para el trabajo de
                                esta clase. Pueden existir tantos id_herramienta como sea necesario ya que la herramienta puede
                                ser una instancia de una clase con valores muy específicos.</p>
                            <p>(1)parametros_iniciacion: </p>
                            <p>(2)datos: </p>
                            <pre>...Poner un ejemplo...</pre>
                        </h5>
                    </div>

                </div>
