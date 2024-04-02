<script lang="ts">

import { writable } from "svelte/store";
import { onMount } from "svelte";
import { llamadaendpoinds } from "../../../../helpers/llamadoapiwordpress";
import instagramlogo from '../../../../img/instagramlogo.png'
import linkedinglogo from '../../../../img/linkdlinicons.png'
import youtubelogo from '../../../../img/youtubelogo.png'

let ueberunshome = writable(null)
let datosueberuns : any;

onMount( async() => {
    datosueberuns = await llamadaendpoinds('myroutes/ueberuns');
    ueberunshome.set(datosueberuns) 

})

</script>

<div class="vollstaendigerinhaltueberuns">
   <div class="titleundkleinebeschreibungen">
    <h2>über Uns</h2>
    <p>Appletonmarks ist ein kleines Unternehmen mit innovativen Ideen.</p>
   </div>
   {#if $ueberunshome != null}
   <div class="alleskartenindividuellen">
    {#each datosueberuns as daten }
    
    <div class="erhaltindividuelleueberuns">

        <img class="bildervonarbeitern" src={daten.thumbnail} alt="bildervonarbeitern">

        <div class="textos">
            <h3>{daten.title}</h3>
            <p>{daten.content}</p>
            <div class="role"> <span>Role:</span>  <span class="roles">{daten.gebuhren}</span> </div>
        </div>

        <div class="socialmedienueberuns">

            {#if daten.instagramueberuns}
            <div class="socialmedienallgemeiden">
                <a href={daten.instagramueberuns} >
                 <img src={instagramlogo} alt="iconsocial"> </a>

            </div>

            {/if}

            {#if daten.linkedinueberuns}
            <div class="socialmedienallgemeiden">
                <a href={daten.linkedinueberuns}>
                <img src={linkedinglogo} alt="iconsocial">

                </a>

            </div>
            {/if}
            {#if daten.youtubeueberuns}
            <div class="socialmedienallgemeiden">
                <a href={daten.youtubeueberuns}>
                <img src={youtubelogo} alt="iconsocial">

                </a>

            </div>
            {/if}
        </div>

    </div>

    {/each}
   </div>
   {/if}
</div>