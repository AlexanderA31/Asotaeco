<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
            <span class="mtext-103 cl2">
                Mi Carrito
            </span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul id="cartList" class="header-cart-wrapitem w-full">
            </ul>

            <div class="w-full">
                <div id="totalPagar" class="header-cart-total w-full p-tb-40">
                </div>

                <?php
                if (!empty($_SESSION['user_session'])) {
                ?>

                    <a href="../shoping-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        Comprar Ahora
                    </a>
                <?php
                } else {
                ?>
                    <a href="../login" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        Inicia sesión para comprar
                    </a>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    const ulCarrito = document.getElementById('cartList');
    const divTotalPagar = document.getElementById('totalPagar');

    let cart = JSON.parse(localStorage.getItem('cart'));
    reloadCart();

    function crearElementoProducto(producto) {
        const liProducto = document.createElement('li');
        liProducto.classList.add('header-cart-item', 'flex-w', 'flex-t', 'm-b-12');

        const imagenProducto = producto.img ?
            producto.img :
            "../../public/images/products/defaultprod.png";
        liProducto.innerHTML = `
            <div onclick="eliminarProductoCarrito(${producto.id})" id="img_prod" class="header-cart-item-img">
                <img src="${imagenProducto}" alt="IMG">
            </div>
            <div class="header-cart-item-txt p-t-8">
                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">${producto.nombre}</a>
                <span class="header-cart-item-info">${producto.cantidad} x ${producto.precio_venta}</span>
                <button class="eliminar-producto" onclick="eliminarProductoCarrito(${producto.id})">Eliminar</button>
            </div>
        `;

        return liProducto;
    }



    function actualizarTotal(cart) {
        let total = 0;
        cart.forEach(producto => {
            total += producto.cantidad * parseFloat(producto.precio_venta);
        });
        divTotalPagar.textContent = `Total: $${total.toFixed(2)}`;
    }


    function reloadCart() {
        try {
            const notifyCart = document.getElementById('notify_cart');
            const cart = JSON.parse(localStorage.getItem('cart'));
            if (cart && cart.length > 0) {
                notifyCart.setAttribute('data-notify', cart.length);
                ulCarrito.innerHTML = '';
                cart.forEach(producto => {
                    const liProducto = crearElementoProducto(producto);
                    ulCarrito.appendChild(liProducto);
                });
                actualizarTotal(cart);
            } else {
                notifyCart.setAttribute('data-notify', 0);
                ulCarrito.innerHTML = ''; // Limpiar el contenido del carrito
                const liVacio = document.createElement('li');
                liVacio.textContent = 'Tu carrito está vacío';
                ulCarrito.appendChild(liVacio);
                divTotalPagar.textContent = 'Total: $0.00';
            }
        } catch (error) {
            swal(
                "Ups! Algo salió mal!",
                "La acción no se pudo realizar correctamente!" + error,
                "error"
            );
        }
    }



    function addToCart(productDetails) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.push(productDetails);
        localStorage.setItem('cart', JSON.stringify(cart));
        reloadCart();


    }


    function eliminarProductoCarrito(id) {
        let cart = JSON.parse(localStorage.getItem("cart"));
        cart = cart.filter(producto => producto.id !== id);
        localStorage.setItem("cart", JSON.stringify(cart));
        reloadCart();

    }
</script>