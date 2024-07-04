import Vue from 'vue';
import AppForm from '../app-components/Form/AppForm';


Vue.component('camiseta-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                Nombre:  '' ,
                Descripción:  '' ,
                Precio:  '' ,
                Talle:  '' ,
                Cantidad:  '' ,
                Categoría: '',
                Imagen: null,
            }
        }
    }
});