// ScrollPositionStore.js
import { writable } from 'svelte/store';

// Creamos un store writable para almacenar la posición de desplazamiento
export const scrollPosition = writable(0);