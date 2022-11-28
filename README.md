Instrucciones:

1. Crear Token-> Permite crear un token especifico para cada area (bartender, cocinero, cervecero, admin). Necesario para el resto de funcionalidades.

2. Crear empleados-> Con un token de administrador, mediante post, pasando el area admin y un token de admin, se permitira la creacion de todo tipo de empleados. (Estos se crearan con un estado en Libre que significa que no estan cocinando o trabajando)

3. Listar empleados-> Sin token. Permite listar a los empleados creados en la base de datos.

4. Tomar pedido-> Token mozo. Permite tomar un pedido, ingresando el plato correspondiente en el value y el area en la key. Ingresando descripcion completa para el pedido, el precio, la mesa. Solo puede tomar el pedido el mozo, no un cocinero o bartender, por lo que necesita una Key=area value=mozo

5. Relacionar pedido-> Token mozo. Ingreso la imagen, el numero de la mesa correspondiente y el area mozo, para guardar en la carpeta FotosPedidos una foto que contiene en el nombre el numero de la meza y la descripcion.

6. Listar pedidos por area-> Token (cualquier empleado). Muestra los productos pendientes de preparar por cada area ingresada.

7. Preparar pedidos-> Token (cualquier empleado). Ingresando el area correspondiente, cada empleado tomara el pedido correspondiente con su area y lo comenzara a preparar asignandole un tiempo estimado de finalizacion y el empleado estableciendo su estado en Ocupado. (Si todos los empleados de un area estan ocupados, no podran tomar el pedido hasta que finalicen y esten 'Libres').

8. Cliente consulta demora-> Sin token. Ingresando el id del pedido y el id de la mesa, se consultara el estado de la mesa actualmente.

9. Socio consulta pedidos-> Token admin. Ingresando el id del pedido y el id de la mesa, se consultara el estado del pedido.

10. Empleados listos para ervir-> Token (cualquier empleado). Cada empleado de cada area, debe avisar que ha terminado la preparacion del pedido. Cuando lo notifique en el sistema, su estado pasara a ser libre y podra tomar otro pedido cuando quiera. Los productos preparados por su area se pondran en listos para servir.

11. Servir mesa-> Token mozo. El mozo chequeara que los productos esten listos para servir, y pasara el estado del pedido a Servido.

12. Cobrar mesa-> Token mozo. El mozo cobrara la mesa, y pasara el estado del pedido a Cobrado.

13. Cerrar mesa-> Token admin. El administrador puede cerrar la mesa ingresada por postman.

14. Encuesta -> cliente. Ingresando id mesa, id pedido, calificacion y el comentario. Se agregara a la tabla de encuestas lo ingresado.

15. Listar mejores comentarios-> Token admin. Con area ingresada admin, seleccionara de manera creciente las encuestas con mejores puntuaciones.

16. Descargar-> Descarga la tabla de pedidos de con extension csv. Ingresando la url por un navegador, se abrira automaticamente la descarga para poder guardarla en el directorio que el usuario lo decida.

17. Cargar-> Carga a la tabla de pedidos, el archivo csv descargado anteriormente.
