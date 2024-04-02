<script lang="ts">

import { writable } from "svelte/store";
import { onMount } from "svelte";
import { llamadaendpoinds } from "../../../../helpers/llamadoapiwordpress";

let faqhome = writable(null)
let datosfaq : any;

let firstFAQOpened = false; // Track if the first FAQ item is opened

export let logotexto : string


    onMount( async() => {
   datosfaq = await llamadaendpoinds('myroutes/faq');
   faqhome.set(datosfaq) 
   
//    setTimeout(() => {
//             if (datosfaq.length > 0 && !firstFAQOpened) {
//                 const primeraTabla = document.querySelector('.containerindividuellefaq') as HTMLLIElement;
//                 const obtenerIcono = document.querySelector('.iconocerrarabrirfaq') as HTMLElement;
//                 const h4 = document.querySelector('.titleundlogofaq h4') as HTMLElement;

//                 if (primeraTabla && obtenerIcono && h4) {
//                     primeraTabla.style.height = `${primeraTabla.scrollHeight}px`;
//                     obtenerIcono.classList.add('iconoabrirycerraractivefaqactive');
//                     h4.classList.add('aqua-text');

//                     firstFAQOpened = true; // Mark the first FAQ as opened
//                 }
//             }
//         });

    });


    const abrirMenuDespregablefaq = (e: MouseEvent) => {
    const liElement = e.currentTarget as HTMLLIElement;
    const obtenerIcono = liElement.querySelector('.iconocerrarabrirfaq') as HTMLElement;
    const todosLosdivfaq = document.querySelectorAll('.containerindividuellefaq') as NodeListOf<HTMLLIElement>;

    // Cerrar todos los acordeones y restablecer el icono
    todosLosdivfaq.forEach(li => {
        if (li !== liElement) {
            li.style.height = '80px';
            const icono = li.querySelector('.iconocerrarabrirfaq') as HTMLElement;
            icono.classList.remove('iconoabrirycerraractivefaqactive');

            const h3 = li.querySelector('h4') as HTMLElement;
            h3.classList.remove('aqua-text');

        }
    });

    // Abrir o cerrar el acordeón clicado y cambiar el icono
    const height = liElement.offsetHeight === 80 ? liElement.scrollHeight : 80;
    liElement.style.height = `${height}px`;
    obtenerIcono.classList.toggle('iconoabrirycerraractivefaqactive');

    const h4 = liElement.querySelector('h4') as HTMLElement;
    h4.classList.toggle('aqua-text');

};


</script>

<div class="allesinfaq">
<div class="containfaq">
    <div class="titleveschreibung">
<h2>
Faq
</h2>
<p>In diesem Abschnitt werden wir die häufigsten Fragen beantworten</p>
    </div>
    {#if $faqhome != null}
    <div class="contenidoindividual">
<div class="lineapink">
</div>
<div class="inhaltindividuellfaq">
{#each datosfaq as data }
    <div class="containerindividuellefaq" on:click={abrirMenuDespregablefaq}>
        <div class="titleundlogofaq">
<h4>{data.title}</h4>
<img class="iconocerrarabrirfaq" src={data.thumbnail} alt="logo">
</div>

    <div class="logotextofaq">
        <img src={logotexto} alt="logotexto">
        <p>{data.content}</p>
    </div>

    </div>
{/each}
</div>
<div class="bottom">
    <a href="/#">Kontakt</a>
</div>
    </div>
    {/if}
</div>
</div>