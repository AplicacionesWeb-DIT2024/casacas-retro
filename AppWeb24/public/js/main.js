module.exports = {
    data() {
        return {
            form: {
                Nombre: '',
                Descripcion: '',
                Precio: '',
                Talle: '',
                Cantidad: '',
                Categoria: '',
                Imagen: null,
            },
            submiting: false,
            errors: {},
        };
    },
    mounted() {
        document.querySelector('input[name="Nombre"]').focus();
        this.createFormData();
    },
    methods: {
        handleFileChange(event) {
            this.form.Imagen = event.target.files[0];
            this.createFormData();
        },
        createFormData() {
            this.formData = new FormData();
            for (let key in this.form) {
                if (this.form.hasOwnProperty(key)) {
                    if (key === 'Imagen' && this.form[key] instanceof File) {
                        this.formData.append(key, this.form[key]);
                    } else if (key !== 'Imagen') {
                        this.formData.append(key, this.form[key]);
                    }
                }
            }
        },
        onSubmit() {
            console.log('Formulario de presentación...');
            this.submiting = true;
            axios.post(`{{ url('admin/camisetas') }}`, this.formData)
            .then(response => {
                console.log(response);
            })
            .catch(error => {
                console.error(error);
                this.errors = error?.response?.data?.errors;
            })
            .finally(() => {
                this.submiting = false;
            });
        },
    },
};
