export const load = async ({ fetch, params }: { fetch: Function }): Promise<{ api: any }> => {

    try {
   
       const res = await fetch(`${import.meta.env.VITE_URL_BACKEND}myroutes/services?slug=${params.slug}`);
               const data = await res.json();
               return{
                   api:data
               }
         
    } catch (error) {
       console.log(error)
       return {
         api :  null
       }
    }
   }