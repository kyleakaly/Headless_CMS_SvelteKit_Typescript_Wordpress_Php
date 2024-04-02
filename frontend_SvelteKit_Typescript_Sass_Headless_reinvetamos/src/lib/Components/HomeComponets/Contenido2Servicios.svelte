<script lang="ts">
    import { onMount } from "svelte";
    import { writable } from 'svelte/store'; // Importa la función 'writable' para crear una variable reactiva
    import ContenidomenuDespregable from "./ContenidomenuDespregable/ContenidomenuDespregable.svelte";
    import { llamadaendpoinds } from "../../../helpers/llamadoapiwordpress";

    export let titleservice: string;
    export let texteparrafoservices: string;
    export let logotexto : string


    export let dataServices = writable(null); // Inicializa dataServices como una variable reactiva
    let datos : any[] 


  

onMount( async() => {
     datos = await llamadaendpoinds('myroutes/services');
     dataServices.set(datos)
});

</script>

<div class="contenido2completo">
    {#if $dataServices != null} <!-- Espera a que dataServices tenga un valor antes de renderizar -->
        <div class="textoscontenido2">
            <div class="h2-container">
                <h2 id='mih2'>{titleservice}</h2>

            </div>
            <div class="textoconlogo">
                <p>{texteparrafoservices}</p>
            </div>
        </div>

        <div class="serviciosccompletos">
            {#each datos as data}
                <div class="servicioscajaindividual">

                    <h2 class="tituloservices">{data.title}</h2>
<div class="textologoservices">
    <img src={logotexto} alt='icon'>

    <p class="parrafo1servicesdetail">
{data.texten1diens}
    </p>
</div>

<div class="textologoservices">
    <img src={logotexto} alt='icon'>

    <p class="parrafo1servicesdetail">
{data.texten2diens}
    </p>

</div>

<ContenidomenuDespregable datoslista={data.menudespreglable}  />

<a href={`${import.meta.env.VITE_PROD_URL}services/${data.slug}`}>{data.namebotonservices}</a>

                </div>
            {/each}
        </div>

    {/if}
</div>

<style lang="scss">

@media only screen and (min-width: 1100px) {



}

</style>