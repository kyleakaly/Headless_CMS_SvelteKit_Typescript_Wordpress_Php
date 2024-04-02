<script lang="ts">
    import { onDestroy, onMount } from "svelte";


    import VideoPopup from "../VideoPopup/VideoPopup.svelte";
    import { resolution } from "../../../store/resolutionstore";
    import Blogseccion from "./Blogseccion/Blogseccion.svelte";
    

    export let title :string
    export let keywords1 :string
    export let keywords2 :string
    export let keywords3 : string
    export let keywords4 : string
    export let keywords5 : string
    export let beschreibung :string
    export let imagen1 :  string
    export let imagen2 :  string
    export let imagen3 :  string
    export let imagen4 :  string
    export let imagen5 :  string
    export let logotexto : string
    export let flecha : string
    export let miniaturavideo : string
    export let urlvideo : string
    export let titulo_video : string
    export let logoabrirpopup :  string
    export let logovolumen : string
    export let logotriangulo : string

    let texto : any;
    let flechaposicion:any;
    let abrirpopup : false


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
  console.log(currentResolution.height);
}  



</script>

<div class="contenido1completo">
    <div class="contenido1">
        <div class="letrasreunidasjuntos">
            <div class="letras">
                <h1>{title}</h1 >
                <div class="space"></div>
                <div class="contenidocontexto">
                    <div class="gridimagenes">
                    <img class="google" src={imagen1} alt={keywords1}>
                    <img class="chatgpt" src={imagen2} alt={keywords2}>
                    <img class="gemini" src={imagen3} alt={keywords3}>
                    <img class="tiktok" src={imagen4} alt={keywords4}>
                </div>
                <div class="textocontent1">
                    <img src={logotexto} alt='icon'>
                    <p>{beschreibung}</p>
    
                </div>
                </div>
               
                
            </div>
    
            {#if $resolution.width > 1100}
            <div class="videosoloversionescritorio">
                <iframe src={urlvideo} width="200px" height="564" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
            {/if}

        </div>

        

    

        {#if $resolution.width < 820}
        
        <div class="flecha">
            <img src={flecha} alt='flecha' bind:this={flechaposicion} class={abrirpopup ? 'arrow moverflecha' : 'arrow devolverflecha'}>
            <span bind:this={texto} on:click={()=> {abrirpopup = !abrirpopup; document.body.style.overflow = 'hidden'}}><span class="kurz">kurz</span> <img class='vervideo' src={logoabrirpopup} alt='flecha'/><span class="video">Video</span> </span>
        </div>

        {/if}
    </div>


</div>

{#if $resolution.width < 820}

<VideoPopup titulo={titulo_video} 
urlyoutube={urlvideo} 
abrirpopup={abrirpopup} 
miniaturavideo={miniaturavideo} 
logotriangulo={logotriangulo} 
logovolumen={logovolumen} />
{/if}
<style lang="scss">

.contenido1completo{
        width: 100%;

      
    }
    .contenido1{
            .letras{
                p{
                    width: 40%;
                }
            }

            @media(min-width:722px){
    h1{
    font-size: 6.6rem;
}
h2{
    span{
    font-size: 2.8rem;
}
}

p{
    font-size: 2rem;
}
}
        }

        .vervideo{

height:60px;


}

</style>