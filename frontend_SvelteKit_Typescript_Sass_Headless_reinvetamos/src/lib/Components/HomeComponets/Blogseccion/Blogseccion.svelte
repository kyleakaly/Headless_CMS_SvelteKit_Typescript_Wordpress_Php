<script lang="ts">
    import { onMount } from "svelte";
  import { writable } from "svelte/store";

export let logotexto : string
export let flechasblogs : string
let blogservicios = writable(null)
let datosblogs : any[];

const cargarblogs = async (): Promise<void> => {
        try {
            const res = await fetch(import.meta.env.VITE_URL_BACKEND+'wp/v2/posts');
            const data = await res.json();
        
            blogservicios.set(data);
            const datosModificados = data.map((blog: any)  => {
            const fechaSinGuiones = blog.date.split("T")[0].replace(/-/g, ".");
            return { ...blog, date: fechaSinGuiones };
        });
            datosblogs = datosModificados
        } catch (error) {
            console.error('Error al realizar la solicitud:', error);
            throw error;
        }
    }

    onMount( async() => {
    await cargarblogs();
    });

    function truncateText(text:string, maxLength:number)  {
    if (text.length > maxLength) {
      return text.slice(0, maxLength) + '...';
    } else {
      return text;
    }
  }

</script>

<div class="contenidocompletoblogs">

    {#if $blogservicios != null}

    <div class="contenidocompletoblogs">
    <h2>Blogs</h2>
    <p>Hier finden Sie unsere Blogs über aktuelle Markeingnachrichten.</p>
    </div>

<div class="contenidoblogconflecha">

    <div class="contenidoblogsindividuales">
        {#each datosblogs as blogs }
            <div class="cajaindividual">
                <div class="imagenmasfecha">
                    <div class="fechablogs">
                        <p>Datum:</p>
                        <span>{blogs.date}</span>
                    </div>
                    <img src={blogs.featured_image_url} alt={blogs.title.rendered}>
                </div>
<!-- caja seccion -->
                <div class="contenidotextos">

<h3 class="tituloblogsindividuales">
    {blogs.title.rendered}
</h3>
<div class="tituloconlogo">
    <!-- <img src={logotexto} alt="logotexto"> -->
    {@html truncateText(blogs.excerpt.rendered,100)}
</div>
<a href={`${import.meta.env.VITE_PROD_URL}posts/${blogs.slug}`} style="color: #FF0093;">Mehr lesenh</a>

                </div>
                <div class="cajatagsundautor">
                    <div class="tags">
                        <span class="titulotags">tags:</span>
                        <div class="tagsindividuales">
                        {#each blogs.tag_names as tag }
                            <span>{tag}</span>
                        {/each}
                        </div>
                    </div>
                    <div class="author">
                        <span class="autor">Autor:</span>
                        <span class="nameauthor">{blogs.author_name}</span>
                    </div>
                </div>
<!-- fin cajaseccion -->
            </div>
        {/each}
    </div>

    <div class="flechaizquierdaderechablog">
        <div class="flechaizquierda"><img src={flechasblogs} alt="flechaizquierda"> </div>
        <div class="texto"><span>... gleiten ...</span></div>
        <div class="flechaderecha"><img src={flechasblogs} alt="flechaderecha"></div>
    </div>

</div>
   

{/if}

<a class="vertodoslosblogsboton" href={`${import.meta.env.VITE_PROD_URL}posts`}>Alle Blogs ansehen</a>

</div>

