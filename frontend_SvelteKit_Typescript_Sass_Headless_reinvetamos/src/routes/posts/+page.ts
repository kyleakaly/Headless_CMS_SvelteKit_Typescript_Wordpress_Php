export const load = async ({ fetch }: { fetch: Function }): Promise <{ api: string, texto: string }> => {
    try {
        const res = await fetch(import.meta.env.VITE_URL_BACKEND+'wp/v2/posts');
            const data = await res.json();
            
            return {
                api: data,
                texto: 'desde wordpress escribi'
            };
    } catch (error) {
        console.error('Error al realizar la solicitud:', error);
            throw error;
    }
}

