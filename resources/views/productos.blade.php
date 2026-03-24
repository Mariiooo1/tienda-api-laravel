
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Tienda Laravel</title>
    <!-- 1. AQUÍ EL CSS -->
    <link href="https://jsdelivr.net" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- 🔝 Navbar -->
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <span class="navbar-brand mb-0 h1"> Mi Tienda</span>
        </div>
    </nav>

    <div class="container">

        <!-- 🛍️ Productos -->
        <h2 class="text-center mb-4">Productos</h2>

        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            
                            <div>
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="text-success fw-bold fs-5">
                                    ${{ $product->price }}
                                </p>
                            </div>

                            <button 
                                class="btn btn-primary w-100"
                                onclick='agregarAlCarrito(@json($product))'>
                                Añadir
                            </button>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 🧾 Carrito -->
        <div class="mt-5">
            <h3>Carrito</h3>
            <div id="carrito" class="mt-3"></div>
        </div>

    </div>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<script>
    let carrito = JSON.parse(localStorage.getItem('carrito'))
    carrito = carrito ? carrito : []

    mostrarCarrito()

    function agregarAlCarrito(product){
        let posicion = carrito.findIndex(item => item.id === product.id)

        if(posicion !== -1){
            carrito[posicion].cantidad++
        } else{
            product.cantidad = 1
            carrito.push(product)
        }

        localStorage.setItem("carrito", JSON.stringify(carrito))
        mostrarCarrito();
    }

    function mostrarCarrito(){
        let divCarrito = document.getElementById("carrito")
        divCarrito.innerHTML = ''

        if(carrito.length === 0){
            divCarrito.innerHTML = `
                <div class="alert alert-warning text-center">
                    El carrito está vacío
                </div>
            `
            return
        }

        carrito.map((item,index) => {
            divCarrito.innerHTML += `
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        
                        <div>
                            <h6 class="mb-1">${item.name}</h6>
                            <small class="text-muted">Cantidad: ${item.cantidad}</small><br>
                            <strong class="text-success">
                                $${item.price * item.cantidad}
                            </strong>
                        </div>

                        <button class="btn btn-outline-danger btn-sm" 
                            onclick="eliminarDelCarrito(${index})">
                            Eliminar
                        </button>

                    </div>
                </div>
            `
        });

        let totalFactura = calcularTotal();

        divCarrito.innerHTML += `
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body text-center">
                    <h4 class="text-success">Total: $${totalFactura}</h4>

                    <a href="/checkout" class="btn btn-success w-100 mt-3">
                         Continuar al pago
                    </a>
                </div>
            </div>
        `;
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