<script lang="ts">

import { onMount,onDestroy } from "svelte";
import { writable } from "svelte/store";
    export let dataprocess = writable(null); // Inicializa dataServices como una variable reactiva
    let datos : any[] 
    export let logotexto : string
    let observer: IntersectionObserver;
    


    
    const cargardatosprocesos = async (): Promise<void> => {
        try {
            const res = await fetch(import.meta.env.VITE_URL_BACKEND+'myroutes/process');
            const data = await res.json();
        
            dataprocess.set(data);
            datos = data.reverse()
        } catch (error) {
            console.error('Error al realizar la solicitud:', error);
            throw error;
        }
    }
  
    onMount(async () => {
        await cargardatosprocesos();
        
        observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                    entry.target.classList.add('active'); // Agregar una clase cuando esté en la vista
                        
                    }, 1000);
                } else {
                    entry.target.classList.remove('active'); // Remover la clase cuando no esté en la vista
                }
            });
        }, { rootMargin: '600px 0px 0px 0px' }); // Definir un margen superior de 200px

        document.querySelectorAll('.procesosindividuales').forEach(element => {
            observer.observe(element);
        });
    });

    onDestroy(() => {
        if (observer) {
            observer.disconnect();
        }
    });
</script>

{#if $dataprocess != null}
<div class="procesosmaincontainer">
<h2>Procesos</h2>
<div class="procesostotales">
    {#each datos as data , i }
    <div class="procesosindividuales" style="order: {data.indexproceso} ">
        <div class="contenedorbarra">
            <!-- <div class="barra" style="height: {(i + 1) / datos.length * 100}% "></div> -->
            <span>{data.indexproceso}</span>
        </div>
        <div class="contenido">
            <div class="tittle">
                <h3 class="title-Process">{data.title}</h3>
            </div>
<div class="logotextoprocess">
 <img src={logotexto} alt="logotexto">
 <p>{data.content}</p>
</div>
            {#if data.thumbnail}
<div class="imageprocess"> <img src={data.thumbnail} alt=""> </div>
            {/if}
        
    
</div>
    </div>
    {/each}
</div>
</div>

{/if}