<!DOCTYPE html>
<!--
Ayuda de "Edicion de Bloques de Procesos" del fichero de configuración
-->
                <div class="modal-body">
                    <div><h5 class="ayuda">  <strong>Bloques de Procesos</strong>: Son estructuras que agrupan a los procesos. Cada proceso debe pertenecer
                            a un bloque.
                            <p></p>
                            Al seleccionar un bloque se despliega un menu que muestra los procesos que pertenecen a &eacute;l.
                            Cada proceso tiene los sgtes par&aacute;metros:
                             <p></p>
                            <p><strong>namespace</strong>: (string) </p>
                            <pre></pre>
                            <p><strong>clase</strong>: (string) </p>
                            <p><strong>id_entidad</strong>: (string)  </p>
                            <p><strong>Clase gedee</strong>: </p>
                            <p><strong>path_raiz</strong>: (array) </p>
                            <p><strong>path_arranque</strong> (string): </p>
                            <p><strong>obligatoriedad</strong> (string): </p>
                            <p><strong>condicion_ejecucion</strong> (string): </p>
                            <pre>
bloques_procesos:
    bloque_defecto:
        pprueba:
            gedee_proceso:
                namespace: \Emod\Nucleo\Gedees
                clase: GedeeEComun
                id_entidad: GedeeEComun
            propiedades_implementacion_proceso:
                path_raiz: proceso_prueba
                path_arranque: control_prueba.php
                obligatoriedad: 1
                condicion_ejecucion: $_GET['a'] ==2
                            </pre>
                        </h5>
                    </div>

                </div>