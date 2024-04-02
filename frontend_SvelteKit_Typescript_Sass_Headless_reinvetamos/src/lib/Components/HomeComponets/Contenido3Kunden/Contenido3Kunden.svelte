<script lang="ts">
    import { llamadaendpoinds } from "../../../../helpers/llamadoapiwordpress";
    import { onDestroy, onMount } from "svelte";
    import { writable } from "svelte/store";
    import { resolution } from "../../../../store/resolutionstore";

    export let dataclientes = writable(null);
    let datos: any
    export let titleclientes : string
    export let texteparrafokunden : string
    export let logotexto : string
    export let logotriangulo : string
    export let logovolumen : string
    

    let isH3Fixed = false
let originalH3Top = 0
    onMount( async() => {
  datos =  await llamadaendpoinds('myroutes/clientes');
         dataclientes.set(datos)

         const h3 = document.getElementById('mih3');
    if (h3) {
        originalH3Top = h3.getBoundingClientRect().offSetTop ;
        console.log(originalH3Top)

    }

    requestAnimationFrame(() => {
            // Obtener el ancho del div al que se le aplicará el video
            anchoDiv = obtenerdivpopup.offsetWidth;

            // Iniciar el temporizador para reproducir el video después de 1 segundo
            reproducirVideoskunden();
        });

        abrirImagenPrevia = new Array(datos.length).fill(false);

});





let anchoDiv : number;
let obtenerdivpopup : HTMLElement;
let iniciarVideos : boolean = false;
let abrirImagenPrevia : boolean[] = [];


function toggleAbrirImagen(index) {
    abrirImagenPrevia[index] = !abrirImagenPrevia[index];
  }


function reproducirVideoskunden() {
        // Obtener el iframe del video
        const divpopupimagen = document.querySelector('.container-video-pop-up')
        const iframe = document.querySelector('iframe');
        if (iframe) {
            // Asignar el ancho del div al ancho del iframe
            iframe.width = anchoDiv.toString();
        }
    }


    let currentIndex = 0; // Índice de la tabla actualmente mostrada

    // Función para cambiar a la tabla siguiente
    const cambiarTablaDerecha = () => {
        if (currentIndex < $dataclientes.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // Vuelve al inicio si ya estás en la última tabla
        }
    };

    // Función para cambiar a la tabla anterior
    const cambiarTablaIzquierda = () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = $dataclientes.length - 1; // Vuelve al final si ya estás en la primera tabla
        }
    };


    const handleTouchMove = (event: TouchEvent) => {
        const touch = event.touches[0];
        const startX = touch.clientX;
        let deltaX = 0;

        const handleTouchEnd = () => {
            if (Math.abs(deltaX) > 50) { // Se considera un cambio de tabla si el desplazamiento es mayor a 50px
                if (deltaX > 0) {
                    cambiarTablaDerecha();
                } else {
                    cambiarTablaIzquierda();
                }
            }
            document.removeEventListener('touchmove', handleTouchMove);
            document.removeEventListener('touchend', handleTouchEnd);
        };

        document.addEventListener('touchmove', (moveEvent: TouchEvent) => {
            deltaX = moveEvent.touches[0].clientX - startX;
        });
        document.addEventListener('touchend', handleTouchEnd);
    };

    

    let currentResolution  = { width: 0, height: 0 };

 function handleResolutionChange() {
    // Actualiza el store `resolution` con la resolución actual
    resolution.set({ width: window.innerWidth, height: window.innerHeight });
}

// Suscribimos al store y actualizamos la resolución actual
const unsubscribe = resolution.subscribe(value => {
  currentResolution = value;
});

// Desuscribimos cuando el componente se destruye para evitar memory leaks
onDestroy(() => {
  unsubscribe();
});

// Actualizamos la resolución cuando el componente se monta
onMount(() => {
  handleResolutionChange()
  currentResolution = resolution;
});

// Mostrar el valor de la altura de resolución
$: if (currentResolution) {
  console.log(currentResolution.width);
}  


</script>




