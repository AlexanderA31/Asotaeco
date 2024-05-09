<style>
    /* styles.css */
    #loader {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.96);
        z-index: 9999;
        display: none;
        /* Oculto inicialmente */
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 8px solid rgba(0, 0, 0, 0.1);
        border-left-color: #333;
        border-radius: 50%;
        width: 15vh;
        height: 15vh;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>


<div id="loader">
    <img src="../../public/images/icons/logo.png" class="position-absolute" style="height: 14vh;" alt="Icono de carga">
    <div class="spinner position-absolute" role="status">
    </div>
</div>


<script>
    let timeS = 1000;
    setLoading(true);

    function setLoading(loading) {
        var loader = document.getElementById("loader");
        if (loading) {
            loader.style.display = "flex"; /* Cambia a flex para mostrar */
            setTimeout(function() {
                setLoading(false);
                timeS = 1000;
            }, timeS); // 10 segundos en milisegundos
        } else {
            loader.style.display = "none";
        }
    }
</script>