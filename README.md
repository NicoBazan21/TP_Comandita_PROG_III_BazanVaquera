Instrucciones:

Crear Token-> Permite crear un token especifico para cada area (bartender, cocinero, cervecero, admin). Necesario para el resto de funcionalidades.

Crear empleados-> Con un token de administrador, mediante post, pasando el area admin y un token de admin, se permitira la creacion de todo tipo de empleados. (Estos se crearan con un estado en Libre que significa que no estan cocinando o trabajando)

Listar empleados-> Sin token. Permite listar a los empleados creados en la base de datos.

Tomar pedido-> Token mozo. Permite tomar un pedido, ingresando el plato correspondiente en el value y el area en la key. Ingresando descripcion completa para el pedido, el precio, la mesa. Solo puede tomar el pedido el mozo, no un cocinero o bartender, por lo que necesita una Key=area value=mozo

Relacionar pedido-> Token mozo. Ingreso la imagen, el numero de la mesa correspondiente y el area mozo, para guardar en la carpeta FotosPedidos una foto que contiene en el nombre el numero de la meza y la descripcion.

Listar pedidos por area-> Token (cualquier empleado). Muestra los productos pendientes de preparar por cada area ingresada.

Preparar pedidos-> Token (cualquier empleado). Ingresando el area correspondiente, cada empleado tomara el pedido correspondiente con su area y lo comenzara a preparar asignandole un tiempo estimado de finalizacion y el empleado estableciendo su estado en Ocupado. (Si todos los empleados de un area estan ocupados, no podran tomar el pedido hasta que finalicen y esten 'Libres').

Cliente consulta demora-> Sin token. Ingresando el id del pedido y el id de la mesa, se consultara el estado de la mesa actualmente.

Socio consulta pedidos-> Token admin. Ingresando el id del pedido y el id de la mesa, se consultara el estado del pedido.

Empleados listos para ervir-> Token (cualquier empleado). Cada empleado de cada area, debe avisar que ha terminado la preparacion del pedido. Cuando lo notifique en el sistema, su estado pasara a ser libre y podra tomar otro pedido cuando quiera. Los productos preparados por su area se pondran en listos para servir.

Servir mesa-> Token mozo. El mozo chequeara que los productos esten listos para servir, y pasara el estado del pedido a Servido.

Cobrar mesa-> Token mozo. El mozo cobrara la mesa, y pasara el estado del pedido a Cobrado.