<div class="contenido2completo container3completo" on:touchmove={handleTouchMove}>
    {#if $dataclientes != null} <!-- Espera a que dataServices tenga un valor antes de renderizar -->
        <div class="textoscontenido2 textoscontenido3">
            <div class="h2-container">
                <h2 id='mih3'>{titleclientes}</h2>

            </div>
            <div class="textoconlogo">
                <!-- <p>{texteparrafokunden}</p> -->
            </div>
        </div>
<div class="crearbotonesdekunden">
{#if $resolution.width < 820}
<button class="izquierdoboton" on:click={cambiarTablaIzquierda}><span>{'<<'}</span></button>
{/if}


    <div class="serviciosccompletos">
        {#each datos as data,index (data.id)}
            <div class="servicioscajaindividual serviciocajaindividual3" style={index === currentIndex ? 'display: grid;' :  $resolution.width < 820 ? 'display: none;' : 'display: flex;' }>

                <h3 class="tituloservices">{data.title}</h3>
<div class="textologoservices">
<div class="videopopup" bind:this={obtenerdivpopup}>

    {#if abrirImagenPrevia[index]}
    <div class="container-video-pop-up iframe-container">
       {#if $resolution.width < 820 }
        <iframe src={data.urlvideokunden} width="720" height="1270" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
    {/if}

    </div>
    {/if}
    {#if !abrirImagenPrevia[index] }
        <div class="imagen-previa">
            <!-- Aquí va tu imagen -->
            <img src={data.thumbnail} alt="Imagen previa">
   
    <button on:click={() =>{ $resolution.width < 820 ? toggleAbrirImagen(index) : null}}><div class="triangulo"></div>
            </button>
            <div class="logosvolumentiniciar">
                <img class="volumen" src={logovolumen} alt="lautstaerke-logo">
                <div class="reproducciones">
                    <img src={logotriangulo} alt="kleine Dreieck">
                    <p>10 TSD</p>
                </div>
            </div>
        </div>
        {/if}
</div>

</div>
            </div>
        {/each}
    </div>

    {#if $resolution.width < 820}
    <button class="derechoboton"  on:click={cambiarTablaDerecha}><span>{'>>'}</span></button>

{/if}



</div>
        

    {/if}
</div>



<style lang="scss">

.container3completo{
   .serviciosccompletos{
    height: 100%;
    min-height: none!important;;
    max-height: none;
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow-x: hidden;
   }

.tagsKunden{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: flex-start;
    gap: 20px;
    align-items: baseline;
}

.serviciocajaindividual3{
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 10% 85% ;
    gap: 5%;
    flex-direction: column;
    height: 100%;
    border:none;

.imagen-previa{

height: 100%;
padding-bottom: 0;

}
.textologoservices{
    flex-direction: column;
}

h3{
        font-size: 3rem;
        justify-self: center;
        text-align: center;
    }

}

.videopopup{
    display: flex;
    justify-content: center;
  height: 60vh;
}

}
    .videopopup{

      
        
        flex-direction: column;
        height: 80vh;
        background-color: black;
        width: 100%;
        bottom:0;
        right:0;
        transition:transform 400ms;
        

        

        h3{

            grid-column: 1 / 3;
            grid-row: 1 / 2;
            width:100%;
            margin-left:36px;
            margin-top:36px;
            margin-bottom:36px;
            font-size:4.8rem;
            

        }
        
        .imagen-previa{

            grid-column: 1 / 3;
  grid-row: 2 / 3;
            object-fit:cover;
            width:90%;
            height:100%;
            position:relative;
    padding-bottom:24px;
    justify-self: center;
        align-self: center;
        &::before{

content: "";
    position: absolute;
    top: 0;
    right: 0;
    left: 30%;
    bottom: 0;
    background-color: white;
    z-index: 2;
    height: 24px;
    width: 100px;
    border-radius: 0px 0px 10px 10px;

}
      

            img{
                height: 100%;
    object-fit: cover;
    border:12px solid white;
    border-radius:60px;
    position: relative;
        z-index: 1;

             

            }

            .logosvolumentiniciar{
display: flex;
flex-direction: row;
flex-wrap: nowrap;
justify-content: space-between;
margin-left: 20px;
margin-right: 20px;
position: absolute;
bottom: 8%;
left: 6%;
z-index: 9;
width: 75%;

                img.volumen{
                    border:none;
                }
                .reproducciones{
                    display: flex;
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: baseline;
                    align-items: center;
                    gap:2px;

img{
   
    height: auto; 
    width: 20px;
    border:none;
}

            }

         
            }

        }

        .container-video-pop-up{
            
            grid-column: 1 / 3;
  grid-row: 2 / 3;
        }
       
        button{
z-index:3;
            width:80px;
            height:80px;
            color:white;
            background-color:#89004F;
            border:none;
            border-radius:100%;

            position: absolute;
    top: 50%; /* Posiciona el botón en la mitad vertical */
    left: 50%; /* Posiciona el botón en la mitad horizontal */
    transform: translate(-50%, -50%);
    overflow: hidden;

    .triangulo {
        position: absolute;
  top: 50%; /* Posiciona el triángulo en la mitad vertical */
  left: 55%; /* Posiciona el triángulo en la mitad horizontal */
  transform: translate(-50%, -50%) rotate(90deg); /* Gira el triángulo 90 grados */
  width: 0;
  height: 0;
  border-left: 20px solid transparent; /* Lado izquierdo transparente */
  border-right: 20px solid transparent; /* Lado derecho transparente */
  border-bottom: 40px solid white; /* Base del triángulo */
}

        }

        .botoncerrar{
            height:40px;
            grid-column: 1 / 2;
            grid-row: 1 / 2;
            top: 0; /* Posiciona el botón en la mitad vertical */
    left: 10%; /* Posiciona el botón en la mitad horizontal */
    bottom:0;
    right:0;
    transform: translate(-50%, -50%);
    border-radius:0;
    background-color:aqua;
    color:black;
    font-weight:bold;
        }

        iframe{

            height:100%;
            contain: content;

        }

    }

    .iframe-container {
    position: relative;
    width: 100%;
    
    height: 100vh;/* Esto establece una proporción de 16:9 para el iframe (9/16 = 0.5625) */
    overflow: hidden;
}

.iframe-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}


@media(min-width:1100px){

    .container3completo .serviciocajaindividual3{
            display: flex!important;
            min-width: 20%!important;
           }

}

</style>