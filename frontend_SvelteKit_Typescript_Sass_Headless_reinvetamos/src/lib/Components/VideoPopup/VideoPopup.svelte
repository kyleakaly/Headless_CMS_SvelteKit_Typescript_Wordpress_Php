<script lang="ts">
    import { onMount } from 'svelte';
    
    export let urlyoutube :any
    export let titulo : string
    export let abrirpopup : boolean
    export let miniaturavideo : string
    export let logotriangulo : string
    export let logovolumen : string
    let abririmagenprevia = false

    let obtenerdivpopup : HTMLElement;
    let anchoDiv : number;

    let iniciarVideo = false;

    onMount(() => {
        // Esperar hasta que el navegador haya completado el renderizado
        requestAnimationFrame(() => {
            // Obtener el ancho del div al que se le aplicará el video
            anchoDiv = obtenerdivpopup.offsetWidth;

            // Iniciar el temporizador para reproducir el video después de 1 segundo
                reproducirVideo();
        });
    });

    function reproducirVideo() {
        // Obtener el iframe del video
        const divpopupimagen = document.querySelector('.container-video-pop-up')
        const iframe = document.querySelector('iframe');
        if (iframe) {
            // Asignar el ancho del div al ancho del iframe
            iframe.width = anchoDiv.toString();
            if (iniciarVideo) {
                iframe.src = `${urlyoutube}?autoplay=1&quality=4k`;
            }
        }
    }

</script>

<div class="videopopup" style="transform:translatex({!abrirpopup ? '-150%)' : '0)'};" bind:this={obtenerdivpopup}>
    <h3>{titulo}</h3>
    {#if abririmagenprevia}
    <div class="container-video-pop-up">
       
        <iframe src={urlyoutube} width={anchoDiv} height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
    </div>
    {/if}
    {#if !abririmagenprevia }
        <div class="imagen-previa">
            <!-- Aquí va tu imagen -->
            <img src={miniaturavideo} alt="Imagen previa">
            <button on:click={() =>{ abririmagenprevia = !abririmagenprevia; iniciarVideo = true; reproducirVideo();}}><div class="triangulo"></div>
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
    
<button class='botoncerrar' on:click={()=> {abrirpopup = !abrirpopup; abririmagenprevia = !abririmagenprevia ; document.body.style.overflow = 'visible' }}>Schließen</button>
</div>

<style lang="scss">
    .videopopup{

        display: grid;
        grid-template-columns:1fr 100px;
        grid-template-rows:20% 80% ;
        
        flex-direction: column;
        position: fixed;
        height: 85vh;
        background-color: black;
        border: 1px solid white;
        width: 95vw;
        bottom:0;
        right:0;
        transition:transform 400ms;
        z-index: 99;

        

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
    position: fixed;
    top: 21%;
    right: 0;
    left: 37%;
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
position: fixed;
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
</style>