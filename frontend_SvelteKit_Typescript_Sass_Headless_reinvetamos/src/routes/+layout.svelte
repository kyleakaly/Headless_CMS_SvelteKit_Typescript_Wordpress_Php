<script lang="ts">
    import Footer from '$lib/Components/Layout/Footer.svelte';
    import Particulas from '$lib/Components/Particulas.svelte';
    import '../../src/style.scss'
    import Menuescritorio from '$lib/Components/Menu/Menuescritorio.svelte';
    import { onDestroy,onMount } from 'svelte';
    import { resolution } from '../store/resolutionstore';
    import MenuMovil from '$lib/Components/Menu/MenuMovil.svelte';

    //variables
    export let data 
    
 // Definimos una variable reactiva para almacenar la resolución actual
 let currentResolution = { width: 0, height: 0 };

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


let lastScrollTop = 0;

const handleScrollHeaderTramfors = () => {
    const fixemenu = document.querySelector('.header');
    const top = fixemenu.offsetTop;

    function scroll(event) {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop >= top + 100) {
            fixemenu.classList.add('cambiarApariencia');
        } else {
            fixemenu.classList.remove('cambiarApariencia');
        }
    }

    scroll(); // Llamar a la función scroll para establecer la clase inicialmente
}
    </script>

<svelte:window on:scroll={handleScrollHeaderTramfors} />

    <header class="header">

        <div class="header-container {$resolution.width < 820 ? 'header-containermobil' : ''}">
        {#if $resolution.width < 820}
      <MenuMovil data={data}  />
    {:else}
    <div class="logo"><span>
      <img src={data.menu.custom_logo} alt='logo' width="200"> 
  </span></div>
    <Menuescritorio data={data} />          
    {/if}

        
</div>
    </header>
      <!-- <Particulas/>  -->
    
    <div class="containermain" >
        <slot/>
    </div>

    <Footer/> 

    <style lang="scss">
        header{
display: flex;
flex-direction: row;
flex-wrap: nowrap;
gap: 10px;
justify-content: space-between;
align-items: center;




}

        .containermain{
            margin: 24px 0px 24px 0px;
            margin-top: 130px;

        }
       
    </style>
    
