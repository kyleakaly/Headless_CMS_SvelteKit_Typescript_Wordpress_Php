<script lang="ts">

    import { limpiardatosinputs } from "../../../../helpers/limpiardatosinputs";

      import { writable } from "svelte/store";
    import type { kontakthaupt } from "../../../../types/kontakthaupt";
        let nombre: string;
        let email : string;
        let nachrichten : string;
        let formcorrect = false
        let formincorrect = false
    export let newsletterimage : string
    let messageform = ''
    
    
        function cleanFormData(nombre: string, email: string, nachrichten : string ): { names: string, email: string, nachrichten : string, _wpcf7_unit_tag:string} {
        // Sanitizar cada campo del formulario utilizando la función sanitizeInput
        const cleanNombre = limpiardatosinputs(nombre);
        const cleanEmail = email;
        const cleannachrichten = nachrichten;
    
        // Devolver un objeto con los datos limpios
        return { names: cleanNombre, email: cleanEmail, nachrichten : cleannachrichten, _wpcf7_unit_tag : 'wpcf7-70b5a13-765'};
    }
    
    const errorMessageform = writable(''); // Variable de estado para el mensaje de error
    
    
    
    const handlesubmitnewsletter = async (e: any) => {
        e.preventDefault();
        if(!nombre || !email || !nachrichten){
        formcorrect = !formcorrect
                messageform = 'Einige Felder fehlen, bitte geben Sie alle Daten ein.'
                console.error('Einige Felder fehlen, bitte geben Sie alle Daten ein.');
                setTimeout(() => {
                    formcorrect = !formcorrect

                },3000)
    return;
    
    
    }
    
    const nombreInput = nombre.trim();
            const emailInput = email.trim();
            const nachrichtenInput = nachrichten;
           
    
            // Limpiar los datos utilizando la función cleanFormData
            const cleanData = cleanFormData(nombreInput,emailInput,nachrichtenInput);
            console.log(cleanData)
    
    const datosnachrichteneue : kontakthaupt =  cleanData
    console.log(datosnachrichteneue)

    
    
        try {
            // Enviar los datos limpios a un servidor
            const response = await fetch(import.meta.env.VITE_URL_BACKEND+'contact-form-7/v1/contact-forms/100/feedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datosnachrichteneue)
            });
    
            if (response.ok) {
                console.log('Formulario enviado correctamente');
                formcorrect = !formcorrect
                setTimeout(() => {
        nombre = '';
        email = ''
        nachrichten = ''
        messageform = 'Te suscribiste correctamente al newsletter'
        formcorrect = !formcorrect
        
    
    }, 3000);
            } else {
                formcorrect = !formcorrect
                messageform = 'Error al enviar el formulario'
                console.error('Error al enviar el formulario');
                setTimeout(() => {
                    formcorrect = !formcorrect

                },3000)

               
            }
        } catch (error) {
            console.log('Error en el manejo del formulario:', error);
        }
    }
    
    
    </script>
    
    <div class="todoneletter hauptkontakt" id='hauptkontakt'>


    
        <div class="newslettercomplete">
            <h2>Kontakt</h2>
            <p>Möchten Sie Kontakt mit uns aufnehmen? Wir bieten kostenlose Beratung an!</p>
        </div>
        
        <div class="formNewletter">
        
           
        
            <form name="Kontaktformular" on:submit={handlesubmitnewsletter} >
            
                <input type="text" name="names" id="names"  bind:value={nombre} placeholder="Ihrem Name">
                <input type="email" name="email" id="email"  bind:value={email} placeholder="Ihre Email">
                <input type="text" name="nachrichten" id="nachrichten"  bind:value={nachrichten} placeholder="Ihre Nachricht">
                <div class="contenidoimagenboton">
                    <img src={newsletterimage} alt=flechabuttom>
                <button type="submit">Senden</button>
    
                </div>
        
            </form>
            {#if formcorrect}
            <did class="suscritoanewsletter">
                <p>{messageform}</p>
            </did>
            {/if}
        </div>
    
    </div>
    
    
    <style lang="scss">

        #hauptkontakt{

            margin-top: 44px;
            margin-left: 2px;
            margin-right: 2px;

        }
    
    .todoneletter{
        border: 1px solid white;
    padding: 24px;
        display: flex;
    flex-direction: column;
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