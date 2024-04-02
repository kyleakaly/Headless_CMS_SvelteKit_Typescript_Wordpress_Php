<script lang="ts" >

export let datoslista : any

let heightInicia : number = 0

const abrirMenuDespregable = (e: MouseEvent) => {
    const liElement = e.currentTarget as HTMLLIElement;
    const obtenerIcono = liElement.querySelector('.iconabrircerrar') as HTMLElement;
    const todosLosLi = document.querySelectorAll('.box-services ul li') as NodeListOf<HTMLLIElement>;

    // Cerrar todos los acordeones y restablecer el icono
    todosLosLi.forEach(li => {
        if (li !== liElement) {
            li.style.height = '60px';
            const icono = li.querySelector('.iconabrircerrar') as HTMLElement;
            icono.classList.remove('iconoabrirycerraractive');

            const h3 = li.querySelector('h3') as HTMLElement;
            h3.classList.remove('aqua-text');

        }
    });

    // Abrir o cerrar el acordeón clicado y cambiar el icono
    const height = liElement.offsetHeight === 60 ? liElement.scrollHeight : 60;
    liElement.style.height = `${height}px`;
    obtenerIcono.classList.toggle('iconoabrirycerraractive');

    const h3 = liElement.querySelector('h3') as HTMLElement;
    h3.classList.toggle('aqua-text');

};


</script>

<div class="box-services">
    <ul>  
        <li on:click={abrirMenuDespregable} >

            <div class="tituloicono">
                <h3>{datoslista.titulo_menuservicios1}</h3>

                <div class="iconabrircerrar">
                    <div class="linea1abrir"></div>
                    <div class="linea2abrir"></div>
                </div>

            </div>
 <div class="todoeltexto">
                <p>{datoslista.descripcion_menuservicios1}</p>
            </div>   
        </li>

        <li on:click={abrirMenuDespregable}>
            <div class="tituloicono">
                <h3>{datoslista.titulo_menuservicios2}</h3>

                <div class="iconabrircerrar">
                    <div class="linea1abrir"></div>
                    <div class="linea2abrir"></div>
                </div>

            </div>
            <div class="todoeltexto">
                <p>{datoslista.descripcion_menuservicios2}</p>
            </div>
           
        </li>

    </ul>
</div>

<style lang="scss" >
    .box-services{

        

        ul{
            width: 100%;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            gap: 20px;
            li{
                transition: 300ms;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: flex-start;
                border: 1px solid white;
                padding: 20px;
                height: 60px;
                overflow: hidden;
                z-index: 99;
                position: relative;
                gap: 20px;

                .tituloicono{
                    display: flex;
                    flex-direction: row;
                    flex-wrap: nowrap;
                    justify-content: space-between;
                    width: 100%;


                    h3{
                font-size: 2rem;
                
        transition: 300ms;
    

                }
                }

               
            }
        }

    }
</style>