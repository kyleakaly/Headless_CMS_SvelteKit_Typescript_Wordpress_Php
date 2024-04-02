<script lang="ts">

import { limpiardatosinputs } from "../../../helpers/limpiardatosinputs";
  import type { newsletter } from "../../../types/newsletter";
  import { writable } from "svelte/store";
    let nombre: string;
    let email : string;
    let newlettercorrect = false
export let newsletterimage : string
let messagenewletterform = ''


    function cleanFormData(nombre: string, email: string, telefono: string): { names: string, email: string} {
    // Sanitizar cada campo del formulario utilizando la función sanitizeInput
    const cleanNombre = limpiardatosinputs(nombre);
    const cleanEmail = email;

    // Devolver un objeto con los datos limpios
    return { names: cleanNombre, email: cleanEmail,  };
}

const errorMessagenewsletter = writable(''); // Variable de estado para el mensaje de error



const handlesubmitnewsletter = async (e: any) => {
    e.preventDefault();

if (!nombre || !email) {
    newlettercorrect = !newlettercorrect
    messagenewletterform = 'Einige Felder fehlen, bitte geben Sie alle Daten ein.'
                console.error('Einige Felder fehlen, bitte geben Sie alle Daten ein.');
                setTimeout(() => {
                    messagenewletterform = ''
                    newlettercorrect = !newlettercorrect

                },3000)

return;
}



const nombreInput = nombre.trim();
        const emailInput = email.trim();

        // Limpiar los datos utilizando la función cleanFormData
        const cleanData = cleanFormData(nombreInput,emailInput);

const datosnachrichteneue : newsletter =  cleanData


    try {
        // Enviar los datos limpios a un servidor
        const response = await fetch(import.meta.env.VITE_URL_BACKEND+'myroutes/newsletterguardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(datosnachrichteneue)
        });

        if (response.ok) {
            console.log('Formulario enviado correctamente');
            messagenewletterform = 'Du hast dich erfolgreich für den Newsletter angemeldet!'
            newlettercorrect = !newlettercorrect
            setTimeout(() => {
    nombre = '';
    email = ''
    messagenewletterform = ''
    newlettercorrect = !newlettercorrect

}, 3000);
        } else {
            
            console.error('Error al enviar el formulario');
        }
    } catch (error) {
        console.log('Error en el manejo del formulario:', error);
    }
}


</script>



<div class="todoneletter">

    <div class="newslettercomplete">
        <h2>Newsletter</h2>
        <p>Möchten Sie die neuesten Trends im SEO und Marketing erhalten?</p>
    </div>
    
    <div class="formNewletter">
    
       
    
        <form on:submit={handlesubmitnewsletter} >
        
            <input type="text" name="name" id="name"  bind:value={nombre} placeholder="Ihrem Name">
            <input type="email" name="email" id="email"  bind:value={email} placeholder="Ihre Email">
            <div class="contenidoimagenboton">
                <img src={newsletterimage} alt=flechabuttom>
            <button type="submit">zu abonnieren</button>

            </div>
    
        </form>
        {#if newlettercorrect}
        <did class="suscritoanewsletter">
            <p>{messagenewletterform}</p>
        </did>
        {/if}
    </div>

</div>


<style lang="scss">

.todoneletter{
    border: 1px solid white;
padding: 24px;
    display: flex;
flex-direction: column;
margin-left: 24px;
gap: 24px;
margin-top:24px ;

.newslettercomplete{

    h2{
        font-size: 4.8rem;

    }

}
    .formNewletter{


    display: flex;
    flex-direction: column;
    flex-wrap: nowrap;

    .foto{
        img{
            width: 60%;
            margin: 0px auto;
        }
    }

    form{
        display: flex;
        flex-direction: column;
        gap: 24px;
        input{
            background-color: rgba($color: #000000, $alpha: 0.4);
            border: none;
            padding: 4px;
            border-bottom: 1px solid white;
            font-size: 18px;

           color: white;
            
        }

        ::placeholder{
            color: rgb(177, 177, 177);
        }

        .contenidoimagenboton{

            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: flex-end;
            gap: 10px;

            img{
                width: 100px;
                height: 100%;
            }

            button{
            background-color: black;
            color: white;
            padding: 8px;
    border: 1px solid white;
    font-size: 2.4rem;
    text-align: left;
    width: 100%;
    height: 20%;
    text-align: center;
        }
        }

     
    }

}

.suscritoanewsletter{

    margin-top: 24px;
    color: lime;
    font-size: 18px;

}

}



</style>