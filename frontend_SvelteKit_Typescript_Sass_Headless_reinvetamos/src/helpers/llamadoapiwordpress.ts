
 export const llamadaendpoinds = async (rutaendpoind: string): Promise<any> => {
    const apiurlbackend = import.meta.env.VITE_URL_BACKEND;

    try {
        const res = await fetch(`${apiurlbackend}${rutaendpoind}`);
        const data = await res.json();
        
        // Actualiza el valor de dataServices usando la función 'set' de la variable reactiva
        return data;
    } catch (error) {
        console.error('Error al realizar la solicitud:', error);
        throw error;
    }
}