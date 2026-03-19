
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Tienda Laravel</title>
    <!-- 1. AQUÍ EL CSS -->
    <link href="https://jsdelivr.net" rel="stylesheet">
</head>
<body>

    <div class="container">
        @yield('content') 
        <!-- Aquí es donde Laravel mete el contenido de tus otras vistas -->
    </div>

    <!-- 2. AQUÍ EL JS -->
    <script src="https://jsdelivr.net"></script>
    <h1>Aqui van los productos listados</h1>


<div id="carrito">

</div>

 @foreach($products as $product)
    <ul>
        <li>
            {{ $product->name }}
            ||
            {{ $product->price }}
            <button onclick="agregarAlCarrito({{ $product }})">Añadir al carrito</button>
        </li>
    </ul>
@endforeach

</body>
</html>

<script>
    let carrito = JSON.parse(localStorage.getItem('carrito'))
    carrito = carrito ? carrito : []
    console.log("carrito",carrito)
    mostrarCarrito()
    function agregarAlCarrito(product){
        let posicion = carrito.findIndex(item => item.id === product.id)
        if(posicion !== -1){
            carrito[posicion].cantidad++
        } else{
            product.cantidad = 1
            carrito.push(product)
        }
        localStorage.setItem("carrito",JSON.stringify(carrito))
        console.log(carrito)
        mostrarCarrito();
    }

    function mostrarCarrito(){
        let divCarrito = document.getElementById("carrito")
        let subtotal    
        divCarrito.innerHTML = ''
        carrito.map( (item,index) => {
            divCarrito.innerHTML += `<p>${item.name} : ${item.cantidad}
            <button class="btn btn-danger" onclick="eliminarDelCarrito(${index})">Eliminar</button> <br>
            Subtotal: ${item.price * item.cantidad} </p> <hr>`
        });

        let totalFactura = calcularTotal();
        divCarrito.innerHTML += `<p>Total: $${totalFactura}</p>`;
    }

    function eliminarDelCarrito(posicion){
        carrito.splice(posicion, 1)  
        localStorage.setItem("carrito", JSON.stringify(carrito))
        mostrarCarrito()
    }

    function calcularTotal(){
        let subtotal = 0
        carrito.forEach(item => {
            subtotal += item.price * item.cantidad
        });
        return subtotal;
    }
</script>

